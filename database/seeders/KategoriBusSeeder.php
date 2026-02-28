<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriBusSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kategori_bus')->insert([
            [
                'nama_kategori' => 'Bus Medium',
                'kapasitas_min' => 20,
                'kapasitas_max' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Bus Besar',
                'kapasitas_min' => 35,
                'kapasitas_max' => 50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Bus Executive',
                'kapasitas_min' => 25,
                'kapasitas_max' => 35,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Bus VIP',
                'kapasitas_min' => 15,
                'kapasitas_max' => 25,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
