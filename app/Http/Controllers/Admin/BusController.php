<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\BusRequest;
use App\Models\Bus;
use App\Models\KategoriBus;
use App\Models\Sopir;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function __construct()
    {
        DateHelper::setDefaultTimezone();
    }

    public function index()
    {
        $buses = Bus::with(['kategoriBus', 'sopir'])->latest()->get();

        $today = DateHelper::today();
        $stats = [
            'total' => Bus::count(),
            'aktif' => Bus::where('status', 'aktif')->count(),
            'perawatan' => Bus::where('status', 'perawatan')->count(),
            'sedang_dipakai' => Bus::sedangDipakai($today)->count(),
            'tanpa_sopir' => Bus::whereNull('sopir_id')->count(),
        ];

        return view('admin.operasional.bus.index', compact('buses', 'stats'));
    }

    public function create()
    {
        $kategories = KategoriBus::all();
        $sopirs = Sopir::tersedia()->get();

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

        $statusRealtime = $bu->status_realtime;
        $bookingAktif = $bu->getBookingAktifPadaTanggal();

        return view('admin.operasional.bus.show', compact('bu', 'statusRealtime', 'bookingAktif'));
    }

    public function edit(Bus $bu)
    {
        if (! $bu->canBeEdited()) {
            return back()->with('error', 'Bus sedang digunakan pada booking aktif hari ini, tidak dapat diedit');
        }

        $kategories = KategoriBus::all();

        $sopirs = Sopir::where(function ($query) use ($bu) {
            $query->tersedia()
                ->orWhere('id', $bu->sopir_id);
        })->get();

        return view('admin.operasional.bus.edit', compact('bu', 'kategories', 'sopirs'));
    }

    public function update(BusRequest $request, Bus $bu)
    {
        if (! $bu->canBeEdited()) {
            return back()->with('error', 'Bus sedang digunakan pada booking aktif hari ini, tidak dapat diedit');
        }

        $bu->update($request->validated());

        return redirect()->route('admin.operasional.bus.index')
            ->with('success', 'Data bus berhasil diperbarui');
    }

    /**
     * Hapus bus dengan validasi di controller
     *
     * VALIDASI:
     * 1. Cek apakah masih ada booking aktif/draft
     * 2. Cek apakah masih ada sopir yang bertugas
     */
    public function destroy(Bus $bu)
    {
        // VALIDASI 1: Cek booking aktif/draft
        $hasActiveBooking = $bu->bookings()
            ->whereIn('status_booking', ['draft', 'confirmed'])
            ->exists();

        // VALIDASI 2: Cek apakah masih ada sopir
        $hasSopir = ! is_null($bu->sopir_id);

        // Jika ada booking aktif atau masih ada sopir, tolak penghapusan
        if ($hasActiveBooking || $hasSopir) {
            $reasons = [];

            if ($hasActiveBooking) {
                $bookingCount = $bu->bookings()
                    ->whereIn('status_booking', ['draft', 'confirmed'])
                    ->count();
                $reasons[] = "masih memiliki {$bookingCount} booking aktif/draft";
            }

            if ($hasSopir) {
                $sopirName = $bu->sopir ? $bu->sopir->nama_sopir : 'Sopir';
                $reasons[] = "masih ada sopir yang bertugas ({$sopirName})";
            }

            $reasonText = implode(' dan ', $reasons);

            return back()->with('error', "Bus tidak dapat dihapus karena {$reasonText}. Silakan lepaskan sopir terlebih dahulu atau batalkan booking yang aktif.");
        }

        // Jika lolos validasi, lakukan soft delete
        $bu->delete();

        return redirect()->route('admin.operasional.bus.index')
            ->with('success', 'Data bus berhasil dihapus (soft delete). Data historis tetap tersimpan.');
    }

    /**
     * TAMBAHAN: Method untuk melepaskan sopir dari bus
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeSopir(Bus $bu)
    {
        // Validasi: Cek apakah bus sedang dipakai hari ini
        $today = DateHelper::today();
        $sedangDipakai = $bu->bookings()
            ->where('status_booking', 'confirmed')
            ->whereDate('tanggal_berangkat', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->exists();

        if ($sedangDipakai) {
            return back()->with('error', 'Bus sedang digunakan pada booking aktif hari ini, tidak dapat melepaskan sopir');
        }

        // Cek apakah bus memiliki sopir
        if (! $bu->sopir_id) {
            return back()->with('info', 'Bus ini tidak memiliki sopir yang ditugaskan');
        }

        // Simpan nama sopir untuk pesan
        $sopirName = $bu->sopir ? $bu->sopir->nama_sopir : 'Sopir';
        $busName = $bu->nama_bus;

        // Lepaskan sopir (set sopir_id menjadi NULL)
        $bu->sopir_id = null;
        $bu->save();

        return back()->with('success', "{$sopirName} berhasil dilepaskan dari bus {$busName}. Sopir sekarang tersedia untuk ditugaskan ke bus lain.");
    }

    /**
     * Update status bus (hanya antara aktif dan perawatan)
     */
    public function updateStatus(Request $request, Bus $bu)
    {
        $validated = $request->validate([
            'status' => 'required|in:aktif,perawatan',
        ]);

        $today = DateHelper::today();
        $sedangDipakai = $bu->bookings()
            ->where('status_booking', 'confirmed')
            ->whereDate('tanggal_berangkat', '<=', $today)
            ->whereDate('tanggal_selesai', '>=', $today)
            ->exists();

        if ($sedangDipakai && $validated['status'] === 'perawatan') {
            return back()->with('error', 'Bus sedang digunakan pada booking aktif hari ini, tidak dapat dipindah ke perawatan');
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

        $tanggalBerangkat = DateHelper::parse($request->tanggal_berangkat);
        $tanggalSelesai = DateHelper::parse($request->tanggal_selesai);

        $tersedia = $bu->isTersediaPadaTanggal($tanggalBerangkat, $tanggalSelesai);

        if (! $tersedia) {
            $reason = '';

            if ($bu->status === 'perawatan') {
                $reason = 'Bus sedang dalam perawatan';
            } elseif (! $bu->sopir_id) {
                $reason = 'Bus belum memiliki sopir';
            } elseif ($bu->sopir && $bu->sopir->status !== 'aktif') {
                $reason = 'Sopir bus tidak dalam status aktif';
            } else {
                $conflictBooking = $bu->bookings()
                    ->where('status_booking', 'confirmed')
                    ->where(function ($query) use ($tanggalBerangkat, $tanggalSelesai) {
                        $query->whereDate('tanggal_berangkat', '<=', $tanggalSelesai)
                            ->whereDate('tanggal_selesai', '>=', $tanggalBerangkat);
                    })
                    ->first();

                if ($conflictBooking) {
                    $reason = 'Bus sudah dibooking';

                    return response()->json([
                        'tersedia' => false,
                        'message' => $reason,
                        'conflict' => [
                            'kode_booking' => $conflictBooking->kode_booking,
                            'tanggal_berangkat' => DateHelper::formatIndonesia($conflictBooking->tanggal_berangkat),
                            'tanggal_selesai' => DateHelper::formatIndonesia($conflictBooking->tanggal_selesai),
                        ],
                    ]);
                }
            }

            return response()->json([
                'tersedia' => false,
                'message' => $reason,
            ]);
        }

        return response()->json([
            'tersedia' => true,
            'message' => 'Bus tersedia pada tanggal tersebut',
        ]);
    }
}
