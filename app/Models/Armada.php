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
        'kategori_bus_id',
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
        'kategori_bus_id' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($armada) {
            if (empty($armada->slug)) {
                $armada->slug = Str::slug($armada->nama);
            }

            if (empty($armada->urutan)) {
                $maxUrutan = static::max('urutan') ?? 0;
                $armada->urutan = $maxUrutan + 1;
            }
        });

        static::updating(function ($armada) {
            if ($armada->isDirty('nama')) {
                $armada->slug = Str::slug($armada->nama);
            }
        });
    }

    // Relasi ke KategoriBus
    public function kategoriBus()
    {
        return $this->belongsTo(KategoriBus::class, 'kategori_bus_id');
    }

    // Accessor tipe bus dari relasi
    public function getTipeBusAttribute()
    {
        return $this->kategoriBus?->nama_kategori;
    }

    // Accessor kapasitas dari relasi
    public function getKapasitasAttribute()
    {
        $kategori = $this->kategoriBus;

        if (! $kategori) {
            return '-';
        }

        if ($kategori->kapasitas_min == $kategori->kapasitas_max) {
            return $kategori->kapasitas_min.' kursi';
        }

        return $kategori->kapasitas_min.' - '.$kategori->kapasitas_max.' kursi';
    }

    // Accessor URL gambar utama
    public function getGambarUtamaUrlAttribute()
    {
        return \App\Helpers\ImageHelper::url($this->gambar_utama, '/images/no-bus.png');
    }

    // Accessor array URL galeri
    public function getGaleriUrlsAttribute()
    {
        if (! $this->galeri || ! is_array($this->galeri)) {
            return [];
        }

        return array_map(function ($path) {
            return \App\Helpers\ImageHelper::url($path);
        }, $this->galeri);
    }

    // Scope armada yang tersedia
    public function scopeTersedia($query)
    {
        return $query->where('tersedia', true)->orderBy('urutan');
    }

    // Scope armada unggulan
    public function scopeUnggulan($query)
    {
        return $query->where('unggulan', true)->where('tersedia', true)->orderBy('urutan');
    }

    // Scope filter berdasarkan tipe bus (nama kategori)
    public function scopeTipeBus($query, $tipe)
    {
        return $query->whereHas('kategoriBus', fn ($q) => $q->where('nama_kategori', $tipe));
    }

    // Scope filter berdasarkan kapasitas minimum
    public function scopeMinKapasitas($query, $kapasitas)
    {
        return $query->whereHas('kategoriBus', fn ($q) => $q->where('kapasitas_max', '>=', $kapasitas));
    }

    // Cek apakah armada memiliki fasilitas tertentu
    public function hasFasilitas($namaFasilitas)
    {
        if (! $this->fasilitas || ! is_array($this->fasilitas)) {
            return false;
        }

        return in_array($namaFasilitas, $this->fasilitas);
    }

    // Get daftar tipe bus dari KategoriBus
    public static function getDaftarTipeBus()
    {
        return KategoriBus::pluck('nama_kategori', 'id')->toArray();
    }

    // Get jumlah gambar galeri
    public function getJumlahGaleriAttribute()
    {
        return is_array($this->galeri) ? count($this->galeri) : 0;
    }

    // Get jumlah fasilitas
    public function getJumlahFasilitasAttribute()
    {
        return is_array($this->fasilitas) ? count($this->fasilitas) : 0;
    }
}
