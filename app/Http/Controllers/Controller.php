<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    // upload gambar hd ke storage
    protected function uploadImage(UploadedFile $file, string $path, ?string $oldFile = null): string
    {
        // Hapus file lama jika ada
        if ($oldFile && Storage::disk('public')->exists($oldFile)) {
            Storage::disk('public')->delete($oldFile);
        }

        // Generate nama file unik
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
        // Simpan file dengan kualitas original (HD)
        $filePath = $file->storeAs($path, $filename, 'public');
        
        return $filePath;
    }

    // hapus gambar dari storage
    protected function deleteImage(?string $filePath): bool
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->delete($filePath);
        }
        
        return false;
    }
}
