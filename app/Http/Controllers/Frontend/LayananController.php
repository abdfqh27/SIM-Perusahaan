<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use App\Models\Pengaturan;

class LayananController extends Controller
{
    public function index()
    {
        $layanans = Layanan::where('aktif', true)
            ->orderBy('urutan')
            ->get();

        return view('frontend.layanan', compact('layanans'));
    }

    public function show($slug)
    {
        $layanan = Layanan::where('slug', $slug)
            ->where('aktif', true)
            ->firstOrFail();

        $layananLainnya = Layanan::where('aktif', true)
            ->where('id', '!=', $layanan->id)
            ->orderBy('unggulan', 'desc')
            ->orderBy('urutan')
            ->take(3)
            ->get();

        $pengaturans = Pengaturan::first();

        return view('frontend.layanan-detail', compact('layanan', 'layananLainnya', 'pengaturans'));
    }
}
