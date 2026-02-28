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
        'kapasitas_min',
        'kapasitas_max',
    ];

    protected $casts = [
        'kapasitas_min' => 'integer',
        'kapasitas_max' => 'integer',
    ];

    // Accessor untuk menampilkan kapasitas dalam format range
    public function getKapasitasAttribute()
    {
        if ($this->kapasitas_min == $this->kapasitas_max) {
            return $this->kapasitas_min.' kursi';
        }

        return $this->kapasitas_min.' - '.$this->kapasitas_max.' kursi';
    }

    // Relasi ke Bus
    public function buses()
    {
        return $this->hasMany(Bus::class, 'kategori_bus_id');
    }

    // Relasi ke Armada
    public function armada()
    {
        return $this->hasMany(Armada::class, 'kategori_bus_id');
    }
}
