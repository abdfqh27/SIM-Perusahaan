<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $roleOwner = Role::where('slug', 'owner')->first();
        $roleAdminCompany = Role::where('slug', 'admin-company')->first();
        $roleAdminOperasional = Role::where('slug', 'admin-operasional')->first();

        // Create Owner
        User::create([
            'name' => 'Owner',
            'email' => 'owner@companyprofile.com',
            'password' => Hash::make('password123'),
            'role_id' => $roleOwner->id,
            'email_verified_at' => now()
        ]);

        // Create Admin Company
        User::create([
            'name' => 'Admin Company',
            'email' => 'admin@companyprofile.com',
            'password' => Hash::make('password123'),
            'role_id' => $roleAdminCompany->id,
            'email_verified_at' => now()
        ]);

        // Create Admin Perusahaan
        User::create([
            'name' => 'Admin Operasional',
            'email' => 'admin@operasional.com',
            'password' => Hash::make('password123'),
            'role_id' => $roleAdminOperasional->id,
            'email_verified_at' => now()
        ]);
    }
}

