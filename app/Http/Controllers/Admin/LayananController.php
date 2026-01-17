<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LayananController extends Controller
{
    public function index()
    {
        $layanans = Layanan::orderBy('urutan')->get();
        return view('admin.layanan.index', compact('layanans'));
    }

    public function create()
    {
        return view('admin.layanan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi_singkat' => 'nullable|string',
            'deskripsi_lengkap' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:10240',
            'fasilitas' => 'nullable|array',
            'harga' => 'nullable|numeric|min:0',
            'urutan' => 'required|integer|min:0',
            'unggulan' => 'boolean',
            'aktif' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['nama']);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $this->uploadImage($request->file('gambar'), 'layanan');
        }

        Layanan::create($validated);

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil ditambahkan');
    }

    public function show(Layanan $layanan)
    {
        return view('admin.layanan.show', compact('layanan'));
    }

    public function edit(Layanan $layanan)
    {
        return view('admin.layanan.edit', compact('layanan'));
    }

    public function update(Request $request, Layanan $layanan)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi_singkat' => 'nullable|string',
            'deskripsi_lengkap' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:10240',
            'fasilitas' => 'nullable|array',
            'harga' => 'nullable|numeric|min:0',
            'urutan' => 'required|integer|min:0',
            'unggulan' => 'boolean',
            'aktif' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['nama']);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $this->uploadImage(
                $request->file('gambar'), 
                'layanan', 
                $layanan->gambar
            );
        }

        $layanan->update($validated);

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil diupdate');
    }

    public function destroy(Layanan $layanan)
    {
        $this->deleteImage($layanan->gambar);
        $layanan->delete();

        return redirect()->route('admin.layanan.index')
            ->with('success', 'Layanan berhasil dihapus');
    }
}