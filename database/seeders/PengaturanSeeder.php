<?php

namespace Database\Seeders;

use App\Models\Pengaturan;
use Illuminate\Database\Seeder;

class PengaturanSeeder extends Seeder
{
    public function run(): void
    {
        Pengaturan::create([
            'nama_perusahaan' => 'Nama Perusahaan',
            'tagline' => 'Tagline Perusahaan Anda',
            'deskripsi' => 'Deskripsi lengkap tentang perusahaan Anda.',
            'alamat' => 'Alamat lengkap perusahaan',
            'telepon' => '021-12345678',
            'whatsapp' => '08123456789',
            'email' => 'info@perusahaan.com',
            'facebook' => 'https://facebook.com/perusahaan',
            'instagram' => 'https://instagram.com/perusahaan',
            'twitter' => 'https://twitter.com/perusahaan',
            'youtube' => 'https://youtube.com/@perusahaan',
            'meta_title' => 'Nama Perusahaan - Tagline',
            'meta_description' => 'Deskripsi meta untuk SEO',
            'meta_keywords' => 'keyword1, keyword2, keyword3',
        ]);
    }
}