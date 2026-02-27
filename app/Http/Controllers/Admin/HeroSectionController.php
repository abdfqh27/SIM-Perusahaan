<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            'deskripsi' => 'required|string',
            'tombol_text' => 'required|string|max:100',
            'tombol_link' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,jpg,png|max:10240',
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
            'deskripsi' => 'required|string',
            'tombol_text' => 'required|string|max:100',
            'tombol_link' => 'required|string|max:255',
            'gambar' => [
                $heroSection->gambar ? 'nullable' : 'required',
                'image',
                'mimes:jpeg,jpg,png',
                'max:10240',
            ],
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

        if ($urutanLama != $urutanBaru) {
            DB::transaction(function () use ($heroSection, $urutanLama, $urutanBaru, $validated) {

                // Langkah 1: Parkir hero yang diedit ke urutan sementara (negatif)
                DB::statement('UPDATE hero_section SET urutan = -1 WHERE id = ?', [$heroSection->id]);

                if ($urutanBaru < $urutanLama) {
                    // Pindah ke atas (contoh: urutan 3 -> 1)
                    // Hero di urutan 1, 2 harus bergeser ke 2, 3
                    // ORDER BY DESC: proses terbesar dulu → tidak bentrok unique constraint
                    DB::statement('
                        UPDATE hero_section
                        SET urutan = urutan + 1
                        WHERE urutan >= ?
                          AND urutan < ?
                        ORDER BY urutan DESC
                    ', [$urutanBaru, $urutanLama]);
                } else {
                    // Pindah ke bawah (contoh: urutan 1 -> 3)
                    // Hero di urutan 2, 3 harus bergeser ke 1, 2
                    // ORDER BY ASC: proses terkecil dulu → tidak bentrok unique constraint
                    DB::statement('
                        UPDATE hero_section
                        SET urutan = urutan - 1
                        WHERE urutan > ?
                          AND urutan <= ?
                        ORDER BY urutan ASC
                    ', [$urutanLama, $urutanBaru]);
                }

                // Langkah 3: Pindahkan hero ke urutan tujuan yang sudah kosong
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
                ($urutanLama != $urutanBaru
                    ? ' dan dipindah dari urutan '.$urutanLama.' ke urutan '.$urutanBaru
                    : ''));
    }

    public function destroy(HeroSection $heroSection)
    {
        $urutanDihapus = $heroSection->urutan;

        DB::transaction(function () use ($heroSection, $urutanDihapus) {
            // Hapus gambar jika ada
            $this->handleImageDelete($heroSection->gambar);

            // Hapus hero
            $heroSection->delete();

            // Rapikan urutan setelah dihapus (urutan di bawahnya naik semua)
            // ORDER BY ASC agar decrement tidak bentrok unique constraint
            DB::statement('
                UPDATE hero_section
                SET urutan = urutan - 1
                WHERE urutan > ?
                ORDER BY urutan ASC
            ', [$urutanDihapus]);
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
