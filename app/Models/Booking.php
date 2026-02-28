<?php

namespace App\Models;

use App\Helpers\DateHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

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
        $date = DateHelper::now()->format('Ymd');
        $lastBooking = self::whereDate('created_at', DateHelper::today())
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
            ->withTrashed() // Tetap tampilkan bus yang sudah dihapus
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

        return DateHelper::diffInDays($this->tanggal_berangkat, $this->tanggal_selesai);
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
        $tanggal = $tanggal ?? DateHelper::today();

        return $query->where('status_booking', 'confirmed')
            ->whereDate('tanggal_berangkat', '<=', $tanggal)
            ->whereDate('tanggal_selesai', '>=', $tanggal);
    }

    /**
     * Cek apakah booking sedang berjalan pada tanggal tertentu
     */
    public function isBerjalanPadaTanggal($tanggal = null)
    {
        $tanggal = $tanggal ?? DateHelper::today();

        return $this->status_booking === 'confirmed'
            && $this->tanggal_berangkat <= $tanggal
            && $this->tanggal_selesai >= $tanggal;
    }

    /**
     * Cek apakah rentang tanggal bertabrakan dengan booking lain
     */
    public static function cekBentrokJadwal($busIds, $tanggalBerangkat, $tanggalSelesai, $excludeBookingId = null)
    {
        $query = self::where('status_booking', 'confirmed')
            ->whereHas('buses', function ($query) use ($busIds) {
                $query->whereIn('bus_id', $busIds);
            })
            ->where(function ($query) use ($tanggalBerangkat, $tanggalSelesai) {
                $query->whereDate('tanggal_berangkat', '<=', $tanggalSelesai)
                    ->whereDate('tanggal_selesai', '>=', $tanggalBerangkat);
            });

        if ($excludeBookingId) {
            $query->where('id', '!=', $excludeBookingId);
        }

        return $query;
    }
}
