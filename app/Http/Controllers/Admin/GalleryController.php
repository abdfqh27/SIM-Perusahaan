<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateHelper;
use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GalleryController extends Controller
{
    public function __construct()
    {
        // Set timezone default ke WIB untuk realtime
        DateHelper::setDefaultTimezone();
    }

    public function index()
    {
        $galleries = Gallery::orderBy('urutan')->get();

        return view('admin.gallery.index', compact('galleries'));
    }

    public function create()
    {
        // Ambil urutan terakhir + 1 untuk urutan baru otomatis
        $nextUrutan = Gallery::max('urutan') + 1;

        // Get daftar kategori
        $daftarKategori = Gallery::getDaftarKategori();

        return view('admin.gallery.create', compact('nextUrutan', 'daftarKategori'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'required|image|mimes:jpeg,jpg,png,webp|max:10240',
            'kategori' => 'nullable|string|max:50',
        ], [
            'judul.required' => 'Judul wajib diisi',
            'gambar.required' => 'Gambar wajib diupload',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.max' => 'Ukuran gambar maksimal 10MB',
        ]);

        // Upload gambar dengan format WebP HD (ukuran kecil tapi tetap HD)
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = ImageHelper::uploadHDWebP(
                $request->file('gambar'),
                'gallery',
                1920, // Max width untuk HD
                90    // Quality tinggi
            );
        }

        // Set urutan otomatis ke urutan terakhir + 1
        $validated['urutan'] = Gallery::max('urutan') + 1;

        // Set tampilkan - checkbox akan bernilai 'on' jika dicentang, null jika tidak
        $validated['tampilkan'] = $request->has('tampilkan');

        // Buat gallery baru dengan timestamp realtime
        $gallery = Gallery::create($validated);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gallery "'.$gallery->judul.'" berhasil ditambahkan ke urutan '.$gallery->urutan);
    }

    public function show(Gallery $gallery)
    {
        return view('admin.gallery.show', compact('gallery'));
    }

    public function edit(Gallery $gallery)
    {
        // Ambil semua gallery untuk dropdown urutan
        $allGalleries = Gallery::orderBy('urutan')->get();
        $maxUrutan = Gallery::max('urutan');

        // Get daftar kategori
        $daftarKategori = Gallery::getDaftarKategori();

        return view('admin.gallery.edit', compact('gallery', 'allGalleries', 'maxUrutan', 'daftarKategori'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
            'kategori' => 'nullable|string|max:50',
            'urutan' => [
                'required',
                'integer',
                'min:1',
                'max:'.Gallery::max('urutan'),
            ],
        ], [
            'judul.required' => 'Judul wajib diisi',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.max' => 'Ukuran gambar maksimal 10MB',
            'urutan.required' => 'Urutan wajib diisi',
            'urutan.integer' => 'Urutan harus berupa angka',
            'urutan.min' => 'Urutan tidak boleh kurang dari 1',
            'urutan.max' => 'Urutan tidak boleh lebih dari '.Gallery::max('urutan'),
        ]);

        $urutanLama = $gallery->urutan;
        $urutanBaru = $validated['urutan'];

        // Upload gambar baru jika ada dan hapus gambar lama
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama dari storage
            if ($gallery->gambar) {
                ImageHelper::delete($gallery->gambar);
            }

            // Upload gambar baru dengan format WebP HD
            $validated['gambar'] = ImageHelper::uploadHDWebP(
                $request->file('gambar'),
                'gallery',
                1920, // Max width untuk HD
                90    // Quality tinggi
            );
        }

        // Set tampilkan - checkbox akan bernilai 'on' jika dicentang, null jika tidak
        $validated['tampilkan'] = $request->has('tampilkan');

        // Cek apakah urutan berubah
        if ($urutanLama != $urutanBaru) {
            // Geser urutan gallery lain menggunakan temporary value (sama seperti Armada)
            DB::transaction(function () use ($gallery, $urutanLama, $urutanBaru, $validated) {

                // Hitung temporary value yang aman (lebih besar dari max urutan)
                $maxUrutan = Gallery::max('urutan');
                $tempValue = $maxUrutan + 1000; // Gunakan nilai yang pasti tidak konflik

                // Set gallery yang sedang diedit ke temporary value
                // Ini untuk menghindari konflik unique constraint
                $gallery->timestamps = false;
                $gallery->urutan = $tempValue;
                $gallery->save();

                if ($urutanBaru < $urutanLama) {
                    // Pindah ke atas (misal dari urutan 4 ke 2)
                    // Semua gallery yang ada di antara urutan 2-3 harus turun (increment)
                    // Contoh: urutan 2 jadi 3, urutan 3 jadi 4
                    Gallery::where('urutan', '>=', $urutanBaru)
                        ->where('urutan', '<', $urutanLama)
                        ->increment('urutan');

                } else {
                    // Pindah ke bawah (misal dari urutan 2 ke 4)
                    // Semua gallery yang ada di antara urutan 3-4 harus naik (decrement)
                    // Contoh: urutan 3 jadi 2, urutan 4 jadi 3
                    Gallery::where('urutan', '<=', $urutanBaru)
                        ->where('urutan', '>', $urutanLama)
                        ->decrement('urutan');
                }

                // Set gallery ke urutan yang baru
                $gallery->timestamps = true;
                $validated['urutan'] = $urutanBaru;

                $gallery->fill($validated);
                $gallery->save();
            });
        } else {
            // Jika urutan tidak berubah, update biasa
            // Timestamp akan otomatis terupdate dengan timezone realtime
            $gallery->update($validated);
        }

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gallery "'.$gallery->judul.'" berhasil diupdate'.
                ($urutanLama != $urutanBaru ? ' dan dipindah dari urutan '.$urutanLama.' ke urutan '.$urutanBaru : ''));
    }

    public function destroy(Gallery $gallery)
    {
        $urutanDihapus = $gallery->urutan;
        $judulGallery = $gallery->judul;

        DB::transaction(function () use ($gallery, $urutanDihapus) {
            // Hapus gambar dari storage
            if ($gallery->gambar) {
                ImageHelper::delete($gallery->gambar);
            }

            // Hapus gallery dari database
            $gallery->delete();

            // Rapikan urutan setelah dihapus (urutan di bawahnya naik semua)
            Gallery::where('urutan', '>', $urutanDihapus)
                ->decrement('urutan');
        });

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gallery "'.$judulGallery.'" berhasil dihapus dan urutan disesuaikan');
    }

    public function toggleTampilkan(Gallery $gallery)
    {
        $gallery->tampilkan = ! $gallery->tampilkan;
        $gallery->save();

        return response()->json([
            'success' => true,
            'tampilkan' => $gallery->tampilkan,
            'message' => 'Status tampilkan berhasil diubah',
        ]);
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*' => 'required|integer|exists:gallery,id',
        ]);

        DB::transaction(function () use ($request) {
            foreach ($request->orders as $urutan => $galleryId) {
                Gallery::where('id', $galleryId)->update([
                    'urutan' => $urutan + 1, // +1 karena index array mulai dari 0
                ]);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Urutan gallery berhasil diubah',
        ]);
    }
}
