<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BusRequest;
use App\Models\Bus;
use App\Models\KategoriBus;
use App\Models\Sopir;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function index()
    {
        $buses = Bus::with(['kategoriBus', 'sopir'])->latest()->get();

        // Statistik dengan status real-time
        $today = today();
        $stats = [
            'total' => Bus::count(),
            'aktif' => Bus::where('status', 'aktif')->count(),
            'perawatan' => Bus::where('status', 'perawatan')->count(),
            'sedang_dipakai' => Bus::sedangDipakai($today)->count(),
        ];

        return view('admin.operasional.bus.index', compact('buses', 'stats'));
    }

    public function create()
    {
        $kategories = KategoriBus::all();
        $sopirs = Sopir::tersedia()->get(); // Sopir yang belum punya bus

        return view('admin.operasional.bus.create', compact('kategories', 'sopirs'));
    }

    public function store(BusRequest $request)
    {
        Bus::create($request->validated());

        return redirect()->route('admin.operasional.bus.index')
            ->with('success', 'Data bus berhasil ditambahkan');
    }

    public function show(Bus $bu)
    {
        $bu->load(['kategoriBus', 'sopir', 'bookings' => function ($query) {
            $query->latest()->limit(10);
        }]);

        // Status real-time hari ini
        $statusRealtime = $bu->status_realtime;

        // Booking yang sedang berjalan (jika ada)
        $bookingAktif = $bu->getBookingAktifPadaTanggal();

        return view('admin.operasional.bus.show', compact('bu', 'statusRealtime', 'bookingAktif'));
    }

    public function edit(Bus $bu)
    {
        $kategories = KategoriBus::all();

        // Sopir tersedia + sopir yang sedang ditugaskan ke bus ini
        $sopirs = Sopir::where(function ($query) use ($bu) {
            $query->tersedia()
                ->orWhere('id', $bu->sopir_id);
        })->get();

        return view('admin.operasional.bus.edit', compact('bu', 'kategories', 'sopirs'));
    }

    public function update(BusRequest $request, Bus $bu)
    {
        $bu->update($request->validated());

        return redirect()->route('admin.operasional.bus.index')
            ->with('success', 'Data bus berhasil diperbarui');
    }

    public function destroy(Bus $bu)
    {
        // Cek apakah bus sedang digunakan dalam booking aktif
        $hasActiveBooking = $bu->bookings()
            ->whereIn('status_booking', ['draft', 'confirmed'])
            ->exists();

        if ($hasActiveBooking) {
            return back()->with('error', 'Bus tidak dapat dihapus karena masih memiliki booking aktif');
        }

        $bu->delete();

        return redirect()->route('admin.operasional.bus.index')
            ->with('success', 'Data bus berhasil dihapus');
    }

    /**
     * Update status bus (hanya antara aktif dan perawatan)
     */
    public function updateStatus(Request $request, Bus $bu)
    {
        $validated = $request->validate([
            'status' => 'required|in:aktif,perawatan',
        ]);

        // Cek apakah bus sedang dipakai hari ini
        $statusRealtime = $bu->status_realtime;

        if ($statusRealtime === 'dipakai' && $validated['status'] === 'perawatan') {
            return back()->with('error', 'Bus sedang digunakan pada booking aktif, tidak dapat dipindah ke perawatan');
        }

        $bu->update(['status' => $validated['status']]);

        return back()->with('success', 'Status bus berhasil diperbarui');
    }

    /**
     * Mendapatkan informasi ketersediaan bus pada tanggal tertentu
     */
    public function checkKetersediaan(Request $request, Bus $bu)
    {
        $request->validate([
            'tanggal_berangkat' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_berangkat',
        ]);

        $tersedia = $bu->isTersediaPadaTanggal(
            $request->tanggal_berangkat,
            $request->tanggal_selesai
        );

        if (! $tersedia) {
            // Cari booking yang bentrok
            $conflictBooking = $bu->bookings()
                ->where('status_booking', 'confirmed')
                ->where(function ($query) use ($request) {
                    $query->whereDate('tanggal_berangkat', '<=', $request->tanggal_selesai)
                        ->whereDate('tanggal_selesai', '>=', $request->tanggal_berangkat);
                })
                ->first();

            return response()->json([
                'tersedia' => false,
                'message' => 'Bus tidak tersedia',
                'conflict' => $conflictBooking ? [
                    'kode_booking' => $conflictBooking->kode_booking,
                    'tanggal_berangkat' => $conflictBooking->tanggal_berangkat->format('d/m/Y'),
                    'tanggal_selesai' => $conflictBooking->tanggal_selesai->format('d/m/Y'),
                ] : null,
            ]);
        }

        return response()->json([
            'tersedia' => true,
            'message' => 'Bus tersedia pada tanggal tersebut',
        ]);
    }
}
