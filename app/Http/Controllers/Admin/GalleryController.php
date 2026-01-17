<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::orderBy('urutan')->get();
        return view('admin.gallery.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'required|image|mimes:jpeg,jpg,png|max:10240',
            'kategori' => 'nullable|string|max:100',
            'urutan' => 'required|integer|min:0',
            'tampilkan' => 'boolean'
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $this->uploadImage($request->file('gambar'), 'gallery');
        }

        Gallery::create($validated);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Galeri berhasil ditambahkan');
    }

    public function show(Gallery $gallery)
    {
        return view('admin.gallery.show', compact('gallery'));
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:10240',
            'kategori' => 'nullable|string|max:100',
            'urutan' => 'required|integer|min:0',
            'tampilkan' => 'boolean'
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $this->uploadImage(
                $request->file('gambar'), 
                'gallery', 
                $gallery->gambar
            );
        }

        $gallery->update($validated);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Galeri berhasil diupdate');
    }

    public function destroy(Gallery $gallery)
    {
        $this->deleteImage($gallery->gambar);
        $gallery->delete();

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Galeri berhasil dihapus');
    }
}