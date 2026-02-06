<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    protected $table = 'bus';

    protected $fillable = [
        'kode_bus',
        'nama_bus',
        'kategori_bus_id',
        'sopir_id',
        'warna_bus',
        'nomor_polisi',
        'status',
    ];

    /**
     * Relasi ke Kategori Bus
     */
    public function kategoriBus()
    {
        return $this->belongsTo(KategoriBus::class, 'kategori_bus_id');
    }

    /**
     * Relasi ke Sopir
     */
    public function sopir()
    {
        return $this->belongsTo(Sopir::class, 'sopir_id');
    }

    /**
     * Relasi Many-to-Many ke Booking
     */
    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_bus', 'bus_id', 'booking_id')
            ->withTimestamps();
    }

    /**
     * Scope untuk bus aktif (tidak dalam perawatan)
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope untuk bus yang tersedia pada rentang tanggal tertentu
     * Status dinamis berdasarkan tanggal
     */
    public function scopeTersediaPadaTanggal($query, $tanggalBerangkat, $tanggalSelesai)
    {
        return $query->where('status', 'aktif')
            ->whereDoesntHave('bookings', function ($q) use ($tanggalBerangkat, $tanggalSelesai) {
                $q->where('status_booking', 'confirmed')
                    ->where(function ($query) use ($tanggalBerangkat, $tanggalSelesai) {
                        $query->whereDate('tanggal_berangkat', '<=', $tanggalSelesai)
                            ->whereDate('tanggal_selesai', '>=', $tanggalBerangkat);
                    });
            });
    }

    /**
     * Cek apakah bus tersedia pada rentang tanggal tertentu
     */
    public function isTersediaPadaTanggal($tanggalBerangkat, $tanggalSelesai)
    {
        // Jika bus dalam perawatan, tidak tersedia
        if ($this->status === 'perawatan') {
            return false;
        }

        // Cek apakah ada booking yang bertabrakan
        $hasBentrok = $this->bookings()
            ->where('status_booking', 'confirmed')
            ->where(function ($query) use ($tanggalBerangkat, $tanggalSelesai) {
                $query->whereDate('tanggal_berangkat', '<=', $tanggalSelesai)
                    ->whereDate('tanggal_selesai', '>=', $tanggalBerangkat);
            })
            ->exists();

        return ! $hasBentrok;
    }

    /**
     * Mendapatkan status bus pada tanggal tertentu (REAL-TIME)
     * Status dihitung secara dinamis, tidak dari kolom status
     */
    public function getStatusPadaTanggal($tanggal = null)
    {
        $tanggal = $tanggal ?? today();

        // Jika bus dalam perawatan, statusnya tetap perawatan
        if ($this->status === 'perawatan') {
            return 'perawatan';
        }

        // Cek apakah bus sedang dipakai pada tanggal tersebut
        $sedangDipakai = $this->bookings()
            ->where('status_booking', 'confirmed')
            ->whereDate('tanggal_berangkat', '<=', $tanggal)
            ->whereDate('tanggal_selesai', '>=', $tanggal)
            ->exists();

        return $sedangDipakai ? 'dipakai' : 'tersedia';
    }

    /**
     * Accessor untuk mendapatkan status real-time hari ini
     */
    public function getStatusRealtimeAttribute()
    {
        return $this->getStatusPadaTanggal(today());
    }

    /**
     * Scope untuk bus yang sedang dipakai hari ini
     */
    public function scopeSedangDipakai($query, $tanggal = null)
    {
        $tanggal = $tanggal ?? today();

        return $query->whereHas('bookings', function ($q) use ($tanggal) {
            $q->where('status_booking', 'confirmed')
                ->whereDate('tanggal_berangkat', '<=', $tanggal)
                ->whereDate('tanggal_selesai', '>=', $tanggal);
        });
    }

    /**
     * Mendapatkan booking yang sedang berjalan pada tanggal tertentu
     */
    public function getBookingAktifPadaTanggal($tanggal = null)
    {
        $tanggal = $tanggal ?? today();

        return $this->bookings()
            ->where('status_booking', 'confirmed')
            ->whereDate('tanggal_berangkat', '<=', $tanggal)
            ->whereDate('tanggal_selesai', '>=', $tanggal)
            ->first();
    }
}
