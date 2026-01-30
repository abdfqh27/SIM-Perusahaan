<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class LayananController extends Controller
{
    public function __construct()
    {
        // Set timezone default ke WIB
        DateHelper::setDefaultTimezone();
    }

    public function index()
    {
        $layanans = Layanan::orderBy('urutan')->get();

        return view('admin.layanan.index', compact('layanans'));
    }

    public function create()
    {
        // Ambil urutan terakhir + 1
        $nextUrutan = Layanan::max('urutan') + 1;

        return view('admin.layanan.create', compact('nextUrutan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('layanan', 'slug')->where(function ($query) use ($request) {
                    return $query->where('slug', Str::slug($request->nama));
                }),
            ],
            'deskripsi_singkat' => 'nullable|string',
            'deskripsi_lengkap' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:10240',
            'fasilitas' => 'nullable|array',
            'unggulan' => 'boolean',
            'aktif' => 'boolean',
        ], [
            'nama.unique' => 'Nama layanan sudah digunakan, silakan gunakan nama lain',
        ]);

        $validated['slug'] = Str::slug($validated['nama']);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $this->handleImageUpload($request->file('gambar'), 'layanan');
        }

        // Set urutan otomatis (urutan terakhir + 1)
        $validated['urutan'] = Layanan::max('urutan') + 1;

        // Set created_at dan updated_at dengan waktu sekarang menggunakan DateHelper
        $validated['created_at'] = DateHelper::now();
        $validated['updated_at'] = DateHelper::now();

        Layanan::create($validated);

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil ditambahkan pada '.DateHelper::formatDateTimeIndonesia(DateHelper::now()));
    }

    public function show(Layanan $layanan)
    {
        return view('admin.layanan.show', compact('layanan'));
    }

    public function edit(Layanan $layanan)
    {
        // Ambil semua layanan untuk dropdown urutan
        $allLayanans = Layanan::orderBy('urutan')->get();
        $maxUrutan = Layanan::max('urutan');

        return view('admin.layanan.edit', compact('layanan', 'allLayanans', 'maxUrutan'));
    }

    public function update(Request $request, Layanan $layanan)
    {
        $validated = $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('layanan', 'slug')
                    ->ignore($layanan->id)
                    ->where(function ($query) use ($request) {
                        return $query->where('slug', Str::slug($request->nama));
                    }),
            ],
            'deskripsi_singkat' => 'nullable|string',
            'deskripsi_lengkap' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:10240',
            'fasilitas' => 'nullable|array',
            'urutan' => [
                'required',
                'integer',
                'min:1',
                'max:'.Layanan::max('urutan'),
            ],
            'unggulan' => 'boolean',
            'aktif' => 'boolean',
        ], [
            'nama.unique' => 'Nama layanan sudah digunakan, silakan gunakan nama lain',
            'urutan.required' => 'Urutan wajib diisi',
            'urutan.integer' => 'Urutan harus berupa angka',
            'urutan.min' => 'Urutan tidak boleh kurang dari 1',
            'urutan.max' => 'Urutan tidak boleh lebih dari '.Layanan::max('urutan'),
        ]);

        $validated['slug'] = Str::slug($validated['nama']);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $this->handleImageUpload(
                $request->file('gambar'),
                'layanan',
                $layanan->gambar
            );
        }

        // Cek apakah urutan berubah
        $urutanLama = $layanan->urutan;
        $urutanBaru = $validated['urutan'];

        if ($urutanLama != $urutanBaru) {
            // Geser urutan layanan lain menggunakan temporary value
            DB::transaction(function () use ($layanan, $urutanLama, $urutanBaru, $validated) {

                // Hitung temporary value yang aman (lebih besar dari max urutan)
                $maxUrutan = Layanan::max('urutan');
                $tempValue = $maxUrutan + 1000; // Gunakan nilai yang pasti tidak konflik

                // Set layanan yang sedang diedit ke temporary value
                // Ini untuk menghindari konflik unique constraint
                $layanan->timestamps = false;
                $layanan->urutan = $tempValue;
                $layanan->save();

                if ($urutanBaru < $urutanLama) {
                    // Pindah ke atas (misal dari urutan 4 ke 2)
                    // Semua layanan yang ada di antara urutan 2-3 harus turun (increment)
                    // Contoh: urutan 2 jadi 3, urutan 3 jadi 4
                    Layanan::where('urutan', '>=', $urutanBaru)
                        ->where('urutan', '<', $urutanLama)
                        ->increment('urutan');

                } else {
                    // Pindah ke bawah (misal dari urutan 2 ke 4)
                    // Semua layanan yang ada di antara urutan 3-4 harus naik (decrement)
                    // Contoh: urutan 3 jadi 2, urutan 4 jadi 3
                    Layanan::where('urutan', '<=', $urutanBaru)
                        ->where('urutan', '>', $urutanLama)
                        ->decrement('urutan');
                }

                // Set layanan ke urutan yang baru
                $layanan->timestamps = true;
                $validated['updated_at'] = DateHelper::now();
                $validated['urutan'] = $urutanBaru;

                $layanan->fill($validated);
                $layanan->save();
            });
        } else {
            // Jika urutan tidak berubah, update biasa
            $validated['updated_at'] = DateHelper::now();
            $layanan->update($validated);
        }

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil diupdate pada '.DateHelper::formatDateTimeIndonesia(DateHelper::now()));
    }

    public function destroy(Layanan $layanan)
    {
        $urutanDihapus = $layanan->urutan;

        DB::transaction(function () use ($layanan, $urutanDihapus) {
            $this->handleImageDelete($layanan->gambar);
            $layanan->delete();

            // Rapikan urutan setelah dihapus (urutan di bawahnya naik semua)
            Layanan::where('urutan', '>', $urutanDihapus)
                ->decrement('urutan');
        });

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil dihapus pada '.DateHelper::formatDateTimeIndonesia(DateHelper::now()));
    }

    protected function handleImageUpload($file, $folder, $oldImage = null)
    {
        if ($oldImage) {
            $this->handleImageDelete($oldImage);
        }

        $path = public_path('uploads/'.$folder);
        if (! file_exists($path)) {
            mkdir($path, 0755, true);
        }

        // Generate unique filename
        $filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();

        // Move file
        $file->move($path, $filename);

        return 'uploads/'.$folder.'/'.$filename;
    }

    protected function handleImageDelete($imagePath)
    {
        if ($imagePath && file_exists(public_path($imagePath))) {
            unlink(public_path($imagePath));
        }
    }
}
