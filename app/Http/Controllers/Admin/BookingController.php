<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Models\Bus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        // Set timezone untuk request ini
        Carbon::setLocale('id');

        // Query dasar dengan eager loading
        $query = Booking::with(['buses.sopir', 'buses.kategoriBus']);

        // Filter berdasarkan status booking
        if ($request->filled('status')) {
            $query->where('status_booking', $request->status);
        }

        // Filter berdasarkan status pembayaran
        if ($request->filled('pembayaran')) {
            $query->where('status_pembayaran', $request->pembayaran);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_dari')) {
            $tanggalDari = Carbon::parse($request->tanggal_dari, 'Asia/Jakarta')->startOfDay();
            $query->whereDate('tanggal_berangkat', '>=', $tanggalDari);
        }

        if ($request->filled('tanggal_sampai')) {
            $tanggalSampai = Carbon::parse($request->tanggal_sampai, 'Asia/Jakarta')->endOfDay();
            $query->whereDate('tanggal_berangkat', '<=', $tanggalSampai);
        }

        // Search berdasarkan kode booking, nama pemesan, atau tujuan
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_booking', 'like', "%{$search}%")
                    ->orWhere('nama_pemesan', 'like', "%{$search}%")
                    ->orWhere('tujuan', 'like', "%{$search}%")
                    ->orWhere('no_hp_pemesan', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Get bookings
        $bookings = $query->get();

        // Statistik
        $stats = [
            'total' => Booking::count(),
            'draft' => Booking::where('status_booking', 'draft')->count(),
            'confirmed' => Booking::where('status_booking', 'confirmed')->count(),
            'selesai' => Booking::where('status_booking', 'selesai')->count(),
            'batal' => Booking::where('status_booking', 'batal')->count(),
        ];

        // Waktu saat ini (untuk keperluan lain jika diperlukan)
        $waktuSekarang = Carbon::now('Asia/Jakarta')->translatedFormat('l, d F Y - H:i:s').' WIB';

        // Passing filter values ke view untuk maintain state
        $filters = [
            'status' => $request->status,
            'pembayaran' => $request->pembayaran,
            'tanggal_dari' => $request->tanggal_dari,
            'tanggal_sampai' => $request->tanggal_sampai,
            'search' => $request->search,
            'sort_by' => $sortBy,
            'sort_order' => $sortOrder,
        ];

        return view('admin.operasional.booking.index', compact('bookings', 'stats', 'filters', 'waktuSekarang'));
    }

    public function create()
    {
        // Ambil semua bus aktif (untuk ditampilkan di form)
        // Filter ketersediaan akan dilakukan di client-side berdasarkan tanggal yang dipilih
        $buses = Bus::with(['kategoriBus', 'sopir'])
            ->aktif()
            ->get();

        return view('admin.operasional.booking.create', compact('buses'));
    }

    public function store(BookingRequest $request)
    {
        DB::beginTransaction();
        try {
            // Parse tanggal dengan timezone Asia/Jakarta
            $data = $request->except('bus_ids');
            if (isset($data['tanggal_berangkat'])) {
                $data['tanggal_berangkat'] = Carbon::parse($data['tanggal_berangkat'], 'Asia/Jakarta');
            }
            if (isset($data['tanggal_selesai'])) {
                $data['tanggal_selesai'] = Carbon::parse($data['tanggal_selesai'], 'Asia/Jakarta');
            }

            // Create booking (validasi sudah dilakukan di BookingRequest)
            $booking = Booking::create($data);

            // Attach buses
            $booking->buses()->attach($request->bus_ids);

            DB::commit();

            return redirect()->route('admin.operasional.booking.index')
                ->with('success', 'Booking berhasil dibuat dengan kode: '.$booking->kode_booking);

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->with('error', 'Gagal membuat booking: '.$e->getMessage());
        }
    }

    public function show(Booking $booking)
    {
        $booking->load(['buses.sopir', 'buses.kategoriBus']);

        // Hitung durasi (akan otomatis dari accessor)
        $durasi = $booking->durasi_hari;

        return view('admin.operasional.booking.show', compact('booking', 'durasi'));
    }

    public function edit(Booking $booking)
    {
        // Hanya draft dan confirmed yang bisa diedit
        if (! in_array($booking->status_booking, ['draft', 'confirmed'])) {
            return back()->with('error', 'Booking dengan status '.$booking->status_booking.' tidak dapat diedit');
        }

        $buses = Bus::with(['kategoriBus', 'sopir'])
            ->aktif()
            ->get();

        $selectedBusIds = $booking->buses->pluck('id')->toArray();

        return view('admin.operasional.booking.edit', compact('booking', 'buses', 'selectedBusIds'));
    }

    public function update(BookingRequest $request, Booking $booking)
    {
        DB::beginTransaction();
        try {
            // Parse tanggal dengan timezone Asia/Jakarta
            $data = $request->except('bus_ids');
            if (isset($data['tanggal_berangkat'])) {
                $data['tanggal_berangkat'] = Carbon::parse($data['tanggal_berangkat'], 'Asia/Jakarta');
            }
            if (isset($data['tanggal_selesai'])) {
                $data['tanggal_selesai'] = Carbon::parse($data['tanggal_selesai'], 'Asia/Jakarta');
            }

            // Update booking (validasi sudah dilakukan di BookingRequest)
            $booking->update($data);

            // Sync buses
            $booking->buses()->sync($request->bus_ids);

            DB::commit();

            return redirect()->route('admin.operasional.booking.index')
                ->with('success', 'Booking berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()->with('error', 'Gagal memperbarui booking: '.$e->getMessage());
        }
    }

    public function destroy(Booking $booking)
    {
        // Hanya draft dan batal yang bisa dihapus
        if (! in_array($booking->status_booking, ['draft', 'batal'])) {
            return back()->with('error', 'Hanya booking dengan status draft atau batal yang dapat dihapus');
        }

        DB::beginTransaction();
        try {
            $booking->delete();

            DB::commit();

            return redirect()->route('admin.operasional.booking.index')
                ->with('success', 'Booking berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Gagal menghapus booking: '.$e->getMessage());
        }
    }

    /**
     * Update status booking
     */
    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status_booking' => 'required|in:draft,confirmed,selesai,batal',
        ]);

        DB::beginTransaction();
        try {
            $booking->update(['status_booking' => $validated['status_booking']]);

            DB::commit();

            return back()->with('success', 'Status booking berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Gagal memperbarui status: '.$e->getMessage());
        }
    }

    /**
     * API untuk mendapatkan bus yang tersedia pada rentang tanggal tertentu
     * Digunakan untuk AJAX request dari form
     */
    public function getBusTersedia(Request $request)
    {
        $request->validate([
            'tanggal_berangkat' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_berangkat',
            'booking_id' => 'nullable|exists:booking,id',
        ]);

        // Parse tanggal dengan timezone Asia/Jakarta
        $tanggalBerangkat = Carbon::parse($request->tanggal_berangkat, 'Asia/Jakarta');
        $tanggalSelesai = Carbon::parse($request->tanggal_selesai, 'Asia/Jakarta');

        $buses = Bus::with(['kategoriBus', 'sopir'])
            ->tersediaPadaTanggal($tanggalBerangkat, $tanggalSelesai)
            ->get()
            ->map(function ($bus) {
                return [
                    'id' => $bus->id,
                    'kode_bus' => $bus->kode_bus,
                    'nama_bus' => $bus->nama_bus,
                    'kategori' => $bus->kategoriBus->nama_kategori ?? '-',
                    'sopir' => $bus->sopir->nama ?? '-',
                    'nomor_polisi' => $bus->nomor_polisi,
                    'status' => $bus->status,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $buses,
            'info' => [
                'tanggal_berangkat' => $tanggalBerangkat->translatedFormat('d F Y'),
                'tanggal_selesai' => $tanggalSelesai->translatedFormat('d F Y'),
                'durasi' => $tanggalBerangkat->diffInDays($tanggalSelesai).' hari',
            ],
        ]);
    }
}
