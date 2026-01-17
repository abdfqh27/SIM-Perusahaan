<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PesanKontak;
use Illuminate\Http\Request;

class PesanKontakController extends Controller
{
    public function index()
    {
        $pesanKontaks = PesanKontak::latest()->get();
        return view('admin.pesan-kontak.index', compact('pesanKontaks'));
    }

    public function show($id)
    {
        $pesanKontak = PesanKontak::findOrFail($id);
        
        // tandai pesan yang sudah dibaca
        if (!$pesanKontak->sudah_dibaca) {
            $pesanKontak->tandaiSudahDibaca();
        }

        return view('admin.pesan-kontak.show', compact('pesanKontak'));
    }

    public function markAsRead($id)
    {
        $pesanKontak = PesanKontak::findOrFail($id);
        $pesanKontak->tandaiSudahDibaca();

        return redirect()->back()
            ->with('success', 'Pesan ditandai sudah dibaca');
    }

    public function destroy($id)
    {
        $pesanKontak = PesanKontak::findOrFail($id);
        $pesanKontak->delete();

        return redirect()->route('admin.pesan-kontak.index')
            ->with('success', 'Pesan berhasil dihapus');
    }
}