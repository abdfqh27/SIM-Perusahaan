<?php

namespace App\Models;

use App\Helpers\DateHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanan';

    protected $fillable = [
        'nama',
        'slug',
        'deskripsi_singkat',
        'deskripsi_lengkap',
        'icon',
        'gambar',
        'fasilitas',
        'urutan',
        'unggulan',
        'aktif',
    ];

    protected $casts = [
        'fasilitas' => 'array',
        'unggulan' => 'boolean',
        'aktif' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        // Set timezone default
        DateHelper::setDefaultTimezone();

        static::creating(function ($layanan) {
            if (empty($layanan->slug)) {
                $layanan->slug = Str::slug($layanan->nama);
            }

            // Set timestamps menggunakan DateHelper
            if (! $layanan->created_at) {
                $layanan->created_at = DateHelper::now();
            }
            if (! $layanan->updated_at) {
                $layanan->updated_at = DateHelper::now();
            }
        });

        static::updating(function ($layanan) {
            // Update timestamp menggunakan DateHelper
            $layanan->updated_at = DateHelper::now();
        });
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true)->orderBy('urutan');
    }

    public function scopeUnggulan($query)
    {
        return $query->where('unggulan', true)->where('aktif', true);
    }

    public function getCreatedAtIndonesiaAttribute()
    {
        return DateHelper::formatDateTimeIndonesia($this->created_at);
    }

    public function getUpdatedAtIndonesiaAttribute()
    {
        return DateHelper::formatDateTimeIndonesia($this->updated_at);
    }

    public function getCreatedAtRelativeAttribute()
    {
        return DateHelper::diffForHumans($this->created_at);
    }

    public function getUpdatedAtRelativeAttribute()
    {
        return DateHelper::diffForHumans($this->updated_at);
    }
}
