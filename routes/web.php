<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Frontend\ArmadaController;
use App\Http\Controllers\Frontend\ArtikelController;
use App\Http\Controllers\Frontend\GalleryController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\LayananController;
use App\Http\Controllers\Frontend\PesanKontakController;
use App\Http\Controllers\Frontend\TentangPerusahaanController;
use App\Http\Controllers\Frontend\TestimonialController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// HALAMAN PUBLIK
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [TentangPerusahaanController::class, 'index'])->name('tentang');
Route::get('/layanan', [LayannaController::class, 'index'])->name('layanan');
Route::get('/layanan/{slug}', [LayananController::class, 'show'])->name('layanan.detail');
Route::get('/armada', [ArmadaController::class, 'index'])->name('armada');
Route::get('/armada/{slug}', [ArmadaController::class, 'show'])->name('armada.detail');
Route::get('/galeri', [GalleryController::class, 'index'])->name('galeri');
Route::get('/testimoni', [TestimonialController::class, 'index'])->name('testimoni');
Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel');
Route::get('/artikel/{slug}', [ArtikelController::class, 'show'])->name('artikel.detail');
Route::get('/kontak', [PesanKontakController::class, 'index'])->name('kontak');
Route::post('/kontak', [PesanKontakController::class, 'store'])->name('kontak.store');

// AUTHENTICATION ROUTES
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// ADMIN ROUTES
Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {

    // Dashboard - Semua role admin
    Route::middleware('role:owner,admin-company,admin-perusahaan')->group(function () {
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
        Route::put('tentang/{id}', [App\Http\Controllers\Admin\TentangPerusahaanController::class, 'update'])->name('tentang.update');

        // Layanan Management
        Route::resource('layanan', App\Http\Controllers\Admin\LayananController::class)->names([
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

        // Pesan Kontak Management
        Route::prefix('pesan-kontak')->name('pesan-kontak.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\PesanKontakController::class, 'index'])->name('index');
            Route::get('/{id}', [App\Http\Controllers\Admin\PesanKontakController::class, 'show'])->name('show');
            Route::post('/{id}/tandai-dibaca', [App\Http\Controllers\Admin\PesanKontakController::class, 'markAsRead'])->name('tandai-dibaca');
            Route::delete('/{id}', [App\Http\Controllers\Admin\PesanKontakController::class, 'destroy'])->name('destroy');
        });

        // Pengaturan Management
        Route::prefix('pengaturan')->name('pengaturan.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\PengaturanController::class, 'index'])->name('index');
            Route::put('/', [App\Http\Controllers\Admin\PengaturanController::class, 'update'])->name('update');
        });
    });

    // USER MANAGEMENT (OWNER)
    Route::middleware('role:owner')->group(function () {
        Route::delete('users/{user}/photo', [App\Http\Controllers\Admin\UserController::class, 'deletePhoto'])
            ->name('users.photo.delete');

        // User Resource Routes
        Route::resource('users', App\Http\Controllers\Admin\UserController::class)->names([
            'index' => 'users.index',
            'create' => 'users.create',
            'store' => 'users.store',
            'show' => 'users.show',
            'edit' => 'users.edit',
            'update' => 'users.update',
            'destroy' => 'users.destroy',
        ]);
    });
});
