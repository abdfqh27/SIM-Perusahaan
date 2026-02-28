<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            HeroSectionSeeder::class,
            PengaturanSeeder::class,
            KategoriBusSeeder::class,
            SopirSeeder::class,
            BusSeeder::class,
            BookingSeeder::class,
        ]);
    }
}
