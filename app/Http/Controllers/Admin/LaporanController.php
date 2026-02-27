<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DateHelper;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Bus;
use App\Models\Pengaturan;
use App\Models\Sopir;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    protected $pengaturan;

    public function __construct()
    {
        DateHelper::setDefaultTimezone();
        $this->pengaturan = Pengaturan::getData();
    }

    // Halaman utama laporan
    public function index()
    {
        $data = [
            'pageTitle' => 'Laporan',
            'listTahun' => DateHelper::getListTahun(),
            'listBulan' => DateHelper::getListBulan(),
        ];

        return view('admin.laporan.index', $data);
    }

    // LAPORAN JADWAL KEBERANGKATAN BUS
    public function jadwalKeberangkatan(Request $request)
    {
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ]);

        $tanggalAwal = DateHelper::parse($request->tanggal_awal);
        $tanggalAkhir = DateHelper::parse($request->tanggal_akhir);

        // Perbaikan: Eager loading yang lebih spesifik
        $bookings = Booking::with([
            'buses' => function ($query) {
                $query->select('bus.id', 'bus.kode_bus', 'bus.nomor_polisi', 'bus.sopir_id', 'bus.kategori_bus_id');
            },
            'buses.kategoriBus:id,nama_kategori',
            'buses.sopir:id,nama_sopir',
        ])
            ->where('status_booking', 'confirmed')
            ->whereBetween('tanggal_berangkat', [$tanggalAwal, $tanggalAkhir])
            ->orderBy('tanggal_berangkat', 'asc')
            ->orderBy('jam_berangkat', 'asc')
            ->get();

        // Debug: Cek apakah data bus dan sopir ter-load
        // dd($bookings->first()->buses); // Uncomment untuk debugging

        $data = [
            'bookings' => $bookings,
            'tanggalAwal' => $tanggalAwal,
            'tanggalAkhir' => $tanggalAkhir,
            'judul' => 'Laporan Jadwal Keberangkatan Bus',
            'pengaturan' => $this->pengaturan,
        ];

        if ($request->format === 'pdf') {
            $pdf = Pdf::loadView('admin.laporan.pdf.jadwal-keberangkatan', $data)
                ->setPaper('a4', 'landscape');

            return $pdf->download('laporan-jadwal-keberangkatan-'.now()->format('Ymd-His').'.pdf');
        }

        return view('admin.laporan.jadwal-keberangkatan', $data);
    }

    // LAPORAN KETERSEDIAAN BUS
    public function ketersediaanBus(Request $request)
    {
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ]);

        $tanggalAwal = DateHelper::parse($request->tanggal_awal);
        $tanggalAkhir = DateHelper::parse($request->tanggal_akhir);

        // Ambil semua bus dengan eager loading yang lebih spesifik
        $buses = Bus::with([
            'kategoriBus:id,nama_kategori',
            'sopir:id,nama_sopir',
            'bookings' => function ($query) use ($tanggalAwal, $tanggalAkhir) {
                $query->select('booking.id', 'booking.kode_booking', 'booking.tujuan',
                    'booking.tanggal_berangkat', 'booking.tanggal_selesai',
                    'booking.status_booking')
                    ->where('status_booking', 'confirmed')
                    ->where(function ($q) use ($tanggalAwal, $tanggalAkhir) {
                        // Booking yang overlap dengan periode
                        $q->whereBetween('tanggal_berangkat', [$tanggalAwal, $tanggalAkhir])
                            ->orWhereBetween('tanggal_selesai', [$tanggalAwal, $tanggalAkhir])
                            ->orWhere(function ($q2) use ($tanggalAwal, $tanggalAkhir) {
                                // Booking yang mencakup seluruh periode
                                $q2->where('tanggal_berangkat', '<=', $tanggalAwal)
                                    ->where('tanggal_selesai', '>=', $tanggalAkhir);
                            });
                    })
                    ->orderBy('tanggal_berangkat', 'asc');
            },
        ])
            ->select('id', 'kode_bus', 'nomor_polisi', 'kategori_bus_id', 'sopir_id', 'status')
            ->get();

        // Debug: Uncomment baris berikut untuk troubleshooting
        // dd($buses->first());

        $data = [
            'buses' => $buses,
            'tanggalAwal' => $tanggalAwal,
            'tanggalAkhir' => $tanggalAkhir,
            'judul' => 'Laporan Ketersediaan Bus',
            'pengaturan' => $this->pengaturan,
        ];

        if ($request->format === 'pdf') {
            $pdf = Pdf::loadView('admin.laporan.pdf.ketersediaan-bus', $data)
                ->setPaper('a4', 'landscape');

            return $pdf->download('laporan-ketersediaan-bus-'.now()->format('Ymd-His').'.pdf');
        }

        return view('admin.laporan.ketersediaan-bus', $data);
    }

    // LAPORAN PENDAPATAN
    public function pendapatan(Request $request)
    {
        $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020',
        ]);

        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $monthRange = DateHelper::getMonthRange($bulan, $tahun);

        // Ambil booking dalam periode tersebut
        $bookings = Booking::with(['buses.kategoriBus'])
            ->whereBetween('tanggal_berangkat', [$monthRange['start'], $monthRange['end']])
            ->orderBy('tanggal_berangkat', 'asc')
            ->get();

        // Hitung total pendapatan
        $totalPendapatan = $bookings->sum('total_pembayaran');
        $totalDP = $bookings->sum('nominal_dp');
        $totalLunas = $bookings->where('status_pembayaran', 'lunas')->sum('total_pembayaran');
        $totalBelumLunas = $bookings->where('status_pembayaran', '!=', 'lunas')->sum(function ($booking) {
            return $booking->total_pembayaran - ($booking->nominal_dp ?? 0);
        });

        // Group by status pembayaran
        $byStatusPembayaran = $bookings->groupBy('status_pembayaran')->map(function ($items) {
            return [
                'count' => $items->count(),
                'total' => $items->sum('total_pembayaran'),
            ];
        });

        // Group by kategori bus
        $byKategoriBus = $bookings->flatMap(function ($booking) {
            return $booking->buses->map(function ($bus) use ($booking) {
                return [
                    'kategori' => $bus->kategoriBus->nama_kategori ?? 'Tidak Ada Kategori',
                    'pendapatan' => $booking->total_pembayaran / $booking->buses->count(),
                ];
            });
        })->groupBy('kategori')->map(function ($items) {
            return [
                'count' => $items->count(),
                'total' => $items->sum('pendapatan'),
            ];
        });

        $data = [
            'bookings' => $bookings,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'namaBulan' => DateHelper::getBulanIndonesia($bulan),
            'totalPendapatan' => $totalPendapatan,
            'totalDP' => $totalDP,
            'totalLunas' => $totalLunas,
            'totalBelumLunas' => $totalBelumLunas,
            'byStatusPembayaran' => $byStatusPembayaran,
            'byKategoriBus' => $byKategoriBus,
            'judul' => 'Laporan Pendapatan',
            'pengaturan' => $this->pengaturan,
        ];

        if ($request->format === 'pdf') {
            $pdf = Pdf::loadView('admin.laporan.pdf.pendapatan', $data)
                ->setPaper('a4', 'portrait');

            return $pdf->download('laporan-pendapatan-'.$bulan.'-'.$tahun.'.pdf');
        }

        if ($request->format === 'excel') {
            return $this->exportPendapatanExcel($data);
        }

        return view('admin.laporan.pendapatan', $data);
    }

    // LAPORAN PERFORMA BUS
    public function performaBus(Request $request)
    {
        $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020',
        ]);

        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $monthRange = DateHelper::getMonthRange($bulan, $tahun);

        // Ambil semua bus dengan booking-nya
        $buses = Bus::with(['kategoriBus', 'sopir'])
            ->withCount(['bookings as total_trip' => function ($query) use ($monthRange) {
                $query->where('status_booking', 'confirmed')
                    ->whereBetween('tanggal_berangkat', [$monthRange['start'], $monthRange['end']]);
            }])
            ->get()
            ->map(function ($bus) use ($monthRange) {
                // Hitung total pendapatan dari bus ini
                $totalPendapatan = $bus->bookings()
                    ->where('status_booking', 'confirmed')
                    ->whereBetween('tanggal_berangkat', [$monthRange['start'], $monthRange['end']])
                    ->get()
                    ->sum(function ($booking) {
                        // Bagi rata jika bus lebih dari satu
                        return $booking->total_pembayaran / $booking->buses->count();
                    });

                // Hitung total hari digunakan
                $totalHari = $bus->bookings()
                    ->where('status_booking', 'confirmed')
                    ->whereBetween('tanggal_berangkat', [$monthRange['start'], $monthRange['end']])
                    ->get()
                    ->sum(function ($booking) {
                        return DateHelper::diffInDays($booking->tanggal_berangkat, $booking->tanggal_selesai);
                    });

                $bus->total_pendapatan = $totalPendapatan;
                $bus->total_hari = $totalHari;
                $bus->rata_rata_per_trip = $bus->total_trip > 0 ? $totalPendapatan / $bus->total_trip : 0;

                return $bus;
            })
            ->sortByDesc('total_pendapatan');

        $data = [
            'buses' => $buses,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'namaBulan' => DateHelper::getBulanIndonesia($bulan),
            'totalBus' => $buses->count(),
            'totalPendapatan' => $buses->sum('total_pendapatan'),
            'totalTrip' => $buses->sum('total_trip'),
            'judul' => 'Laporan Performa Bus',
            'pengaturan' => $this->pengaturan,
        ];

        if ($request->format === 'pdf') {
            $pdf = Pdf::loadView('admin.laporan.pdf.performa-bus', $data)
                ->setPaper('a4', 'landscape');

            return $pdf->download('laporan-performa-bus-'.$bulan.'-'.$tahun.'.pdf');
        }

        return view('admin.laporan.performa-bus', $data);
    }

    // LAPORAN REKAP BULANAN
    public function rekapBulanan(Request $request)
    {
        $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020',
        ]);

        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $monthRange = DateHelper::getMonthRange($bulan, $tahun);

        // Data Booking
        $totalBooking = Booking::whereBetween('tanggal_berangkat', [$monthRange['start'], $monthRange['end']])->count();
        $bookingConfirmed = Booking::where('status_booking', 'confirmed')
            ->whereBetween('tanggal_berangkat', [$monthRange['start'], $monthRange['end']])->count();
        $bookingPending = Booking::where('status_booking', 'pending')
            ->whereBetween('tanggal_berangkat', [$monthRange['start'], $monthRange['end']])->count();
        $bookingCancelled = Booking::where('status_booking', 'cancelled')
            ->whereBetween('tanggal_berangkat', [$monthRange['start'], $monthRange['end']])->count();

        // Data Pendapatan
        $totalPendapatan = Booking::whereBetween('tanggal_berangkat', [$monthRange['start'], $monthRange['end']])
            ->sum('total_pembayaran');
        $pendapatanLunas = Booking::where('status_pembayaran', 'lunas')
            ->whereBetween('tanggal_berangkat', [$monthRange['start'], $monthRange['end']])
            ->sum('total_pembayaran');
        $totalDP = Booking::whereBetween('tanggal_berangkat', [$monthRange['start'], $monthRange['end']])
            ->sum('nominal_dp');

        // Data Bus
        $totalBus = Bus::count();
        $busAktif = Bus::where('status', 'aktif')->count();
        $busPerawatan = Bus::where('status', 'perawatan')->count();

        // Data Sopir
        $totalSopir = Sopir::count();
        $sopirAktif = Sopir::where('status', 'aktif')->count();
        $sopirNonAktif = Sopir::where('status', 'non-aktif')->count();

        // Top 5 Tujuan
        $topTujuan = Booking::whereBetween('tanggal_berangkat', [$monthRange['start'], $monthRange['end']])
            ->select('tujuan', DB::raw('count(*) as total'))
            ->groupBy('tujuan')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        $data = [
            'bulan' => $bulan,
            'tahun' => $tahun,
            'namaBulan' => DateHelper::getBulanIndonesia($bulan),
            'totalBooking' => $totalBooking,
            'bookingConfirmed' => $bookingConfirmed,
            'bookingPending' => $bookingPending,
            'bookingCancelled' => $bookingCancelled,
            'totalPendapatan' => $totalPendapatan,
            'pendapatanLunas' => $pendapatanLunas,
            'totalDP' => $totalDP,
            'totalBus' => $totalBus,
            'busAktif' => $busAktif,
            'busPerawatan' => $busPerawatan,
            'totalSopir' => $totalSopir,
            'sopirAktif' => $sopirAktif,
            'sopirNonAktif' => $sopirNonAktif,
            'topTujuan' => $topTujuan,
            'judul' => 'Laporan Rekap Bulanan',
            'pengaturan' => $this->pengaturan,
        ];

        if ($request->format === 'pdf') {
            $pdf = Pdf::loadView('admin.laporan.pdf.rekap-bulanan', $data)
                ->setPaper('a4', 'portrait');

            return $pdf->download('laporan-rekap-bulanan-'.$bulan.'-'.$tahun.'.pdf');
        }

        return view('admin.laporan.rekap-bulanan', $data);
    }

    /**Export Pendapatan ke Excel (Simple)
     */
    private function exportPendapatanExcel($data)
    {
        $filename = 'laporan-pendapatan-'.$data['bulan'].'-'.$data['tahun'].'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];

        $callback = function () use ($data) {
            $file = fopen('php://output', 'w');

            // Header
            fputcsv($file, ['LAPORAN PENDAPATAN']);
            fputcsv($file, ['Periode: '.$data['namaBulan'].' '.$data['tahun']]);
            fputcsv($file, []);

            // Summary
            fputcsv($file, ['RINGKASAN']);
            fputcsv($file, ['Total Pendapatan', DateHelper::formatRupiah($data['totalPendapatan'])]);
            fputcsv($file, ['Total DP', DateHelper::formatRupiah($data['totalDP'])]);
            fputcsv($file, ['Total Lunas', DateHelper::formatRupiah($data['totalLunas'])]);
            fputcsv($file, ['Total Belum Lunas', DateHelper::formatRupiah($data['totalBelumLunas'])]);
            fputcsv($file, []);

            // Detail
            fputcsv($file, ['DETAIL TRANSAKSI']);
            fputcsv($file, ['Kode Booking', 'Tanggal', 'Nama Pemesan', 'Tujuan', 'Total Pembayaran', 'Status Pembayaran']);

            foreach ($data['bookings'] as $booking) {
                fputcsv($file, [
                    $booking->kode_booking,
                    DateHelper::formatIndonesia($booking->tanggal_berangkat),
                    $booking->nama_pemesan,
                    $booking->tujuan,
                    $booking->total_pembayaran,
                    ucfirst($booking->status_pembayaran),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
