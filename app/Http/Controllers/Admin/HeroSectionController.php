<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HeroSectionController extends Controller
{
    public function index()
    {
        $heroes = HeroSection::orderBy('urutan')->get();

        return view('admin.hero.index', compact('heroes'));
    }

    public function create()
    {
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
            'gambar' => 'required|image|mimes:jpeg,jpg,png,webp|max:10240',
            'aktif' => 'boolean',
        ], [
            'gambar.required' => 'Gambar wajib diupload',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus jpeg, jpg, png, atau webp',
            'gambar.max' => 'Ukuran gambar maksimal 10MB',
        ]);

        // Upload gambar (convert ke WebP HD)
        if ($request->hasFile('gambar')) {
            $validated['gambar'] = ImageHelper::uploadHDWebP(
                $request->file('gambar'),
                'hero',
                1920,
                90
            );
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
                'mimes:jpeg,jpg,png,webp',
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
            'gambar.required' => 'Gambar wajib diupload',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.mimes' => 'Format gambar harus jpeg, jpg, png, atau webp',
            'gambar.max' => 'Ukuran gambar maksimal 10MB',
            'urutan.required' => 'Urutan wajib diisi',
            'urutan.integer' => 'Urutan harus berupa angka',
            'urutan.min' => 'Urutan tidak boleh kurang dari 1',
            'urutan.max' => 'Urutan tidak boleh lebih dari '.HeroSection::max('urutan'),
        ]);

        $urutanLama = $heroSection->urutan;
        $urutanBaru = $validated['urutan'];

        // Upload gambar baru (convert ke WebP HD), hapus gambar lama
        if ($request->hasFile('gambar')) {
            if ($heroSection->gambar) {
                ImageHelper::delete($heroSection->gambar);
            }

            $validated['gambar'] = ImageHelper::uploadHDWebP(
                $request->file('gambar'),
                'hero',
                1920,
                90
            );
        }

        if ($urutanLama != $urutanBaru) {
            DB::transaction(function () use ($heroSection, $urutanLama, $urutanBaru, $validated) {

                // Langkah 1: Parkir hero yang diedit ke urutan sementara (negatif)
                DB::statement('UPDATE hero_section SET urutan = -1 WHERE id = ?', [$heroSection->id]);

                if ($urutanBaru < $urutanLama) {
                    // Pindah ke atas: geser ke bawah semua yang ada di antara urutanBaru s/d urutanLama-1
                    // ORDER BY DESC agar tidak bentrok unique constraint
                    DB::statement('
                        UPDATE hero_section
                        SET urutan = urutan + 1
                        WHERE urutan >= ?
                          AND urutan < ?
                        ORDER BY urutan DESC
                    ', [$urutanBaru, $urutanLama]);
                } else {
                    // Pindah ke bawah: geser ke atas semua yang ada di antara urutanLama+1 s/d urutanBaru
                    // ORDER BY ASC agar tidak bentrok unique constraint
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
            // Hapus gambar dari storage
            if ($heroSection->gambar) {
                ImageHelper::delete($heroSection->gambar);
            }

            $heroSection->delete();

            // Rapikan urutan: semua di bawahnya naik satu
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
}
