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
        'kapasitas_min',
        'kapasitas_max',
        'deskripsi',
        'gambar_utama',
        'galeri',
        'fasilitas',
        'urutan',
        'unggulan',
        'tersedia',
    ];

    protected $casts = [
        'galeri' => 'array',
        'fasilitas' => 'array',
        'unggulan' => 'boolean',
        'tersedia' => 'boolean',
        'kapasitas_min' => 'integer',
        'kapasitas_max' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($armada) {
            // Generate slug otomatis dari nama
            if (empty($armada->slug)) {
                $armada->slug = Str::slug($armada->nama);
            }

            // Set urutan otomatis ke urutan terakhir + 1
            if (empty($armada->urutan)) {
                $maxUrutan = static::max('urutan') ?? 0;
                $armada->urutan = $maxUrutan + 1;
            }
        });

        static::updating(function ($armada) {
            // Update slug jika nama berubah
            if ($armada->isDirty('nama')) {
                $armada->slug = Str::slug($armada->nama);
            }
        });
    }

    // Accessor untuk menampilkan kapasitas dalam format range
    public function getKapasitasAttribute()
    {
        if ($this->kapasitas_min == $this->kapasitas_max) {
            return $this->kapasitas_min.' kursi';
        }

        return $this->kapasitas_min.' - '.$this->kapasitas_max.' kursi';
    }

    // Accessor untuk URL gambar utama
    public function getGambarUtamaUrlAttribute()
    {
        return \App\Helpers\ImageHelper::url($this->gambar_utama, '/images/no-bus.png');
    }

    // Accessor untuk array URL galeri
    public function getGaleriUrlsAttribute()
    {
        if (! $this->galeri || ! is_array($this->galeri)) {
            return [];
        }

        return array_map(function ($path) {
            return \App\Helpers\ImageHelper::url($path);
        }, $this->galeri);
    }

    // Scope untuk armada yang tersedia
    public function scopeTersedia($query)
    {
        return $query->where('tersedia', true)->orderBy('urutan');
    }

    // Scope untuk armada unggulan
    public function scopeUnggulan($query)
    {
        return $query->where('unggulan', true)->where('tersedia', true)->orderBy('urutan');
    }

    // Scope untuk filter berdasrkan tipe bus
    public function scopeTipeBus($query, $tipe)
    {
        return $query->where('tipe_bus', $tipe);
    }

    // Scope untuk filter berdasarkan kapasitas minimum
    public function scopeMinKapasitas($query, $kapasitas)
    {
        return $query->where('kapasitas_max', '>=', $kapasitas);
    }

    // cek apakah armada memiliki fasilitas tertentu
    public function hasFasilitas($namaFasilitas)
    {
        if (! $this->fasilitas || ! is_array($this->fasilitas)) {
            return false;
        }

        return in_array($namaFasilitas, $this->fasilitas);
    }

    // Get Daftar tipe bus yang tersedia
    public static function getDaftarTipeBus()
    {
        return [
            'SHD' => 'Super High Deck (SHD)',
            'HDD' => 'High Deck (HDD)',
            'Medium' => 'Medium Bus',
            'Elf' => 'Elf/Microbus',
            'HiAce' => 'HiAce/Minibus',
        ];
    }

    // Get Jumlah gambar galeri
    public function getJumlahGaleriAttribute()
    {
        if (! $this->galeri || ! is_array($this->galeri)) {
            return 0;
        }

        return count($this->galeri);
    }

    // Get jumlah fasilitas
    public function getJumlahFasilitasAttribute()
    {
        if (! $this->fasilitas || ! is_array($this->fasilitas)) {
            return 0;
        }

        return count($this->fasilitas);
    }
}
