<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\SopirRequest;
use App\Models\Sopir;

class SopirController extends Controller
{
    public function __construct()
    {
        DateHelper::setDefaultTimezone();
    }

    public function index()
    {
        $sopirs = Sopir::with('bus')->latest()->get();

        $stats = [
            'total' => Sopir::count(),
            'aktif' => Sopir::where('status', 'aktif')->count(),
            'nonaktif' => Sopir::where('status', 'nonaktif')->count(),
            'cuti' => Sopir::where('status', 'cuti')->count(),
        ];

        return view('admin.operasional.sopir.index', compact('sopirs', 'stats'));
    }

    public function create()
    {
        return view('admin.operasional.sopir.create');
    }

    public function store(SopirRequest $request)
    {
        Sopir::create($request->validated());

        return redirect()->route('admin.operasional.sopir.index')
            ->with('success', 'Data sopir berhasil ditambahkan');
    }

    public function show(Sopir $sopir)
    {
        $sopir->load('bus.kategoriBus');

        return view('admin.operasional.sopir.show', compact('sopir'));
    }

    public function edit(Sopir $sopir)
    {
        return view('admin.operasional.sopir.edit', compact('sopir'));
    }

    public function update(SopirRequest $request, Sopir $sopir)
    {
        // Validasi khusus jika sopir sedang bertugas dan status diubah ke nonaktif/cuti
        if ($sopir->isBertugas() && in_array($request->status, ['nonaktif', 'cuti'])) {
            return back()->with('error', 'Sopir sedang bertugas di bus, tidak dapat diubah ke status nonaktif/cuti. Lepaskan tugasan bus terlebih dahulu.');
        }

        $sopir->update($request->validated());

        return redirect()->route('admin.operasional.sopir.index')
            ->with('success', 'Data sopir berhasil diperbarui');
    }

    public function destroy(Sopir $sopir)
    {
        // Cek apakah sopir sedang bertugas
        if ($sopir->isBertugas()) {
            return back()->with('error', 'Sopir tidak dapat dihapus karena masih ditugaskan ke bus');
        }

        $sopir->delete();

        return redirect()->route('admin.operasional.sopir.index')
            ->with('success', 'Data sopir berhasil dihapus');
    }
}
