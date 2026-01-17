<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PesanKontak;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    public function index()
    {
        $pengaturans = [
            'alamat' => Pengaturan::get('alamat'),
            'telepon' => Pengaturan::get('telepon'),
            'whatsapp' => Pengaturan::get('whatsapp'),
            'email' => Pengaturan::get('email')
        ];

        return view('frontend.kontak', compact('pengaturans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telepon' => 'nullable|string|max:20',
            'subjek' => 'required|string|max:255',
            'pesan' => 'required|string'
        ]);

        PesanKontak::create($validated);

        return redirect()->route('kontak')
            ->with('success', 'Terima kasih! Pesan Anda telah terkirim. Kami akan segera menghubungi Anda.');
    }
}