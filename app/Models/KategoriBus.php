<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBus extends Model
{
    use HasFactory;

    protected $table = 'kategori_bus';

    protected $fillable = [
        'nama_kategori',
        'kapasitas',
    ];

    // Relasi ke Bus
    public function buses()
    {
        return $this->hasMany(Bus::class, 'kategori_bus_id');
    }
}
