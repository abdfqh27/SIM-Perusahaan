<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikels = Artikel::with('user')->latest()->get();
        return view('admin.artikel.index', compact('artikels'));
    }

    public function create()
    {
        return view('admin.artikel.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'konten' => 'required|string',
            'gambar_featured' => 'nullable|image|mimes:jpeg,jpg,png|max:10240',
            'kategori' => 'nullable|string|max:100',
            'tags' => 'nullable|string',
            'dipublikasi' => 'boolean',
            'tanggal_publikasi' => 'nullable|date'
        ]);

        $validated['user_id'] = auth()->id();
        $validated['slug'] = Str::slug($validated['judul']);

        if ($request->hasFile('gambar_featured')) {
            $validated['gambar_featured'] = $this->uploadImage($request->file('gambar_featured'), 'artikel');
        }

        // Convert tags string ke array
        if (!empty($validated['tags'])) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        }

        Artikel::create($validated);

        return redirect()->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil ditambahkan');
    }

    public function show(Artikel $artikel)
    {
        $artikel->load('user');
        return view('admin.artikel.show', compact('artikel'));
    }

    public function edit(Artikel $artikel)
    {
        return view('admin.artikel.edit', compact('artikel'));
    }

    public function update(Request $request, Artikel $artikel)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'konten' => 'required|string',
            'gambar_featured' => 'nullable|image|mimes:jpeg,jpg,png|max:10240',
            'kategori' => 'nullable|string|max:100',
            'tags' => 'nullable|string',
            'dipublikasi' => 'boolean',
            'tanggal_publikasi' => 'nullable|date'
        ]);

        $validated['slug'] = Str::slug($validated['judul']);

        if ($request->hasFile('gambar_featured')) {
            $validated['gambar_featured'] = $this->uploadImage(
                $request->file('gambar_featured'), 
                'artikel', 
                $artikel->gambar_featured
            );
        }

        // Convert tags string ke array
        if (!empty($validated['tags'])) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        }

        $artikel->update($validated);

        return redirect()->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil diupdate');
    }

    public function destroy(Artikel $artikel)
    {
        $this->deleteImage($artikel->gambar_featured);
        $artikel->delete();

        return redirect()->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil dihapus');
    }
}