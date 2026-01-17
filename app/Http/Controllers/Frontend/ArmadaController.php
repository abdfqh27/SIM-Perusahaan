<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Armada;

class ArmadaController extends Controller
{
    public function index()
    {
        $armadas = Armada::tersedia()->with('fasilitas')->get();
        return view('frontend.armada', compact('armadas'));
    }

    public function show($slug)
    {
        $armada = Armada::where('slug', $slug)
                    ->where('tersedia', true)
                    ->with('fasilitas')
                    ->firstOrFail();
        
        $armadaLainnya = Armada::tersedia()
                            ->where('id', '!=', $armada->id)
                            ->take(3)
                            ->get();
        
        return view('frontend.armada-detail', compact('armada', 'armadaLainnya'));
    }
}