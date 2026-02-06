<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriBus;
use Illuminate\Http\Request;

class KategoriBusController extends Controller
{
    public function index()
    {
        $kategories = KategoriBus::withCount('buses')->latest()->get();

        return view('admin.operasional.kategori-bus.index', compact('kategories'));
    }

    public function create()
    {
        return view('admin.operasional.kategori-bus.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi',
            'kapasitas.required' => 'Kapasitas wajib diisi',
            'kapasitas.min' => 'Kapasitas minimal 1',
        ]);

        KategoriBus::create($validated);

        return redirect()->route('admin.operasional.kategori-bus.index')
            ->with('success', 'Kategori bus berhasil ditambahkan');
    }

    public function edit(KategoriBus $kategoriBu)
    {
        return view('admin.operasional.kategori-bus.edit', compact('kategoriBu'));
    }

    public function update(Request $request, KategoriBus $kategoriBu)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'kapasitas' => 'required|integer|min:1',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi',
            'kapasitas.required' => 'Kapasitas wajib diisi',
            'kapasitas.min' => 'Kapasitas minimal 1',
        ]);

        $kategoriBu->update($validated);

        return redirect()->route('admin.operasional.kategori-bus.index')
            ->with('success', 'Kategori bus berhasil diperbarui');
    }

    public function destroy(KategoriBus $kategoriBu)
    {
        if ($kategoriBu->buses()->count() > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh bus');
        }

        $kategoriBu->delete();

        return redirect()->route('admin.operasional.kategori-bus.index')
            ->with('success', 'Kategori bus berhasil dihapus');
    }
}
