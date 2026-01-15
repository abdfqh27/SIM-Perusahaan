<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Armada extends Model
{
    use HasFactory;

    protected $table = 'armada';

    protected $fillable = [
        'nama',
        'slug',
        'tipe_bus',
        'kapasitas',
        'deskripsi',
        'gambar_utama',
        'galeri',
        'urutan',
        'unggulan',
        'tersedia'
    ];

    protected $casts = [
        'galeri' => 'array',
        'unggulan' => 'boolean',
        'tersedia' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($armada) {
            if (empty($armada->slug)) {
                $armada->slug = Str::slug($armada->nama);
            }
        });
    }

    public function fasilitas()
    {
        return $this->hasMany(FasilitasArmada::class);
    }

    public function scopeTersedia($query)
    {
        return $query->where('tersedia', true)->orderBy('urutan');
    }

    public function scopeUnggulan($query)
    {
        return $query->where('unggulan', true)->where('tersedia', true);
    }
}