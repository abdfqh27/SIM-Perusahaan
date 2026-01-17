<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TentangPerusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class TentangPerusahaanController extends Controller
{
    public function index()
    {
        $tentangPerusahaan = TentangPerusahaan::firstOrCreate([]);
        return view('admin.tentang.index', compact('tentangPerusahaan'));
    }

    public function update(Request $request, $id)
    {
        // Validate input
        $validated = $request->validate([
            'sejarah' => 'nullable|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'nilai_perusahaan' => 'nullable|string',
            'gambar_perusahaan' => 'nullable|image|mimes:jpeg,jpg,png|max:10240',
            'pengalaman' => 'nullable|string'
        ], [
            'gambar_perusahaan.image' => 'File harus berupa gambar',
            'gambar_perusahaan.mimes' => 'Gambar harus berformat: jpeg, jpg, atau png',
            'gambar_perusahaan.max' => 'Ukuran gambar maksimal 10MB'
        ]);

        // Find tentang perusahaan record
        $tentangPerusahaan = TentangPerusahaan::findOrFail($id);

        // Handle image upload
        if ($request->hasFile('gambar_perusahaan')) {
            // Delete old image if exists
            if ($tentangPerusahaan->gambar_perusahaan && Storage::disk('public')->exists($tentangPerusahaan->gambar_perusahaan)) {
                Storage::disk('public')->delete($tentangPerusahaan->gambar_perusahaan);
            }

            // Upload new image
            $image = $request->file('gambar_perusahaan');
            $imageName = time() . '_' . str_replace(' ', '_', $image->getClientOriginalName());
            $imagePath = $image->storeAs('tentang-perusahaan', $imageName, 'public');
            
            $validated['gambar_perusahaan'] = $imagePath;
        }

        // Update tentang perusahaan information
        $tentangPerusahaan->update($validated);

        return redirect()->route('admin.tentang.index')
            ->with('success', 'Informasi perusahaan berhasil diupdate');
    }

    /**
     * Upload image helper method
     * 
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder
     * @param string|null $oldImage
     * @return string
     */
    protected function uploadImage(UploadedFile $file, string $folder, ?string $oldImage = null): string
    {
        if ($oldImage && Storage::disk('public')->exists($oldImage)) {
            Storage::disk('public')->delete($oldImage);
        }

        // Generate unique filename
        $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
        // Store image
        $imagePath = $file->storeAs($folder, $imageName, 'public');

        return $imagePath;
    }

    /**
     * Delete image from storage
     * 
     * @param string|null $imagePath
     * @return bool
     */
    protected function deleteImage(?string $imagePath): bool
    {
        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            return Storage::disk('public')->delete($imagePath);
        }

        return false;
    }
}