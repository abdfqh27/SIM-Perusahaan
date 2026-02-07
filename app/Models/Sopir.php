<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sopir extends Model
{
    use HasFactory, SoftDeletes;

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

    // Relasi bus one to one
    public function bus()
    {
        return $this->hasOne(Bus::class, 'sopir_id');
    }

    // scope untuk sopir aktif
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    // Scope untuk sopir yang belum memiliki bus dan statusnya aktif
    public function scopeTersedia($query)
    {
        return $query->whereDoesntHave('bus')->where('status', 'aktif');
    }

    // Cek apakah sopir dapat ditugaskan ke bus
    public function canBeAssigned()
    {
        return $this->status === 'aktif' && ! $this->bus;
    }

    // cek apakah sopir sedang bertugas
    public function isBertugas()
    {
        return $this->bus()->exists();
    }
}
