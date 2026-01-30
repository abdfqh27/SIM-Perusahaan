<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSectionController extends Controller
{
    public function index()
    {
        $heroes = HeroSection::orderBy('urutan')->get();

        return view('admin.hero.index', compact('heroes'));
    }

    public function create()
    {
        // Ambil urutan terakhir + 1 untuk urutan baru otomatis
        $nextUrutan = HeroSection::max('urutan') + 1;

        return view('admin.hero.create', compact('nextUrutan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tombol_text' => 'nullable|string|max:100',
            'tombol_link' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:10240',
            'aktif' => 'boolean',
        ]);

        // Upload gambar jika ada
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $this->handleImageUpload($request->file('gambar'), 'hero');
        }

        // Set urutan otomatis ke urutan terakhir + 1
        $validated['urutan'] = HeroSection::max('urutan') + 1;

        HeroSection::create($validated);

        return redirect()->route('admin.hero.index')
            ->with('success', 'Hero section berhasil ditambahkan ke urutan '.$validated['urutan']);
    }

    public function show(HeroSection $heroSection)
    {
        return view('admin.hero.show', compact('heroSection'));
    }

    public function edit(HeroSection $heroSection)
    {
        // Ambil semua hero untuk dropdown urutan
        $allHeroes = HeroSection::orderBy('urutan')->get();
        $maxUrutan = HeroSection::max('urutan');

        return view('admin.hero.edit', compact('heroSection', 'allHeroes', 'maxUrutan'));
    }

    public function update(Request $request, HeroSection $heroSection)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tombol_text' => 'nullable|string|max:100',
            'tombol_link' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:10240',
            'urutan' => [
                'required',
                'integer',
                'min:1',
                'max:'.HeroSection::max('urutan'),
            ],
            'aktif' => 'boolean',
        ], [
            'urutan.required' => 'Urutan wajib diisi',
            'urutan.integer' => 'Urutan harus berupa angka',
            'urutan.min' => 'Urutan tidak boleh kurang dari 1',
            'urutan.max' => 'Urutan tidak boleh lebih dari '.HeroSection::max('urutan'),
        ]);

        $urutanLama = $heroSection->urutan;
        $urutanBaru = $validated['urutan'];

        // Upload gambar baru jika ada
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $this->handleImageUpload(
                $request->file('gambar'),
                'hero',
                $heroSection->gambar
            );
        }

        // Cek apakah urutan berubah
        if ($urutanLama != $urutanBaru) {
            // Geser urutan hero lain menggunakan temporary value
            \Illuminate\Support\Facades\DB::transaction(function () use ($heroSection, $urutanLama, $urutanBaru, $validated) {

                // Hitung temporary value yang aman (lebih besar dari max urutan)
                $maxUrutan = HeroSection::max('urutan');
                $tempValue = $maxUrutan + 1000; // Gunakan nilai yang pasti tidak konflik

                // Set hero yang sedang diedit ke temporary value
                // Ini untuk menghindari konflik unique constraint
                $heroSection->timestamps = false;
                $heroSection->urutan = $tempValue;
                $heroSection->save();

                if ($urutanBaru < $urutanLama) {
                    // Pindah ke atas (misal dari urutan 4 ke 2)
                    // Semua hero yang ada di antara urutan 2-3 harus turun (increment)
                    // Contoh: urutan 2 jadi 3, urutan 3 jadi 4
                    HeroSection::where('urutan', '>=', $urutanBaru)
                        ->where('urutan', '<', $urutanLama)
                        ->increment('urutan');

                } else {
                    // Pindah ke bawah (misal dari urutan 2 ke 4)
                    // Semua hero yang ada di antara urutan 3-4 harus naik (decrement)
                    // Contoh: urutan 3 jadi 2, urutan 4 jadi 3
                    HeroSection::where('urutan', '<=', $urutanBaru)
                        ->where('urutan', '>', $urutanLama)
                        ->decrement('urutan');
                }

                // Set hero ke urutan yang baru
                $heroSection->timestamps = true;
                $validated['urutan'] = $urutanBaru;

                $heroSection->fill($validated);
                $heroSection->save();
            });
        } else {
            // Jika urutan tidak berubah, update biasa
            $heroSection->update($validated);
        }

        return redirect()->route('admin.hero.index')
            ->with('success', 'Hero section berhasil diupdate'.
                ($urutanLama != $urutanBaru ? ' dan dipindah dari urutan '.$urutanLama.' ke urutan '.$urutanBaru : ''));
    }

    public function destroy(HeroSection $heroSection)
    {
        $urutanDihapus = $heroSection->urutan;

        \Illuminate\Support\Facades\DB::transaction(function () use ($heroSection, $urutanDihapus) {
            // Hapus gambar jika ada
            $this->handleImageDelete($heroSection->gambar);

            // Hapus hero
            $heroSection->delete();

            // Rapikan urutan setelah dihapus (urutan di bawahnya naik semua)
            HeroSection::where('urutan', '>', $urutanDihapus)
                ->decrement('urutan');
        });

        return redirect()->route('admin.hero.index')
            ->with('success', 'Hero section berhasil dihapus dan urutan disesuaikan');
    }

    protected function handleImageUpload(\Illuminate\Http\UploadedFile $file, string $folder, ?string $oldImage = null): string
    {
        // Hapus gambar lama jika ada
        if ($oldImage) {
            $this->handleImageDelete($oldImage);
        }

        // Upload gambar baru
        $filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
        $path = $file->storeAs($folder, $filename, 'public');

        return $path;
    }

    protected function handleImageDelete(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
