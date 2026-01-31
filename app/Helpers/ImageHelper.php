<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImageHelper
{
    public static function uploadHD($file, $path, $quality = 90)
    {
        $filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
        $filePath = $path.'/'.$filename;

        // Buat folder jika belum ada
        if (! Storage::disk('public')->exists($path)) {
            Storage::disk('public')->makeDirectory($path);
        }

        // Simpan ke storage dengan kualitas original
        Storage::disk('public')->put($filePath, file_get_contents($file));

        return $filePath;
    }

    public static function uploadWithResize($file, $path, $width = 800, $height = null)
    {
        $filename = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
        $filePath = $path.'/'.$filename;

        // Buat folder jika belum ada
        if (! Storage::disk('public')->exists($path)) {
            Storage::disk('public')->makeDirectory($path);
        }

        // Buat ImageManager instance
        $manager = new ImageManager(new Driver);

        // Buat gambar
        $img = $manager->read($file);

        // Resize
        if ($height) {
            $img->resize($width, $height);
        } else {
            $img->scale(width: $width);
        }

        // Encode sesuai extension
        $extension = $file->getClientOriginalExtension();
        if (in_array(strtolower($extension), ['jpg', 'jpeg'])) {
            $encoded = $img->toJpeg(90);
        } elseif (strtolower($extension) === 'png') {
            $encoded = $img->toPng();
        } elseif (strtolower($extension) === 'webp') {
            $encoded = $img->toWebp(90);
        } else {
            $encoded = $img->toJpeg(90);
        }

        Storage::disk('public')->put($filePath, (string) $encoded);

        return $filePath;
    }

    public static function uploadWebP($file, $path, $width = 800, $height = null, $quality = 85)
    {
        $filename = time().'_'.uniqid().'.webp';
        $filePath = $path.'/'.$filename;

        // Buat folder jika belum ada
        if (! Storage::disk('public')->exists($path)) {
            Storage::disk('public')->makeDirectory($path);
        }

        // Buat ImageManager instance
        $manager = new ImageManager(new Driver);

        // Buat gambar dengan Intervention Image
        $img = $manager->read($file);

        // Resize jika diperlukan
        if ($width || $height) {
            if ($height) {
                $img->resize($width, $height);
            } else {
                $img->scale(width: $width);
            }
        }

        // Encode ke WebP dengan quality yang ditentukan
        $encodedImage = $img->toWebp($quality);

        // Simpan ke storage
        Storage::disk('public')->put($filePath, (string) $encodedImage);

        return $filePath;
    }

    public static function uploadProfilePhoto($file, $path, $width = 500, $height = 500, $quality = 85)
    {
        $filename = time().'_'.uniqid().'.webp';
        $filePath = $path.'/'.$filename;

        if (! Storage::disk('public')->exists($path)) {
            Storage::disk('public')->makeDirectory($path);
        }

        // Buat ImageManager instance
        $manager = new ImageManager(new Driver);

        // Buat gambar
        $img = $manager->read($file);

        // Cover untuk crop dari tengah
        $img->cover($width, $height);

        // Encode ke WebP
        $encodedImage = $img->toWebp($quality);

        // Simpan ke storage
        Storage::disk('public')->put($filePath, (string) $encodedImage);

        return $filePath;
    }

    public static function uploadHDWebP($file, $path, $maxWidth = 1920, $quality = 90)
    {
        $filename = time().'_'.uniqid().'.webp';
        $filePath = $path.'/'.$filename;

        // Buat folder jika belum ada
        if (! Storage::disk('public')->exists($path)) {
            Storage::disk('public')->makeDirectory($path);
        }

        // Buat ImageManager instance
        $manager = new ImageManager(new Driver);

        // Buat gambar dengan Intervention Image
        $img = $manager->read($file);

        // Resize hanya jika lebih besar dari maxWidth
        if ($img->width() > $maxWidth) {
            $img->scale(width: $maxWidth);
        }

        // Encode ke WebP dengan quality tinggi
        $encodedImage = $img->toWebp($quality);

        // Simpan ke storage
        Storage::disk('public')->put($filePath, (string) $encodedImage);

        return $filePath;
    }

    public static function uploadMultipleSizes($file, $path, $quality = 85)
    {
        $baseFilename = time().'_'.uniqid();

        // Buat folder jika belum ada
        if (! Storage::disk('public')->exists($path)) {
            Storage::disk('public')->makeDirectory($path);
        }

        // Buat ImageManager instance
        $manager = new ImageManager(new Driver);

        $sizes = [
            'thumbnail' => 150,
            'medium' => 500,
            'large' => 1200,
        ];

        $paths = [];

        foreach ($sizes as $sizeName => $width) {
            $filename = $baseFilename.'_'.$sizeName.'.webp';
            $filePath = $path.'/'.$filename;

            // Buat instance baru untuk setiap size
            $resizedImg = $manager->read($file);
            $resizedImg->scale(width: $width);

            $encodedImage = $resizedImg->toWebp($quality);
            Storage::disk('public')->put($filePath, (string) $encodedImage);

            $paths[$sizeName] = $filePath;
        }

        return $paths;
    }

    public static function delete($filePath)
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->delete($filePath);
        }

        return false;
    }

    public static function deleteMultiple(array $filePaths)
    {
        $deleted = true;

        foreach ($filePaths as $filePath) {
            if ($filePath && ! self::delete($filePath)) {
                $deleted = false;
            }
        }

        return $deleted;
    }

    public static function url($filePath, $default = '/images/no-image.png')
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            return Storage::disk('public')->url($filePath);
        }

        return asset($default);
    }

    public static function exists($filePath)
    {
        return $filePath && Storage::disk('public')->exists($filePath);
    }

    public static function size($filePath)
    {
        if (self::exists($filePath)) {
            return Storage::disk('public')->size($filePath);
        }

        return false;
    }

    public static function humanFileSize($filePath)
    {
        $bytes = self::size($filePath);

        if ($bytes === false) {
            return 'Unknown';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2).' '.$units[$i];
    }

    public static function getDimensions($filePath)
    {
        if (! self::exists($filePath)) {
            return ['width' => 0, 'height' => 0];
        }

        $manager = new ImageManager(new Driver);
        $img = $manager->read(Storage::disk('public')->path($filePath));

        return [
            'width' => $img->width(),
            'height' => $img->height(),
        ];
    }

    public static function convertToWebP($sourcePath, $quality = 90)
    {
        if (! Storage::disk('public')->exists($sourcePath)) {
            return false;
        }

        $manager = new ImageManager(new Driver);
        $img = $manager->read(Storage::disk('public')->path($sourcePath));

        // Generate filename baru dengan extension .webp
        $pathInfo = pathinfo($sourcePath);
        $newFilename = $pathInfo['filename'].'_'.time().'.webp';
        $newPath = $pathInfo['dirname'].'/'.$newFilename;

        // Encode ke WebP
        $encoded = $img->toWebp($quality);

        Storage::disk('public')->put($newPath, (string) $encoded);

        return $newPath;
    }
}
