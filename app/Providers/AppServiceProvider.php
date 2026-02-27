<?php

namespace App\Providers;

use App\Models\Pengaturan;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share pengaturan ke semua view
        View::composer('*', function ($view) {
            $pengaturan = Pengaturan::first();

            // Jika belum ada data, buat default
            if (! $pengaturan) {
                $pengaturan = new Pengaturan([
                    'nama_perusahaan' => config('app.name', 'Sri Maju Trans'),
                    'tagline' => 'Perjalanan Nyaman, Harga Terjangkau',
                    'email' => 'info@srimajutrans.com',
                    'telepon' => '021-12345678',
                    'whatsapp' => '6281234567890',
                    'alamat' => 'Jl. Raya Utama No. 123, Jakarta',
                    'logo' => 'logo.png',
                    'favicon' => 'favicon.png',
                ]);
            }

            $view->with('pengaturan', $pengaturan);
        });
    }
}
