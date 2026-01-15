<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'nama' => 'Owner',
                'slug' => 'owner',
                'deskripsi' => 'Pemilik perusahaan dengan akses penuh ke semua fitur'
            ],
            [
                'nama' => 'Admin Company',
                'slug' => 'admin-company',
                'deskripsi' => 'Administrator perusahaan yang mengelola konten website'
            ],
            [
                'nama' => 'Admin Operasional',
                'slug' => 'admin-operasional',
                'deskripsi' => 'Administrator perusahaan yang mengelola operasional'
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
