<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->get('kategori');

        $galleries = Gallery::tampilkan();

        if ($kategori) {
            $galleries = $galleries->kategori($kategori);
        }

        $galleries = $galleries->get();

        $kategoris = Gallery::where('tampilkan', true)
            ->distinct()
            ->pluck('kategori');

        return view('frontend.gallery', compact('galleries', 'kategoris', 'kategori'));
    }
}
