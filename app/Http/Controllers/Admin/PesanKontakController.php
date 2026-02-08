<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use App\Models\PesanKontak;
use Illuminate\Http\Request;

class PesanKontakController extends Controller
{
    public function index()
    {
        DateHelper::setDefaultTimezone();

        $pesanKontaks = PesanKontak::latest()->get();
        $jumlahBelumDibaca = PesanKontak::belumDibaca()->count();

        return view('admin.pesan-kontak.index', compact('pesanKontaks', 'jumlahBelumDibaca'));
    }

    public function show($id)
    {
        DateHelper::setDefaultTimezone();

        $pesanKontak = PesanKontak::findOrFail($id);

        // Automatically mark as read when viewing
        if (! $pesanKontak->sudah_dibaca) {
            $pesanKontak->tandaiSudahDibaca();
        }

        return view('admin.pesan-kontak.show', compact('pesanKontak'));
    }

    public function markAsRead($id)
    {
        $pesanKontak = PesanKontak::findOrFail($id);

        if ($pesanKontak->sudah_dibaca) {
            return redirect()
                ->route('admin.pesan-kontak.index')
                ->with('error', 'Pesan sudah ditandai sebagai dibaca sebelumnya');
        }

        $pesanKontak->tandaiSudahDibaca();

        return redirect()
            ->route('admin.pesan-kontak.index')
            ->with('success', 'Pesan berhasil ditandai sebagai sudah dibaca');
    }

    public function destroy($id)
    {
        try {
            $pesanKontak = PesanKontak::findOrFail($id);
            $nama = $pesanKontak->nama;
            $pesanKontak->delete();

            return redirect()
                ->route('admin.pesan-kontak.index')
                ->with('success', "Pesan dari {$nama} berhasil dihapus");
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.pesan-kontak.index')
                ->with('error', 'Gagal menghapus pesan: '.$e->getMessage());
        }
    }

    public function checkNewMessages()
    {
        $jumlahBelumDibaca = PesanKontak::belumDibaca()->count();
        $pesanTerbaru = PesanKontak::belumDibaca()
            ->latest()
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'count' => $jumlahBelumDibaca,
            'messages' => $pesanTerbaru->map(function ($pesan) {
                return [
                    'id' => $pesan->id,
                    'nama' => $pesan->nama,
                    'email' => $pesan->email,
                    'subjek' => $pesan->subjek,
                    'waktu' => $pesan->created_at->diffForHumans(),
                    'tanggal' => $pesan->created_at->format('d M Y H:i'),
                ];
            }),
        ]);
    }

    public function bulkMarkAsRead(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada pesan yang dipilih',
            ], 400);
        }

        $updated = PesanKontak::whereIn('id', $ids)
            ->where('sudah_dibaca', false)
            ->update([
                'sudah_dibaca' => true,
                'tanggal_dibaca' => now(),
            ]);

        return response()->json([
            'success' => true,
            'message' => "{$updated} pesan berhasil ditandai sebagai dibaca",
            'count' => $updated,
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada pesan yang dipilih',
            ], 400);
        }

        $deleted = PesanKontak::whereIn('id', $ids)->delete();

        return response()->json([
            'success' => true,
            'message' => "{$deleted} pesan berhasil dihapus",
            'count' => $deleted,
        ]);
    }

    public function getStatistics()
    {
        $total = PesanKontak::count();
        $belumDibaca = PesanKontak::belumDibaca()->count();
        $sudahDibaca = PesanKontak::where('sudah_dibaca', true)->count();
        $hariIni = PesanKontak::whereDate('created_at', today())->count();
        $mingguIni = PesanKontak::whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek(),
        ])->count();

        return response()->json([
            'success' => true,
            'statistics' => [
                'total' => $total,
                'belum_dibaca' => $belumDibaca,
                'sudah_dibaca' => $sudahDibaca,
                'hari_ini' => $hariIni,
                'minggu_ini' => $mingguIni,
                'persentase_dibaca' => $total > 0 ? round(($sudahDibaca / $total) * 100, 2) : 0,
            ],
        ]);
    }
}
