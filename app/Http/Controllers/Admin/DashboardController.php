<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Armada;
use App\Models\Artikel;
use App\Models\Gallery;
use App\Models\HeroSection;
use App\Models\Layanan;
use App\Models\PesanKontak;
use App\Models\User;
use App\Helpers\DateHelper;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Set timezone Indonesia
        DateHelper::setDefaultTimezone();

        // Statistik Utama
        $totalArmada = Armada::count();
        $totalArmadaTersedia = Armada::tersedia()->count();
        $totalArmadaUnggulan = Armada::unggulan()->count();
        
        $totalLayanan = Layanan::count();
        $totalLayananAktif = Layanan::aktif()->count();
        $totalLayananUnggulan = Layanan::unggulan()->count();
        
        $totalArtikel = Artikel::count();
        $totalArtikelPublish = Artikel::dipublikasi()->count();
        $totalArtikelDraft = Artikel::where('dipublikasi', false)->count();
        
        $totalGallery = Gallery::count();
        $totalGalleryTampil = Gallery::tampilkan()->count();
        
        $totalPesan = PesanKontak::count();
        $totalPesanBelumDibaca = PesanKontak::belumDibaca()->count();
        
        $totalUsers = User::count();
        
        // Aktivitas Terbaru
        $pesanTerbaru = PesanKontak::latest()
            ->take(5)
            ->get()
            ->map(function($pesan) {
                $pesan->waktu_relatif = DateHelper::diffForHumans($pesan->created_at);
                return $pesan;
            });
        
        $artikelTerbaru = Artikel::with('user')
            ->latest()
            ->take(5)
            ->get()
            ->map(function($artikel) {
                $artikel->waktu_relatif = DateHelper::diffForHumans($artikel->created_at);
                return $artikel;
            });
        
        // Artikel Terpopuler (berdasarkan views)
        $artikelPopuler = Artikel::dipublikasi()
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();
        
        // Statistik Artikel per Bulan (6 bulan terakhir)
        $artikelPerBulan = Artikel::select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('YEAR(created_at) as tahun'),
                DB::raw('COUNT(*) as total')
            )
            ->where('created_at', '>=', DateHelper::now()->subMonths(6))
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->get()
            ->map(function($item) {
                $item->nama_bulan = DateHelper::getBulanIndonesia($item->bulan);
                return $item;
            });
        
        // Pesan per Status
        $pesanDibaca = PesanKontak::where('sudah_dibaca', true)->count();
        $pesanBelumDibaca = PesanKontak::where('sudah_dibaca', false)->count();
        
        // Gallery per Kategori
        $galleryPerKategori = Gallery::select('kategori', DB::raw('COUNT(*) as total'))
            ->groupBy('kategori')
            ->get();
        
        // Data Tanggal
        $hariIni = DateHelper::formatIndonesia(DateHelper::now(), 'l, d F Y');
        $jamSekarang = DateHelper::now()->format('H:i');
        
        // Sapaan berdasarkan waktu
        $jam = DateHelper::now()->hour;
        if ($jam >= 5 && $jam < 11) {
            $sapaan = 'Selamat Pagi';
        } elseif ($jam >= 11 && $jam < 15) {
            $sapaan = 'Selamat Siang';
        } elseif ($jam >= 15 && $jam < 18) {
            $sapaan = 'Selamat Sore';
        } else {
            $sapaan = 'Selamat Malam';
        }
        
        return view('admin.dashboard', compact(
            'totalArmada',
            'totalArmadaTersedia',
            'totalArmadaUnggulan',
            'totalLayanan',
            'totalLayananAktif',
            'totalLayananUnggulan',
            'totalArtikel',
            'totalArtikelPublish',
            'totalArtikelDraft',
            'totalGallery',
            'totalGalleryTampil',
            'totalPesan',
            'totalPesanBelumDibaca',
            'totalUsers',
            'pesanTerbaru',
            'artikelTerbaru',
            'artikelPopuler',
            'artikelPerBulan',
            'pesanDibaca',
            'pesanBelumDibaca',
            'galleryPerKategori',
            'hariIni',
            'jamSekarang',
            'sapaan'
        ));
    }
}