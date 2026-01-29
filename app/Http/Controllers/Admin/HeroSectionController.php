<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use Illuminate\Http\Request;

class HeroSectionController extends Controller
{
    public function index()
    {
        $heroes = HeroSection::orderBy('urutan')->get();

        return view('admin.hero.index', compact('heroes'));
    }

    public function create()
    {
        return view('admin.hero.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tombol_text' => 'nullable|string|max:100',
            'tombol_link' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:10240',
            'urutan' => 'required|integer|min:1|unique:hero_section,urutan',
            'aktif' => 'boolean',
        ], [
            // CUSTOM ERROR MESSAGES
            'urutan.required' => 'Urutan harus diisi.',
            'urutan.integer' => 'Urutan harus berupa angka.',
            'urutan.min' => 'Urutan minimal dimulai dari 1.',
            'urutan.unique' => 'Urutan :input sudah digunakan. Silakan pilih urutan yang berbeda.',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $this->uploadImage($request->file('gambar'), 'hero');
        }

        HeroSection::create($validated);

        return redirect()->route('admin.hero.index')
            ->with('success', 'Hero section berhasil ditambahkan');
    }

    public function show(HeroSection $heroSection)
    {
        return view('admin.hero.show', compact('heroSection'));
    }

    public function edit(HeroSection $heroSection)
    {
        return view('admin.hero.edit', compact('heroSection'));
    }

    public function update(Request $request, HeroSection $heroSection)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tombol_text' => 'nullable|string|max:100',
            'tombol_link' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:10240',
            'urutan' => 'required|integer|min:1|unique:hero_section,urutan,'.$heroSection->id,
            'aktif' => 'boolean',
        ], [
            // CUSTOM ERROR MESSAGES
            'urutan.required' => 'Urutan harus diisi.',
            'urutan.integer' => 'Urutan harus berupa angka.',
            'urutan.min' => 'Urutan minimal dimulai dari 1.',
            'urutan.unique' => 'Urutan :input sudah digunakan oleh hero section lain. Silakan pilih urutan yang berbeda.',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $this->uploadImage(
                $request->file('gambar'),
                'hero',
                $heroSection->gambar
            );
        }

        $heroSection->update($validated);

        return redirect()->route('admin.hero.index')
            ->with('success', 'Hero section berhasil diupdate');
    }

    public function destroy(HeroSection $heroSection)
    {
        $this->deleteImage($heroSection->gambar);
        $heroSection->delete();

        return redirect()->route('admin.hero.index')
            ->with('success', 'Hero section berhasil dihapus');
    }
}
