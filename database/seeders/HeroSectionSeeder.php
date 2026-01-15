<?php
namespace Database\Seeders;

use App\Models\HeroSection;
use Illuminate\Database\Seeder;

class HeroSectionSeeder extends Seeder
{
    public function run(): void
    {
        $heroes = [
            [
                'judul' => 'Perjalanan Nyaman Bersama Kami',
                'deskripsi' => 'Nikmati perjalanan yang aman dan nyaman dengan armada bus terlengkap dan layanan terbaik',
                'tombol_text' => 'Hubungi Kami',
                'tombol_link' => '/kontak',
                'gambar' => '',
                'urutan' => 1,
                'aktif' => true
            ],
            [
                'judul' => 'Armada Bus Terlengkap',
                'deskripsi' => 'Berbagai pilihan bus dengan kapasitas dan fasilitas sesuai kebutuhan perjalanan Anda',
                'tombol_text' => 'Lihat Armada',
                'tombol_link' => '/armada',
                'gambar' => '',
                'urutan' => 2,
                'aktif' => true
            ],
            [
                'judul' => 'Pelayanan Profesional 24/7',
                'deskripsi' => 'Tim profesional kami siap melayani kebutuhan transportasi Anda kapan saja',
                'tombol_text' => 'Pesan Sekarang',
                'tombol_link' => '/kontak',
                'gambar' => '',
                'urutan' => 3,
                'aktif' => true
            ]
        ];

        foreach ($heroes as $hero) {
            HeroSection::create($hero);
        }
    }
}

