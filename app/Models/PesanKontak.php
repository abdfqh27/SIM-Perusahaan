<?php

namespace App\Models;

use App\Helpers\DateHelper;
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
        'sudah_dibaca',
        'dibaca_pada',
    ];

    protected $casts = [
        'sudah_dibaca' => 'boolean',
        'dibaca_pada' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Boot method untuk set timezone
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            DateHelper::setDefaultTimezone();
        });
    }

    public function scopeBelumDibaca($query)
    {
        return $query->where('sudah_dibaca', false)->latest();
    }

    public function tandaiSudahDibaca()
    {
        $this->update([
            'sudah_dibaca' => true,
            'dibaca_pada' => DateHelper::now(),
        ]);
    }

    // Accessor untuk format tanggal Indonesia
    public function getTanggalKirimAttribute()
    {
        return DateHelper::formatDateTimeIndonesia($this->created_at);
    }

    public function getTanggalDibacaAttribute()
    {
        return $this->dibaca_pada ? DateHelper::formatDateTimeIndonesia($this->dibaca_pada) : '-';
    }

    public function getWaktuRelatifAttribute()
    {
        return DateHelper::diffForHumans($this->created_at);
    }
}
