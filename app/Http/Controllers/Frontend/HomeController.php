<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use App\Models\TentangPerusahaan;
use App\Models\Layanan;
use App\Models\Armada;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'heroes' => HeroSection::aktif()->get(),
            'tentang' => TentangPerusahaan::first(),
            'layanan' => Layanan::unggulan()->take(6)->get(),
            'armada' => Armada::unggulan()->take(6)->get(),
        ];

        return view('frontend.home', $data);
    }
}