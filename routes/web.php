<?php

use App\Http\Controllers\Admin\PesanKontakController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Frontend\ArmadaController;
use App\Http\Controllers\Frontend\ArtikelController;
use App\Http\Controllers\Frontend\GalleryController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\KontakController;
use App\Http\Controllers\Frontend\LayananController;
use App\Http\Controllers\Frontend\TentangPerusahaanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// HALAMAN PUBLIK
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [TentangPerusahaanController::class, 'index'])->name('tentang');
Route::get('/layanan', [LayananController::class, 'index'])->name('layanan');
Route::get('/layanan/{slug}', [LayananController::class, 'show'])->name('layanan.detail');
Route::get('/armada', [ArmadaController::class, 'index'])->name('armada');
Route::get('/armada/{slug}', [ArmadaController::class, 'show'])->name('armada.detail');
Route::get('/galeri', [GalleryController::class, 'index'])->name('galeri');
Route::get('/testimoni', [TestimonialController::class, 'index'])->name('testimoni');
Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel');
Route::get('/artikel/{slug}', [ArtikelController::class, 'show'])->name('artikel.detail');
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');
Route::post('/kontak', [KontakController::class, 'store'])->name('kontak.store');

// AUTHENTICATION ROUTES
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Password Reset Routes (OTP Based)
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/send-otp', [ForgotPasswordController::class, 'sendOtp'])->name('password.send.otp');
Route::get('/password/verify-otp', [ForgotPasswordController::class, 'showVerifyOtpForm'])->name('password.verify.otp.form');
Route::post('/password/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])->name('password.verify.otp');
Route::post('/password/resend-otp', [ForgotPasswordController::class, 'resendOtp'])->name('password.resend.otp');
Route::get('/password/reset-form', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/password/reset', [ForgotPasswordController::class, 'resetPassword'])->name('password.update.new');

// ADMIN ROUTES
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {

    // PROFILE MANAGEMENT - SEMUA ROLE ADMIN
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\ProfileController::class, 'show'])->name('show');
        Route::get('/edit', [App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('edit');
        Route::put('/update', [App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('update');
        Route::put('/password', [App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('password.update');
        Route::delete('/photo', [App\Http\Controllers\Admin\ProfileController::class, 'deletePhoto'])->name('photo.delete');
    });

    // DASHBOARD - SEMUA ROLE ADMIN
    Route::middleware('role:owner,admin-company,admin-operasional')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    });

    // COMPANY PROFIL (OWNER & ADMIN COMPANY)
    Route::middleware('role:owner,admin-company')->group(function () {

        // Hero Section Management
        Route::resource('hero-section', App\Http\Controllers\Admin\HeroSectionController::class)->names([
            'index' => 'hero.index',
            'create' => 'hero.create',
            'store' => 'hero.store',
            'show' => 'hero.show',
            'edit' => 'hero.edit',
            'update' => 'hero.update',
            'destroy' => 'hero.destroy',
        ]);

        // Tentang Perusahaan Management
        Route::get('tentang', [App\Http\Controllers\Admin\TentangPerusahaanController::class, 'index'])->name('tentang.index');
        Route::put('tentang', [App\Http\Controllers\Admin\TentangPerusahaanController::class, 'update'])->name('tentang.update');

        // Layanan Management
        Route::resource('layanan', App\Http\Controllers\Admin\LayananController::class)
            ->parameters(['layanan' => 'layanan:slug'])
            ->names([
                'index' => 'layanan.index',
                'create' => 'layanan.create',
                'store' => 'layanan.store',
                'show' => 'layanan.show',
                'edit' => 'layanan.edit',
                'update' => 'layanan.update',
                'destroy' => 'layanan.destroy',
            ]);

        // Armada Management
        Route::resource('armada', App\Http\Controllers\Admin\ArmadaController::class)->names([
            'index' => 'armada.index',
            'create' => 'armada.create',
            'store' => 'armada.store',
            'show' => 'armada.show',
            'edit' => 'armada.edit',
            'update' => 'armada.update',
            'destroy' => 'armada.destroy',
        ]);

        // Fasilitas Armada Management
        Route::post('armada/{armada}/fasilitas', [App\Http\Controllers\Admin\ArmadaController::class, 'storeFacility'])->name('armada.fasilitas.store');
        Route::delete('armada/fasilitas/{fasilitas}', [App\Http\Controllers\Admin\ArmadaController::class, 'destroyFacility'])->name('armada.fasilitas.destroy');

        // Gallery Management
        Route::resource('gallery', App\Http\Controllers\Admin\GalleryController::class)->names([
            'index' => 'gallery.index',
            'create' => 'gallery.create',
            'store' => 'gallery.store',
            'show' => 'gallery.show',
            'edit' => 'gallery.edit',
            'update' => 'gallery.update',
            'destroy' => 'gallery.destroy',
        ]);

        // Arttikel Management
        Route::resource('artikel', App\Http\Controllers\Admin\ArtikelController::class)->names([
            'index' => 'artikel.index',
            'create' => 'artikel.create',
            'store' => 'artikel.store',
            'show' => 'artikel.show',
            'edit' => 'artikel.edit',
            'update' => 'artikel.update',
            'destroy' => 'artikel.destroy',
        ]);

        Route::prefix('pesan-kontak')->name('pesan-kontak.')->group(function () {
            // Main CRUD routes
            Route::get('/', [PesanKontakController::class, 'index'])->name('index');
            Route::get('/{id}', [PesanKontakController::class, 'show'])->name('show');
            Route::post('/{id}/tandai-dibaca', [PesanKontakController::class, 'markAsRead'])->name('tandai-dibaca');
            Route::delete('/{id}', [PesanKontakController::class, 'destroy'])->name('destroy');

            // Bulk actions
            Route::post('/bulk/mark-read', [PesanKontakController::class, 'bulkMarkAsRead'])->name('bulk.mark-read');
            Route::delete('/bulk/delete', [PesanKontakController::class, 'bulkDelete'])->name('bulk.delete');

            // API endpoints
            Route::get('/api/check-new', [PesanKontakController::class, 'checkNewMessages'])->name('api.check-new');
            Route::get('/api/statistics', [PesanKontakController::class, 'getStatistics'])->name('api.statistics');
        });

        // Pengaturan Management
        Route::prefix('pengaturan')->name('pengaturan.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\PengaturanController::class, 'index'])->name('index');
            Route::put('/', [App\Http\Controllers\Admin\PengaturanController::class, 'update'])->name('update');
        });
    });

    // OPERASIONAL - OWNER & ADMIN PERUSAHAAN
    Route::prefix('operasional')->middleware('role:owner,admin-operasional')->name('operasional.')->group(function () {

        // Kategori Bus Management
        Route::resource('kategori-bus', App\Http\Controllers\Admin\KategoriBusController::class)->parameters([
            'kategori-bus' => 'kategoriBu',
        ])->names([
            'index' => 'kategori-bus.index',
            'create' => 'kategori-bus.create',
            'store' => 'kategori-bus.store',
            'show' => 'kategori-bus.show',
            'edit' => 'kategori-bus.edit',
            'update' => 'kategori-bus.update',
            'destroy' => 'kategori-bus.destroy',
        ]);

        // Sopir Management
        Route::resource('sopir', App\Http\Controllers\Admin\SopirController::class)->names([
            'index' => 'sopir.index',
            'create' => 'sopir.create',
            'store' => 'sopir.store',
            'show' => 'sopir.show',
            'edit' => 'sopir.edit',
            'update' => 'sopir.update',
            'destroy' => 'sopir.destroy',
        ]);

        // Bus Management
        Route::resource('bus', App\Http\Controllers\Admin\BusController::class)->parameters([
            'bus' => 'bu',
        ])->names([
            'index' => 'bus.index',
            'create' => 'bus.create',
            'store' => 'bus.store',
            'show' => 'bus.show',
            'edit' => 'bus.edit',
            'update' => 'bus.update',
            'destroy' => 'bus.destroy',
        ]);

        Route::post('bus/{bu}/remove-sopir', [App\Http\Controllers\Admin\BusController::class, 'removeSopir'])
            ->name('bus.remove-sopir');

        // Bus Status Update
        Route::post('bus/{bu}/update-status', [App\Http\Controllers\Admin\BusController::class, 'updateStatus'])->name('bus.update-status');

        // Booking Management
        Route::get('booking/bus-tersedia', [App\Http\Controllers\Admin\BookingController::class, 'getBusTersedia'])
            ->name('booking.bus-tersedia');

        // Booking Status Update (harus sebelum resource)
        Route::patch('booking/{booking}/update-status', [App\Http\Controllers\Admin\BookingController::class, 'updateStatus'])
            ->name('booking.update-status');

        // Booking Resource Routes
        Route::resource('booking', App\Http\Controllers\Admin\BookingController::class)->names([
            'index' => 'booking.index',
            'create' => 'booking.create',
            'store' => 'booking.store',
            'show' => 'booking.show',
            'edit' => 'booking.edit',
            'update' => 'booking.update',
            'destroy' => 'booking.destroy',
        ]);
    });

    // USER MANAGEMENT & LAPORAN (OWNER ONLY)
    Route::middleware('role:owner')->group(function () {

        // User Management
        Route::delete('users/{user}/photo', [App\Http\Controllers\Admin\UserController::class, 'deletePhoto'])
            ->name('users.photo.delete');

        Route::resource('users', App\Http\Controllers\Admin\UserController::class)->names([
            'index' => 'users.index',
            'create' => 'users.create',
            'store' => 'users.store',
            'show' => 'users.show',
            'edit' => 'users.edit',
            'update' => 'users.update',
            'destroy' => 'users.destroy',
        ]);

        // Laporan Management
        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('index');
            Route::get('/jadwal-keberangkatan', [App\Http\Controllers\Admin\LaporanController::class, 'jadwalKeberangkatan'])->name('jadwal-keberangkatan');
            Route::get('/ketersediaan-bus', [App\Http\Controllers\Admin\LaporanController::class, 'ketersediaanBus'])->name('ketersediaan-bus');
            Route::get('/pendapatan', [App\Http\Controllers\Admin\LaporanController::class, 'pendapatan'])->name('pendapatan');
            Route::get('/performa-bus', [App\Http\Controllers\Admin\LaporanController::class, 'performaBus'])->name('performa-bus');
            Route::get('/rekap-bulanan', [App\Http\Controllers\Admin\LaporanController::class, 'rekapBulanan'])->name('rekap-bulanan');
        });
    });
});
