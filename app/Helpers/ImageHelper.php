<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageHelper
{
    // upload gambar hd
    public static function uploadHD($file, $path, $quality = 90)
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $filePath = $path . '/' . $filename;
        
        // Simpan ke storage dengan kualitas original
        Storage::disk('public')->put($filePath, file_get_contents($file));
        
        return $filePath;
    }

    // upload gambar dengan resize
    public static function uploadWithResize($file, $path, $width = 800, $height = null)
    {
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $filePath = $path . '/' . $filename;
        
        // Buat folder jika belum ada
        if (!Storage::disk('public')->exists($path)) {
            Storage::disk('public')->makeDirectory($path);
        }
        
        // Simpan dengan resize
        $img = Image::make($file);
        
        if ($height) {
            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        } else {
            $img->resize($width, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }
        
        Storage::disk('public')->put($filePath, $img->encode());
        
        return $filePath;
    }

    // hapus gambar
    public static function delete($filePath)
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->delete($filePath);
        }
        
        return false;
    }

    // mendapatkan url
    public static function url($filePath, $default = '/images/no-image.png')
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->url($filePath);
        }
        
        return asset($default);
    }
}
