<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{

    use AuthenticatesUsers;
    protected $redirectTo = '/admin';
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $this->validateLogin($request);

        // Jika terlalu banyak percobaan login yang gagal
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        // Coba untuk login
        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        // Jika login gagal, tambah counter percobaan
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password harus diisi',
        ]);
    }

    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request),
            $request->filled('remember')
        );
    }

    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return $request->wantsJson()
                    ? new \Illuminate\Http\JsonResponse([], 204)
                    : redirect()->intended($this->redirectPath());
    }

    protected function authenticated(Request $request, $user)
    {
        // Cek apakah user punya role
        if ($user->role) {
            // Log aktivitas login (optional)
            \Log::info('User logged in', [
                'user_id' => $user->id,
                'email' => $user->email,
                'role' => $user->role->nama,
                'ip' => $request->ip(),
            ]);

            // Redirect ke admin dashboard
            return redirect()->route('admin.dashboard')->with('success', 'Selamat datang, ' . $user->name . '!');
        }
        
        // Jika tidak punya role, logout dan redirect ke login
        Auth::logout();
        return redirect()->route('login')->with('error', 'Akun Anda tidak memiliki akses ke sistem.');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => ['Email atau password yang Anda masukkan salah.'],
        ]);
    }

    public function username()
    {
        return 'email';
    }

    public function logout(Request $request)
    {
        // Log aktivitas logout (optional)
        if (Auth::check()) {
            \Log::info('User logged out', [
                'user_id' => Auth::id(),
                'email' => Auth::user()->email,
            ]);
        }

        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new \Illuminate\Http\JsonResponse([], 204)
            : redirect('/login')->with('success', 'Anda berhasil logout');
    }

    protected function loggedOut(Request $request)
    {
        // logic tambahan di sini
        // mencatat waktu logout, clear session tertentu, dll
    }

    protected function guard()
    {
        return Auth::guard();
    }

    public function redirectPath()
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/admin';
    }
}