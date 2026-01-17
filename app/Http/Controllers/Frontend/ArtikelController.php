<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->get('kategori');
        
        $artikels = Artikel::dipublikasi()->with('user');
        
        if ($kategori) {
            $artikels = $artikels->where('kategori', $kategori);
        }
        
        $artikels = $artikels->paginate(9);
        
        $kategoris = Artikel::where('dipublikasi', true)
                            ->distinct()
                            ->pluck('kategori');
        
        $artikelPopuler = Artikel::dipublikasi()
                                ->orderBy('views', 'desc')
                                ->take(5)
                                ->get();

        return view('frontend.artikel', compact('artikels', 'kategoris', 'kategori', 'artikelPopuler'));
    }

    public function show($slug)
    {
        $artikel = Artikel::where('slug', $slug)
                        ->where('dipublikasi', true)
                        ->with('user')
                        ->firstOrFail();
        
        // Increment views
        $artikel->incrementViews();
        
        $artikelTerkait = Artikel::dipublikasi()
                                ->where('id', '!=', $artikel->id)
                                ->where(function($query) use ($artikel) {
                                    $query->where('kategori', $artikel->kategori);
                                })
                                ->take(3)
                                ->get();

        return view('frontend.artikel-detail', compact('artikel', 'artikelTerkait'));
    }
}