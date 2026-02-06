<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'booking';

    protected $fillable = [
        'kode_booking',
        'nama_pemesan',
        'no_hp_pemesan',
        'email_pemesan',
        'tujuan',
        'tempat_jemput',
        'tanggal_berangkat',
        'tanggal_selesai',
        'jam_berangkat',
        'total_pembayaran',
        'nominal_dp',
        'metode_pembayaran',
        'status_pembayaran',
        'status_booking',
        'catatan',
    ];

    protected $casts = [
        'tanggal_berangkat' => 'date',
        'tanggal_selesai' => 'date',
        'total_pembayaran' => 'decimal:2',
        'nominal_dp' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->kode_booking)) {
                $booking->kode_booking = self::generateKodeBooking();
            }
        });
    }

    /**
     * Generate kode booking unik
     * Format: BKG + YYYYMMDD + 4 digit nomor urut
     */
    public static function generateKodeBooking()
    {
        $prefix = 'BKG';
        $date = date('Ymd');
        $lastBooking = self::whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->first();

        $number = $lastBooking ? (intval(substr($lastBooking->kode_booking, -4)) + 1) : 1;

        return $prefix.$date.str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Relasi Many-to-Many ke Bus
     */
    public function buses()
    {
        return $this->belongsToMany(Bus::class, 'booking_bus', 'booking_id', 'bus_id')
            ->withTimestamps();
    }

    /**
     * Accessor untuk durasi hari (dihitung otomatis, tidak disimpan di DB)
     */
    public function getDurasiHariAttribute()
    {
        if (! $this->tanggal_berangkat || ! $this->tanggal_selesai) {
            return 0;
        }

        return $this->tanggal_berangkat->diffInDays($this->tanggal_selesai) + 1;
    }

    /**
     * Accessor untuk sisa pembayaran
     */
    public function getSisaPembayaranAttribute()
    {
        if ($this->status_pembayaran === 'lunas') {
            return 0;
        }

        $dibayar = $this->nominal_dp ?? 0;

        return $this->total_pembayaran - $dibayar;
    }

    /**
     * Scope untuk booking aktif (confirmed)
     */
    public function scopeAktif($query)
    {
        return $query->where('status_booking', 'confirmed');
    }

    /**
     * Scope untuk booking yang sedang berjalan pada tanggal tertentu
     */
    public function scopeBerjalanPadaTanggal($query, $tanggal = null)
    {
        $tanggal = $tanggal ?? today();

        return $query->where('status_booking', 'confirmed')
            ->whereDate('tanggal_berangkat', '<=', $tanggal)
            ->whereDate('tanggal_selesai', '>=', $tanggal);
    }

    /**
     * Cek apakah booking sedang berjalan pada tanggal tertentu
     */
    public function isBerjalanPadaTanggal($tanggal = null)
    {
        $tanggal = $tanggal ?? today();

        return $this->status_booking === 'confirmed'
            && $this->tanggal_berangkat <= $tanggal
            && $this->tanggal_selesai >= $tanggal;
    }

    /**
     * Cek apakah rentang tanggal bertabrakan dengan booking lain
     */
    public static function cekBentrokJadwal($busIds, $tanggalBerangkat, $tanggalSelesai, $excludeBookingId = null)
    {
        return self::where('id', '!=', $excludeBookingId)
            ->where('status_booking', 'confirmed')
            ->whereHas('buses', function ($query) use ($busIds) {
                $query->whereIn('bus_id', $busIds);
            })
            ->where(function ($query) use ($tanggalBerangkat, $tanggalSelesai) {
                // Cek overlap: (Start1 <= End2) AND (End1 >= Start2)
                $query->where(function ($q) use ($tanggalBerangkat, $tanggalSelesai) {
                    $q->whereDate('tanggal_berangkat', '<=', $tanggalSelesai)
                        ->whereDate('tanggal_selesai', '>=', $tanggalBerangkat);
                });
            });
    }
}
