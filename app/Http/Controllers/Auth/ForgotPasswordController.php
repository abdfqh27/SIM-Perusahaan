<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    // Menampilkan form request email untuk reset password
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    // Kirim OTp ke email
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email tidak terdaftar dalam sistem.',
        ]);

        $user = User::where('email', $request->email)->first();

        // Generate OTP
        $otpRecord = PasswordResetOtp::generateOtp($request->email);

        // Kirim email
        try {
            Mail::to($request->email)->send(new OtpMail($otpRecord->otp, $user->name));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email. Silakan coba lagi.');
        }

        return redirect()->route('password.verify.otp.form', ['email' => $request->email])
            ->with('success', 'Kode OTP telah dikirim ke email Anda.');
    }

    // Menampilkan form verifikasi OTP
    public function showVerifyOtpForm(Request $request)
    {
        $email = $request->query('email');

        if (! $email) {
            return redirect()->route('password.request')
                ->with('error', 'Email tidak valid.');
        }

        return view('auth.passwords.verify-otp', compact('email'));
    }

    // Verifikasi OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|string|size:6',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email tidak terdaftar dalam sistem.',
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.size' => 'Kode OTP harus 6 digit.',
        ]);

        if (! PasswordResetOtp::verifyOtp($request->email, $request->otp)) {
            return back()->with('error', 'Kode OTP tidak valid atau sudah kadaluarsa.');
        }

        // Simpan email dan OTP di session untuk halaman reset password
        session([
            'reset_email' => $request->email,
            'reset_otp' => $request->otp,
        ]);

        return redirect()->route('password.reset.form')
            ->with('success', 'Verifikasi berhasil. Silakan buat password baru.');
    }

    // Menampilkan form reset password
    public function showResetForm()
    {
        $email = session('reset_email');
        $otp = session('reset_otp');

        if (! $email || ! $otp) {
            return redirect()->route('password.request')
                ->with('error', 'Sesi tidak valid. Silakan ulangi proses reset password.');
        }

        return view('auth.passwords.reset', compact('email'));
    }

    // reset Pw
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email tidak terdaftar dalam sistem.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $email = session('reset_email');
        $otp = session('reset_otp');

        // Validasi session
        if ($email !== $request->email) {
            return redirect()->route('password.request')
                ->with('error', 'Sesi tidak valid. Silakan ulangi proses reset password.');
        }

        // Verifikasi ulang OTP
        if (! PasswordResetOtp::verifyOtp($email, $otp)) {
            return redirect()->route('password.request')
                ->with('error', 'Kode OTP tidak valid atau sudah kadaluarsa.');
        }

        // Update password
        $user = User::where('email', $email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Tandai OTP sebagai sudah digunakan
        PasswordResetOtp::markAsUsed($email, $otp);

        // Hapus session
        session()->forget(['reset_email', 'reset_otp']);

        return redirect()->route('login')
            ->with('success', 'Password berhasil direset. Silakan login dengan password baru.');
    }

    // Kirim ulang otp
    public function resendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        // Generate OTP baru
        $otpRecord = PasswordResetOtp::generateOtp($request->email);

        // Kirim email
        try {
            Mail::to($request->email)->send(new OtpMail($otpRecord->otp, $user->name));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email. Silakan coba lagi.');
        }

        return back()->with('success', 'Kode OTP baru telah dikirim ke email Anda.');
    }
}
