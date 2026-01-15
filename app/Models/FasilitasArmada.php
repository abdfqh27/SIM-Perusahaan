<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FasilitasArmada extends Model
{
    use HasFactory;

    protected $table = 'fasilitas_armada';

    protected $fillable = [
        'armada_id',
        'nama_fasilitas',
        'icon',
        'tersedia'
    ];

    protected $casts = [
        'tersedia' => 'boolean'
    ];

    public function armada()
    {
        return $this->belongsTo(Armada::class);
    }
}