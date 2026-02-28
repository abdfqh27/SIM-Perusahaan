<?php

namespace Database\Seeders;

use App\Helpers\DateHelper;
use App\Models\Booking;
use App\Models\Bus;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        DateHelper::setDefaultTimezone();

        // Tanggal referensi: 6 Februari 2026
        $today = Carbon::create(2026, 2, 6, 0, 0, 0, 'Asia/Jakarta');

        // Ambil bus yang tersedia (punya sopir aktif)
        $buses = Bus::with('sopir')
            ->whereNotNull('sopir_id')
            ->where('status', 'aktif')
            ->whereHas('sopir', function ($q) {
                $q->where('status', 'aktif');
            })
            ->get();

        if ($buses->count() < 3) {
            $this->command->error('Bus tersedia kurang dari 3! Jalankan BusSeeder terlebih dahulu.');

            return;
        }

        // Data pemesan
        $pemesanList = [
            ['nama' => 'PT. Maju Jaya', 'hp' => '081234567891', 'email' => 'majujaya@email.com'],
            ['nama' => 'Yayasan Pendidikan Harapan', 'hp' => '081234567892', 'email' => 'harapan@email.com'],
            ['nama' => 'Ahmad Rizki', 'hp' => '081234567893', 'email' => 'ahmadrizki@email.com'],
            ['nama' => 'CV. Sejahtera Abadi', 'hp' => '081234567894', 'email' => 'sejahtera@email.com'],
            ['nama' => 'Siti Nurhaliza', 'hp' => '081234567895', 'email' => 'siti@email.com'],
            ['nama' => 'Keluarga Besar Pak Hendra', 'hp' => '081234567896', 'email' => 'hendra@email.com'],
            ['nama' => 'PT. Karya Prima', 'hp' => '081234567897', 'email' => 'karyaprima@email.com'],
            ['nama' => 'Rina Wulandari', 'hp' => '081234567898', 'email' => 'rina@email.com'],
            ['nama' => 'Budi Santoso', 'hp' => '081234567899', 'email' => 'budi@email.com'],
            ['nama' => 'CV. Nusantara Jaya', 'hp' => '081234567800', 'email' => 'nusantara@email.com'],
            ['nama' => 'Agus Setiawan', 'hp' => '081234567801', 'email' => 'agus@email.com'],
            ['nama' => 'PT. Global Mandiri', 'hp' => '081234567802', 'email' => 'global@email.com'],
            ['nama' => 'Dewi Kusuma', 'hp' => '081234567803', 'email' => 'dewi@email.com'],
            ['nama' => 'Rombongan Haji Jakarta', 'hp' => '081234567804', 'email' => 'haji@email.com'],
            ['nama' => 'SMA Negeri 1 Cirebon', 'hp' => '081234567805', 'email' => 'sman1@email.com'],
            ['nama' => 'Universitas Muhammadiyah', 'hp' => '081234567806', 'email' => 'unimuh@email.com'],
            ['nama' => 'Firman Adiputra', 'hp' => '081234567807', 'email' => 'firman@email.com'],
            ['nama' => 'PT. Teknologi Indonesia', 'hp' => '081234567808', 'email' => 'tekindo@email.com'],
            ['nama' => 'Keluarga Ibu Sari', 'hp' => '081234567809', 'email' => 'sari@email.com'],
            ['nama' => 'CV. Mekar Sari', 'hp' => '081234567810', 'email' => 'mekar@email.com'],
        ];

        // Tujuan wisata
        $tujuanList = [
            'Jakarta - Bandung',
            'Yogyakarta',
            'Bali',
            'Semarang',
            'Surabaya',
            'Malang - Bromo',
            'Solo',
            'Dieng',
            'Lombok',
            'Bogor - Puncak',
            'Anyer',
            'Pangandaran',
            'Karimunjawa',
            'Cirebon - Kuningan',
            'Garut',
            'Tasikmalaya',
            'Purwokerto',
            'Magelang - Borobudur',
            'Tegal - Brebes',
            'Jakarta',
        ];

        $bookings = [];
        $bookingCounter = [];

        // Generate 55 booking dari Januari 2025 - Maret 2026
        for ($i = 0; $i < 55; $i++) {
            // Random tanggal dari Januari 2025 sampai Maret 2026
            $randomDays = rand(-400, 45); // -400 hari dari today (sekitar Jan 2025) sampai +45 hari (Mar 2026)
            $tanggalBerangkat = $today->copy()->addDays($randomDays);

            // Durasi perjalanan 1-5 hari
            $durasi = rand(1, 5);
            $tanggalSelesai = $tanggalBerangkat->copy()->addDays($durasi);

            // Tentukan status booking berdasarkan tanggal
            if ($tanggalSelesai->lt($today)) {
                // Jika selesai sebelum 6 Feb 2026 -> status selesai
                $statusBooking = 'selesai';
                $statusPembayaran = 'lunas';
            } elseif ($tanggalBerangkat->lte($today) && $tanggalSelesai->gte($today)) {
                // Jika sedang berjalan -> status confirmed
                $statusBooking = 'confirmed';
                $statusPembayaran = rand(0, 1) ? 'dp' : 'lunas';
            } elseif ($tanggalBerangkat->gt($today)) {
                // Jika belum mulai (akan datang)
                $randomStatus = rand(1, 10);
                if ($randomStatus <= 7) {
                    $statusBooking = 'confirmed';
                    $statusPembayaran = rand(0, 1) ? 'dp' : 'lunas';
                } elseif ($randomStatus <= 9) {
                    $statusBooking = 'draft';
                    $statusPembayaran = 'belum_bayar';
                } else {
                    $statusBooking = 'batal';
                    $statusPembayaran = 'belum_bayar';
                }
            } else {
                $statusBooking = 'confirmed';
                $statusPembayaran = 'dp';
            }

            // Generate kode booking
            $dateKey = $tanggalBerangkat->format('Ymd');
            if (! isset($bookingCounter[$dateKey])) {
                $bookingCounter[$dateKey] = 1;
            }
            $kodeBooking = 'BKG'.$dateKey.str_pad($bookingCounter[$dateKey], 4, '0', STR_PAD_LEFT);
            $bookingCounter[$dateKey]++;

            // Random pemesan dan tujuan
            $pemesan = $pemesanList[array_rand($pemesanList)];
            $tujuan = $tujuanList[array_rand($tujuanList)];

            // Random bus (1-3 bus)
            $jumlahBus = rand(1, min(3, $buses->count()));
            $selectedBuses = $buses->random($jumlahBus)->pluck('id')->toArray();

            // Hitung total pembayaran (1-15 juta tergantung jumlah bus dan durasi)
            $totalPembayaran = $jumlahBus * $durasi * rand(500000, 1500000);

            // Nominal DP
            if ($statusPembayaran === 'lunas') {
                $nominalDp = $totalPembayaran;
            } elseif ($statusPembayaran === 'dp') {
                $nominalDp = $totalPembayaran * rand(30, 70) / 100;
            } else {
                $nominalDp = 0;
            }

            // Metode pembayaran
            $metodePembayaran = rand(0, 1) ? 'transfer' : 'cash';

            // Jam berangkat
            $jamList = ['04:00:00', '05:00:00', '06:00:00', '07:00:00', '08:00:00', '09:00:00'];
            $jamBerangkat = $jamList[array_rand($jamList)];

            // Catatan
            $catatanList = [
                'Perjalanan dinas perusahaan',
                'Study tour mahasiswa',
                'Trip keluarga',
                'Wisata rombongan',
                'Ziarah keluarga besar',
                'Outing kantor',
                'Gathering perusahaan',
                null,
                null,
            ];
            $catatan = $catatanList[array_rand($catatanList)];

            // Tempat jemput
            $tempatJemputList = [
                'Kantor PT. '.$pemesan['nama'],
                'Hotel Grand Cirebon',
                'Kampus Universitas',
                'Rumah Jl. Kesambi No. '.rand(1, 100),
                'Terminal Harjamukti Cirebon',
                'Stasiun Cirebon',
                'Alun-alun Kejaksan',
                'Mall CSB',
            ];
            $tempatJemput = $tempatJemputList[array_rand($tempatJemputList)];

            $bookingData = [
                'kode_booking' => $kodeBooking,
                'nama_pemesan' => $pemesan['nama'],
                'no_hp_pemesan' => $pemesan['hp'],
                'email_pemesan' => $pemesan['email'],
                'tujuan' => $tujuan,
                'tempat_jemput' => $tempatJemput,
                'tanggal_berangkat' => $tanggalBerangkat,
                'tanggal_selesai' => $tanggalSelesai,
                'jam_berangkat' => $jamBerangkat,
                'total_pembayaran' => $totalPembayaran,
                'nominal_dp' => $nominalDp,
                'metode_pembayaran' => $metodePembayaran,
                'status_pembayaran' => $statusPembayaran,
                'status_booking' => $statusBooking,
                'catatan' => $catatan,
                'created_at' => $tanggalBerangkat->copy()->subDays(rand(3, 30)),
                'updated_at' => $tanggalBerangkat->copy()->subDays(rand(1, 3)),
            ];

            $bookings[] = [
                'data' => $bookingData,
                'buses' => $selectedBuses,
            ];
        }

        // Sort berdasarkan tanggal berangkat
        usort($bookings, function ($a, $b) {
            return $a['data']['tanggal_berangkat']->timestamp <=> $b['data']['tanggal_berangkat']->timestamp;
        });

        // Insert ke database
        foreach ($bookings as $bookingItem) {
            $booking = Booking::create($bookingItem['data']);
            $booking->buses()->attach($bookingItem['buses']);
        }

        // Hitung statistik
        $totalSelesai = Booking::where('status_booking', 'selesai')->count();
        $totalConfirmed = Booking::where('status_booking', 'confirmed')->count();
        $totalDraft = Booking::where('status_booking', 'draft')->count();
        $totalBatal = Booking::where('status_booking', 'batal')->count();

        $this->command->info('✅ Seeder booking berhasil!');
        $this->command->info('📊 Total: '.count($bookings).' booking');
        $this->command->info("   - Selesai: {$totalSelesai}");
        $this->command->info("   - Confirmed: {$totalConfirmed}");
        $this->command->info("   - Draft: {$totalDraft}");
        $this->command->info("   - Batal: {$totalBatal}");
    }
}
