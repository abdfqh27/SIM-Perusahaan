<?php

namespace App\Models;

use App\Helpers\DateHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bus extends Model
{
    use HasFactory, SoftDeletes;

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
        return $this->belongsTo(Sopir::class, 'sopir_id')->withTrashed();
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
     * Scope untuk bus yang tersedia pada tanggal tertentu
     */
    public function scopeTersediaPadaTanggal($query, $tanggalBerangkat, $tanggalSelesai)
    {
        return $query->where('status', 'aktif')
            ->whereNotNull('sopir_id')
            ->whereHas('sopir', function ($q) {
                $q->where('status', 'aktif');
            })
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

        // Jika bus tidak ada sopir, tidak tersedia
        if (! $this->sopir_id) {
            return false;
        }

        // Jika sopir tidak aktif, tidak tersedia
        if ($this->sopir && $this->sopir->status !== 'aktif') {
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
     */
    public function getStatusPadaTanggal($tanggal = null)
    {
        $tanggal = $tanggal ?? DateHelper::today();

        // Jika bus dalam perawatan, statusnya tetap perawatan
        if ($this->status === 'perawatan') {
            return 'perawatan';
        }

        // Jika bus tidak ada sopir atau sopir tidak aktif
        if (! $this->sopir_id || ($this->sopir && $this->sopir->status !== 'aktif')) {
            return 'tidak_tersedia';
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
        return $this->getStatusPadaTanggal(DateHelper::today());
    }

    /**
     * Scope untuk bus yang sedang dipakai pada tanggal tertentu
     */
    public function scopeSedangDipakai($query, $tanggal = null)
    {
        $tanggal = $tanggal ?? DateHelper::today();

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
        $tanggal = $tanggal ?? DateHelper::today();

        return $this->bookings()
            ->where('status_booking', 'confirmed')
            ->whereDate('tanggal_berangkat', '<=', $tanggal)
            ->whereDate('tanggal_selesai', '>=', $tanggal)
            ->first();
    }

    /**
     * Cek apakah bus dapat diedit (tidak sedang dipakai hari ini)
     */
    public function canBeEdited()
    {
        $today = DateHelper::today();

        // Bus tidak dapat diedit jika sedang dipakai hari ini
        return ! $this->bookings()
            ->where('status_booking', 'confirmed')
            ->whereDate('tanggal_berangkat', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->exists();
    }

    /**
     * Cek apakah bus dapat dihapus (tidak ada booking confirmed/draft)
     */
    public function canBeDeleted()
    {
        return ! $this->bookings()
            ->whereIn('status_booking', ['draft', 'confirmed'])
            ->exists();
    }

    /**
     * Cek apakah bus dapat dipesan
     */
    public function canBeBooked()
    {
        return $this->status === 'aktif'
            && $this->sopir_id
            && $this->sopir
            && $this->sopir->status === 'aktif';
    }
}
