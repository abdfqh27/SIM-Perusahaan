<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResetOtp extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'otp',
        'expires_at',
        'is_used',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_used' => 'boolean',
    ];

    // Generate OTP baru untuk email
    public static function generateOtp(string $email): self
    {
        // Hapus OTP lama yang belum digunakan
        self::where('email', $email)->where('is_used', false)->delete();

        // Generate OTP 6 digit
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        return self::create([
            'email' => $email,
            'otp' => $otp,
            'expires_at' => Carbon::now()->addMinutes(10), // OTP berlaku 10 menit
            'is_used' => false,
        ]);
    }

    // Verifikasi OTP
    public static function verifyOtp(string $email, string $otp): bool
    {
        $record = self::where('email', $email)
            ->where('otp', $otp)
            ->where('is_used', false)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        return $record !== null;
    }

    // Tandai OTP sudah digunakan
    public static function markAsUsed(string $email, string $otp): void
    {
        self::where('email', $email)
            ->where('otp', $otp)
            ->update(['is_used' => true]);
    }

    // Cek apakah otp sudah exp
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }
}
