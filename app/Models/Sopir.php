<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sopir extends Model
{
    use HasFactory;

    protected $table = 'sopir';

    protected $fillable = [
        'nama_sopir',
        'nik',
        'no_sim',
        'jenis_sim',
        'no_hp',
        'alamat',
        'status',
    ];

    // Relasi ke Bus (One to One)
    public function bus()
    {
        return $this->hasOne(Bus::class, 'sopir_id');
    }

    // Scope untuk sopir aktif
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    // Scope untuk sopir yang belum memiliki bus
    public function scopeTersedia($query)
    {
        return $query->whereDoesntHave('bus')->where('status', 'aktif');
    }
}
