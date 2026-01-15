<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TentangPerusahaan extends Model
{
    use HasFactory;

    protected $table = 'tentang_perusahaan';

    protected $fillable = [
        'sejarah',
        'visi',
        'misi',
        'nilai_perusahaan',
        'gambar_perusahaan',
        'pengalaman'
    ];
}