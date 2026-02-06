<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingBus extends Model
{
    use HasFactory;

    protected $table = 'booking_bus';

    protected $fillable = [
        'booking_id',
        'bus_id',
    ];

    // Relasi ke Booking
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    // Relasi ke Bus
    public function bus()
    {
        return $this->belongsTo(Bus::class, 'bus_id');
    }
}
