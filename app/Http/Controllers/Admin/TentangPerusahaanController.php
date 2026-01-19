<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TentangPerusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TentangPerusahaanController extends Controller
{
    /**
     * Display the tentang perusahaan page
     */
    public function index()
    {
        $tentang = TentangPerusahaan::firstOrCreate([]);

        return view('admin.tentang.index', compact('tentang'));
    }

    /**
     * Update tentang perusahaan information
     */
    public function update(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'sejarah' => 'nullable|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'nilai_perusahaan' => 'nullable|string',
            'pengalaman' => 'nullable|string',
            'gambar_perusahaan' => 'nullable|image|mimes:jpeg,jpg,png|max:10240',
        ], [
            'gambar_perusahaan.image' => 'File harus berupa gambar',
            'gambar_perusahaan.mimes' => 'Gambar harus berformat: jpeg, jpg, atau png',
            'gambar_perusahaan.max' => 'Ukuran gambar maksimal 10MB',
        ]);

        // Get tentang perusahaan record (first or create)
        $tentang = TentangPerusahaan::firstOrCreate([]);

        // Handle image upload
        if ($request->hasFile('gambar_perusahaan')) {
            // Delete old image if exists
            if ($tentang->gambar_perusahaan && Storage::disk('public')->exists($tentang->gambar_perusahaan)) {
                Storage::disk('public')->delete($tentang->gambar_perusahaan);
            }

            // Upload new image
            $image = $request->file('gambar_perusahaan');
            $imageName = time().'_'.str_replace(' ', '_', $image->getClientOriginalName());
            $imagePath = $image->storeAs('tentang-perusahaan', $imageName, 'public');

            $validated['gambar_perusahaan'] = $imagePath;
        }

        // Update tentang perusahaan information
        $tentang->update($validated);

        return redirect()->route('admin.tentang.index')
            ->with('success', 'Informasi perusahaan berhasil diperbarui!');
    }
}
