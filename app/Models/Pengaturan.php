<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    use HasFactory;

    protected $table = 'pengaturan';

    protected $fillable = [
        'nama_perusahaan',
        'tagline',
        'deskripsi',
        'alamat',
        'telepon',
        'whatsapp',
        'email',
        'facebook',
        'instagram',
        'twitter',
        'youtube',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'logo',
        'favicon'
    ];

    // Helper method untuk get data pengaturan
    public static function getData()
    {
        return self::first();
    }

    // Helper method untuk get field tertentu
    public static function getField($field, $default = null)
    {
        $pengaturan = self::first();
        return $pengaturan ? $pengaturan->$field : $default;
    }
}