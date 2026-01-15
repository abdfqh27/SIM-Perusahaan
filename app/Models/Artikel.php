<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Artikel extends Model
{
    use HasFactory;

    protected $table = 'artikel';

    protected $fillable = [
        'user_id',
        'judul',
        'slug',
        'excerpt',
        'konten',
        'gambar_featured',
        'kategori',
        'tags',
        'views',
        'dipublikasi',
        'tanggal_publikasi'
    ];

    protected $casts = [
        'tags' => 'array',
        'dipublikasi' => 'boolean',
        'tanggal_publikasi' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($artikel) {
            if (empty($artikel->slug)) {
                $artikel->slug = Str::slug($artikel->judul);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeDipublikasi($query)
    {
        return $query->where('dipublikasi', true)
                    ->whereNotNull('tanggal_publikasi')
                    ->where('tanggal_publikasi', '<=', now())
                    ->latest('tanggal_publikasi');
    }

    public function incrementViews()
    {
        $this->increment('views');
    }
}