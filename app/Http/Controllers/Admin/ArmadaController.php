<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Armada;
use App\Models\FasilitasArmada;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArmadaController extends Controller
{
    public function index()
    {
        $armadas = Armada::with('fasilitas')->orderBy('urutan')->get();
        return view('admin.armada.index', compact('armadas'));
    }

    public function create()
    {
        return view('admin.armada.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tipe_bus' => 'required|string|max:100',
            'kapasitas' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
            'gambar_utama' => 'nullable|image|mimes:jpeg,jpg,png|max:10240',
            'galeri.*' => 'nullable|image|mimes:jpeg,jpg,png|max:10240',
            'urutan' => 'required|integer|min:0',
            'unggulan' => 'boolean',
            'tersedia' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['nama']);

        if ($request->hasFile('gambar_utama')) {
            $validated['gambar_utama'] = $this->uploadImage($request->file('gambar_utama'), 'armada');
        }

        // Upload galeri
        if ($request->hasFile('galeri')) {
            $galeri = [];
            foreach ($request->file('galeri') as $file) {
                $galeri[] = $this->uploadImage($file, 'armada/galeri');
            }
            $validated['galeri'] = $galeri;
        }

        Armada::create($validated);

        return redirect()->route('admin.armada.index')
            ->with('success', 'Armada berhasil ditambahkan');
    }

    public function show(Armada $armada)
    {
        $armada->load('fasilitas');
        return view('admin.armada.show', compact('armada'));
    }

    public function edit(Armada $armada)
    {
        $armada->load('fasilitas');
        return view('admin.armada.edit', compact('armada'));
    }

    public function update(Request $request, Armada $armada)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'tipe_bus' => 'required|string|max:100',
            'kapasitas' => 'required|integer|min:1',
            'deskripsi' => 'nullable|string',
            'gambar_utama' => 'nullable|image|mimes:jpeg,jpg,png|max:10240',
            'galeri.*' => 'nullable|image|mimes:jpeg,jpg,png|max:10240',
            'urutan' => 'required|integer|min:0',
            'unggulan' => 'boolean',
            'tersedia' => 'boolean',
            'hapus_galeri' => 'nullable|array'
        ]);

        $validated['slug'] = Str::slug($validated['nama']);

        if ($request->hasFile('gambar_utama')) {
            $validated['gambar_utama'] = $this->uploadImage(
                $request->file('gambar_utama'), 
                'armada', 
                $armada->gambar_utama
            );
        }

        // Handle galeri
        $galeriYangAda = $armada->galeri ?? [];

        // Hapus galeri yang dipilih
        if ($request->has('hapus_galeri')) {
            foreach ($request->hapus_galeri as $index) {
                if (isset($galeriYangAda[$index])) {
                    $this->deleteImage($galeriYangAda[$index]);
                    unset($galeriYangAda[$index]);
                }
            }
            $galeriYangAda = array_values($galeriYangAda);
        }

        // Upload galeri baru
        if ($request->hasFile('galeri')) {
            foreach ($request->file('galeri') as $file) {
                $galeriYangAda[] = $this->uploadImage($file, 'armada/galeri');
            }
        }

        $validated['galeri'] = $galeriYangAda;

        $armada->update($validated);

        return redirect()->route('admin.armada.index')
            ->with('success', 'Armada berhasil diupdate');
    }

    public function destroy(Armada $armada)
    {
        // Hapus gambar utama
        $this->deleteImage($armada->gambar_utama);
        
        // Hapus galeri
        if ($armada->galeri) {
            foreach ($armada->galeri as $gambar) {
                $this->deleteImage($gambar);
            }
        }
        
        $armada->delete();

        return redirect()->route('admin.armada.index')
            ->with('success', 'Armada berhasil dihapus');
    }

    // Fasilitas Management
    public function storeFacility(Request $request, Armada $armada)
    {
        $validated = $request->validate([
            'nama_fasilitas' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'tersedia' => 'boolean'
        ]);

        $armada->fasilitas()->create($validated);

        return redirect()->route('admin.armada.edit', $armada)
            ->with('success', 'Fasilitas berhasil ditambahkan');
    }

    public function destroyFacility(FasilitasArmada $fasilitas)
    {
        $armadaId = $fasilitas->armada_id;
        $fasilitas->delete();

        return redirect()->route('admin.armada.edit', $armadaId)
            ->with('success', 'Fasilitas berhasil dihapus');
    }
}