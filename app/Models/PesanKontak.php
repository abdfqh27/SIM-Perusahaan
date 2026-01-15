<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PesanKontak extends Model
{
    use HasFactory;

    protected $table = 'pesan_kontak';

    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'subjek',
        'pesan',
        'sudah_dibaca'
    ];

    protected $casts = [
        'sudah_dibaca' => 'boolean'
    ];

    public function scopeBelumDibaca($query)
    {
        return $query->where('sudah_dibaca', false)->latest();
    }

    public function tandaiSudahDibaca()
    {
        $this->update(['sudah_dibaca' => true]);
    }
}