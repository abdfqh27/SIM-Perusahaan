<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $table = 'gallery';

    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'kategori',
        'urutan',
        'tampilkan',
    ];

    protected $casts = [
        'tampilkan' => 'boolean',
    ];

    public function scopeTampilkan($query)
    {
        return $query->where('tampilkan', true)->orderBy('urutan');
    }

    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    public static function getDaftarKategori()
    {
        return [
            'perjalanan' => 'Perjalanan',
            'armada' => 'Armada',
            'kegiatan' => 'Kegiatan',
        ];
    }

    public function getKategoriLabelAttribute()
    {
        $kategori = self::getDaftarKategori();

        return $kategori[$this->kategori] ?? $this->kategori;
    }
}
