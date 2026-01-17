<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\TentangPerusahaan;

class TentangController extends Controller
{
    public function index()
    {
        $tentangPerusahaan = TentangPerusahaan::first();
        return view('frontend.tentang', compact('tentangPerusahaan'));
    }
}