<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\TentangPerusahaan;

class TentangPerusahaanController extends Controller
{
    public function index()
    {
        $tentang = TentangPerusahaan::first();

        return view('frontend.tentang', compact('tentang'));
    }
}
