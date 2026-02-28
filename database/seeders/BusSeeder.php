<?php

namespace Database\Seeders;

use App\Models\Bus;
use App\Models\KategoriBus;
use App\Models\Sopir;
use Illuminate\Database\Seeder;

class BusSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil kategori bus yang sudah ada
        $kategoriBusMedium = KategoriBus::where('nama_kategori', 'Bus Medium')->first();
        $kategoriBusBesar = KategoriBus::where('nama_kategori', 'Bus Besar')->first();
        $kategoriBusExecutive = KategoriBus::where('nama_kategori', 'Bus Executive')->first();
        $kategoriBusVIP = KategoriBus::where('nama_kategori', 'Bus VIP')->first();

        if (! $kategoriBusMedium || ! $kategoriBusBesar || ! $kategoriBusExecutive || ! $kategoriBusVIP) {
            $this->command->error('Kategori bus belum ada! Jalankan KategoriBusSeeder terlebih dahulu.');

            return;
        }

        // Ambil sopir yang aktif
        $sopirAktif = Sopir::where('status', 'aktif')->get();

        if ($sopirAktif->count() < 5) {
            $this->command->error('Sopir aktif kurang dari 5! Jalankan SopirSeeder terlebih dahulu.');

            return;
        }

        $buses = [
            // Bus Besar
            [
                'kode_bus' => 'BUS001',
                'nama_bus' => 'Garuda Mas 1',
                'kategori_bus_id' => $kategoriBusBesar->id,
                'sopir_id' => $sopirAktif[0]->id,
                'warna_bus' => 'Merah',
                'nomor_polisi' => 'E 1234 AB',
                'status' => 'aktif',
            ],
            [
                'kode_bus' => 'BUS002',
                'nama_bus' => 'Garuda Mas 2',
                'kategori_bus_id' => $kategoriBusBesar->id,
                'sopir_id' => $sopirAktif[1]->id,
                'warna_bus' => 'Biru',
                'nomor_polisi' => 'E 1235 AB',
                'status' => 'aktif',
            ],
            [
                'kode_bus' => 'BUS003',
                'nama_bus' => 'Garuda Mas 3',
                'kategori_bus_id' => $kategoriBusBesar->id,
                'sopir_id' => null, // Bus tanpa sopir
                'warna_bus' => 'Hijau',
                'nomor_polisi' => 'E 1236 AB',
                'status' => 'aktif',
            ],

            // Bus Medium
            [
                'kode_bus' => 'BUS004',
                'nama_bus' => 'Elang Express 1',
                'kategori_bus_id' => $kategoriBusMedium->id,
                'sopir_id' => $sopirAktif[2]->id,
                'warna_bus' => 'Putih',
                'nomor_polisi' => 'E 2345 CD',
                'status' => 'aktif',
            ],
            [
                'kode_bus' => 'BUS005',
                'nama_bus' => 'Elang Express 2',
                'kategori_bus_id' => $kategoriBusMedium->id,
                'sopir_id' => $sopirAktif[3]->id,
                'warna_bus' => 'Hitam',
                'nomor_polisi' => 'E 2346 CD',
                'status' => 'aktif',
            ],
            [
                'kode_bus' => 'BUS006',
                'nama_bus' => 'Elang Express 3',
                'kategori_bus_id' => $kategoriBusMedium->id,
                'sopir_id' => $sopirAktif[4]->id,
                'warna_bus' => 'Abu-abu',
                'nomor_polisi' => 'E 2347 CD',
                'status' => 'perawatan',
            ],

            // Bus Executive
            [
                'kode_bus' => 'BUS007',
                'nama_bus' => 'Executive Premium 1',
                'kategori_bus_id' => $kategoriBusExecutive->id,
                'sopir_id' => $sopirAktif[5]->id ?? null,
                'warna_bus' => 'Silver',
                'nomor_polisi' => 'E 3456 EF',
                'status' => 'aktif',
            ],
            [
                'kode_bus' => 'BUS008',
                'nama_bus' => 'Executive Premium 2',
                'kategori_bus_id' => $kategoriBusExecutive->id,
                'sopir_id' => $sopirAktif[6]->id ?? null,
                'warna_bus' => 'Coklat',
                'nomor_polisi' => 'E 3457 EF',
                'status' => 'aktif',
            ],

            // Bus VIP
            [
                'kode_bus' => 'BUS009',
                'nama_bus' => 'VIP Luxury 1',
                'kategori_bus_id' => $kategoriBusVIP->id,
                'sopir_id' => $sopirAktif[7]->id ?? null,
                'warna_bus' => 'Hitam Metalik',
                'nomor_polisi' => 'E 4567 GH',
                'status' => 'aktif',
            ],
            [
                'kode_bus' => 'BUS010',
                'nama_bus' => 'VIP Luxury 2',
                'kategori_bus_id' => $kategoriBusVIP->id,
                'sopir_id' => $sopirAktif[8]->id ?? null,
                'warna_bus' => 'Putih Pearl',
                'nomor_polisi' => 'E 4568 GH',
                'status' => 'aktif',
            ],
        ];

        foreach ($buses as $bus) {
            Bus::create($bus);
        }

        $this->command->info('Seeder bus berhasil! Total: '.count($buses).' bus');
    }
}
