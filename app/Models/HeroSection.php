<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    use HasFactory;

    protected $table = 'hero_section';

    protected $fillable = [
        'judul',
        'deskripsi',
        'tombol_text',
        'tombol_link',
        'gambar',
        'urutan',
        'aktif'
    ];

    protected $casts = [
        'aktif' => 'boolean'
    ];

    public function scopeAktif($query)
    {
        return $query->where('aktif', true)->orderBy('urutan');
    }
}
