<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanan';

    protected $fillable = [
        'nama',
        'slug',
        'deskripsi_singkat',
        'deskripsi_lengkap',
        'icon',
        'gambar',
        'fasilitas',
        'harga',
        'urutan',
        'unggulan',
        'aktif'
    ];

    protected $casts = [
        'fasilitas' => 'array',
        'unggulan' => 'boolean',
        'aktif' => 'boolean',
        'harga' => 'decimal:2'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($layanan) {
            if (empty($layanan->slug)) {
                $layanan->slug = Str::slug($layanan->nama);
            }
        });
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true)->orderBy('urutan');
    }

    public function scopeUnggulan($query)
    {
        return $query->where('unggulan', true)->where('aktif', true);
    }
}