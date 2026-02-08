<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use App\Models\PesanKontak;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    public function index()
    {
        // Set timezone
        DateHelper::setDefaultTimezone();

        $pengaturans = [
            'alamat' => Pengaturan::get('alamat'),
            'telepon' => Pengaturan::get('telepon'),
            'whatsapp' => Pengaturan::get('whatsapp'),
            'email' => Pengaturan::get('email'),
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
            'pesan' => 'required|string',
        ], [
            'nama.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'subjek.required' => 'Subjek wajib diisi',
            'pesan.required' => 'Pesan wajib diisi',
        ]);

        PesanKontak::create($validated);

        return redirect()->route('kontak')
            ->with('success', 'Terima kasih! Pesan Anda telah terkirim. Kami akan segera menghubungi Anda.');
    }
}
