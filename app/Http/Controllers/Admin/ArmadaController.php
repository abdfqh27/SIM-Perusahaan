<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateHelper;
use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Armada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ArmadaController extends Controller
{
    public function __construct()
    {
        // Set timezone default ke WIB
        DateHelper::setDefaultTimezone();
    }

    public function index()
    {
        $armadas = Armada::orderBy('urutan')->get();

        return view('admin.armada.index', compact('armadas'));
    }

    public function create()
    {
        // Ambil urutan terakhir + 1 untuk urutan baru otomatis
        $nextUrutan = Armada::max('urutan') + 1;

        // Get daftar tipe bus
        $daftarTipeBus = Armada::getDaftarTipeBus();

        return view('admin.armada.create', compact('nextUrutan', 'daftarTipeBus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:armada,slug',
            'tipe_bus' => 'required|string|max:50',
            'kapasitas_min' => 'required|integer|min:1',
            'kapasitas_max' => 'required|integer|min:1|gte:kapasitas_min',
            'deskripsi' => 'nullable|string',
            'gambar_utama' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
            'galeri.*' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'string|max:100',
            'unggulan' => 'boolean',
            'tersedia' => 'boolean',
        ], [
            'nama.required' => 'Nama armada wajib diisi',
            'tipe_bus.required' => 'Tipe bus wajib dipilih',
            'kapasitas_min.required' => 'Kapasitas minimum wajib diisi',
            'kapasitas_max.required' => 'Kapasitas maximum wajib diisi',
            'kapasitas_max.gte' => 'Kapasitas maximum harus lebih besar atau sama dengan kapasitas minimum',
            'gambar_utama.image' => 'File harus berupa gambar',
            'gambar_utama.max' => 'Ukuran gambar maksimal 10MB',
            'galeri.*.image' => 'File galeri harus berupa gambar',
            'galeri.*.max' => 'Ukuran gambar galeri maksimal 10MB',
        ]);

        // Generate slug jika tidak ada
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['nama']);
        }

        // Upload gambar utama jika ada (convert ke WebP HD)
        if ($request->hasFile('gambar_utama')) {
            $validated['gambar_utama'] = ImageHelper::uploadHDWebP(
                $request->file('gambar_utama'),
                'armada',
                1920,
                90
            );
        }

        // Upload galeri jika ada (convert ke WebP HD)
        $galeriPaths = [];
        if ($request->hasFile('galeri')) {
            foreach ($request->file('galeri') as $galeriFile) {
                $galeriPaths[] = ImageHelper::uploadHDWebP(
                    $galeriFile,
                    'armada/galeri',
                    1920,
                    90
                );
            }
        }
        $validated['galeri'] = $galeriPaths;

        // Set urutan otomatis ke urutan terakhir + 1
        // Tapi kita set manual untuk keamanan
        $validated['urutan'] = Armada::max('urutan') + 1;

        // Buat armada baru
        $armada = Armada::create($validated);

        return redirect()->route('admin.armada.index')
            ->with('success', 'Armada "'.$armada->nama.'" berhasil ditambahkan ke urutan '.$armada->urutan);
    }

    public function show(Armada $armada)
    {
        return view('admin.armada.show', compact('armada'));
    }

    public function edit(Armada $armada)
    {
        // Ambil semua armada untuk dropdown urutan
        $allArmadas = Armada::orderBy('urutan')->get();
        $maxUrutan = Armada::max('urutan');

        // Get daftar tipe bus
        $daftarTipeBus = Armada::getDaftarTipeBus();

        return view('admin.armada.edit', compact('armada', 'allArmadas', 'maxUrutan', 'daftarTipeBus'));
    }

    public function update(Request $request, Armada $armada)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:armada,slug,'.$armada->id,
            'tipe_bus' => 'required|string|max:50',
            'kapasitas_min' => 'required|integer|min:1',
            'kapasitas_max' => 'required|integer|min:1|gte:kapasitas_min',
            'deskripsi' => 'nullable|string',
            'gambar_utama' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
            'galeri.*' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:10240',
            'galeri_lama' => 'nullable|array',
            'hapus_galeri' => 'nullable|array',
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'string|max:100',
            'urutan' => [
                'required',
                'integer',
                'min:1',
                'max:'.Armada::max('urutan'),
            ],
            'unggulan' => 'boolean',
            'tersedia' => 'boolean',
        ], [
            'nama.required' => 'Nama armada wajib diisi',
            'tipe_bus.required' => 'Tipe bus wajib dipilih',
            'kapasitas_min.required' => 'Kapasitas minimum wajib diisi',
            'kapasitas_max.required' => 'Kapasitas maximum wajib diisi',
            'kapasitas_max.gte' => 'Kapasitas maximum harus lebih besar atau sama dengan kapasitas minimum',
            'urutan.required' => 'Urutan wajib diisi',
            'urutan.integer' => 'Urutan harus berupa angka',
            'urutan.min' => 'Urutan tidak boleh kurang dari 1',
            'urutan.max' => 'Urutan tidak boleh lebih dari '.Armada::max('urutan'),
        ]);

        $urutanLama = $armada->urutan;
        $urutanBaru = $validated['urutan'];

        // Upload gambar utama baru jika ada
        if ($request->hasFile('gambar_utama')) {
            // Hapus gambar lama
            if ($armada->gambar_utama) {
                ImageHelper::delete($armada->gambar_utama);
            }

            // Upload gambar baru (convert ke WebP HD)
            $validated['gambar_utama'] = ImageHelper::uploadHDWebP(
                $request->file('gambar_utama'),
                'armada',
                1920,
                90
            );
        }

        // Handle galeri
        $galeriPaths = $armada->galeri ?? [];

        // Hapus gambar yang dipilih untuk dihapus
        if ($request->has('hapus_galeri') && is_array($request->hapus_galeri)) {
            foreach ($request->hapus_galeri as $pathToDelete) {
                ImageHelper::delete($pathToDelete);
                $galeriPaths = array_values(array_filter($galeriPaths, function ($path) use ($pathToDelete) {
                    return $path !== $pathToDelete;
                }));
            }
        }

        // Upload galeri baru jika ada
        if ($request->hasFile('galeri')) {
            foreach ($request->file('galeri') as $galeriFile) {
                $galeriPaths[] = ImageHelper::uploadHDWebP(
                    $galeriFile,
                    'armada/galeri',
                    1920,
                    90
                );
            }
        }

        $validated['galeri'] = $galeriPaths;

        // Cek apakah urutan berubah
        if ($urutanLama != $urutanBaru) {
            // Geser urutan armada lain menggunakan temporary value (sama seperti HeroSection)
            DB::transaction(function () use ($armada, $urutanLama, $urutanBaru, $validated) {

                // Hitung temporary value yang aman (lebih besar dari max urutan)
                $maxUrutan = Armada::max('urutan');
                $tempValue = $maxUrutan + 1000; // Gunakan nilai yang pasti tidak konflik

                // Set armada yang sedang diedit ke temporary value
                // Ini untuk menghindari konflik unique constraint
                $armada->timestamps = false;
                $armada->urutan = $tempValue;
                $armada->save();

                if ($urutanBaru < $urutanLama) {
                    // Pindah ke atas (misal dari urutan 4 ke 2)
                    // Semua armada yang ada di antara urutan 2-3 harus turun (increment)
                    // Contoh: urutan 2 jadi 3, urutan 3 jadi 4
                    Armada::where('urutan', '>=', $urutanBaru)
                        ->where('urutan', '<', $urutanLama)
                        ->increment('urutan');

                } else {
                    // Pindah ke bawah (misal dari urutan 2 ke 4)
                    // Semua armada yang ada di antara urutan 3-4 harus naik (decrement)
                    // Contoh: urutan 3 jadi 2, urutan 4 jadi 3
                    Armada::where('urutan', '<=', $urutanBaru)
                        ->where('urutan', '>', $urutanLama)
                        ->decrement('urutan');
                }

                // Set armada ke urutan yang baru
                $armada->timestamps = true;
                $validated['urutan'] = $urutanBaru;

                $armada->fill($validated);
                $armada->save();
            });
        } else {
            // Jika urutan tidak berubah, update biasa
            $armada->update($validated);
        }

        return redirect()->route('admin.armada.index')
            ->with('success', 'Armada "'.$armada->nama.'" berhasil diupdate'.
                ($urutanLama != $urutanBaru ? ' dan dipindah dari urutan '.$urutanLama.' ke urutan '.$urutanBaru : ''));
    }

    // Hapus resource spesifik dari penyimpanan
    public function destroy(Armada $armada)
    {
        $urutanDihapus = $armada->urutan;
        $namaArmada = $armada->nama;

        DB::transaction(function () use ($armada, $urutanDihapus) {
            // Hapus gambar utama jika ada
            if ($armada->gambar_utama) {
                ImageHelper::delete($armada->gambar_utama);
            }

            // Hapus semua gambar galeri jika ada
            if ($armada->galeri && is_array($armada->galeri)) {
                foreach ($armada->galeri as $galeriPath) {
                    ImageHelper::delete($galeriPath);
                }
            }

            // Hapus armada
            $armada->delete();

            // Rapikan urutan setelah dihapus (urutan di bawahnya naik semua)
            Armada::where('urutan', '>', $urutanDihapus)
                ->decrement('urutan');
        });

        return redirect()->route('admin.armada.index')
            ->with('success', 'Armada "'.$namaArmada.'" berhasil dihapus dan urutan disesuaikan');
    }

    // Method untuk menghapus satu gambar galeri via AJAX
    public function deleteGaleriImage(Request $request, Armada $armada)
    {
        $request->validate([
            'image_path' => 'required|string',
        ]);

        $imagePath = $request->image_path;

        // Ambil galeri saat ini
        $galeri = $armada->galeri ?? [];

        // Cek apakah path ada di galeri
        if (in_array($imagePath, $galeri)) {
            // Hapus file dari storage
            ImageHelper::delete($imagePath);

            // Hapus dari array galeri
            $galeri = array_values(array_filter($galeri, function ($path) use ($imagePath) {
                return $path !== $imagePath;
            }));

            // Update armada
            $armada->galeri = $galeri;
            $armada->save();

            return response()->json([
                'success' => true,
                'message' => 'Gambar berhasil dihapus',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gambar tidak ditemukan',
        ], 404);
    }
}
