<?php

namespace Database\Seeders;

use App\Models\Sopir;
use Illuminate\Database\Seeder;

class SopirSeeder extends Seeder
{
    public function run(): void
    {
        $sopirs = [
            [
                'nama_sopir' => 'Budi Santoso',
                'nik' => '3201012345670001',
                'no_sim' => 'SIM1234567890001',
                'jenis_sim' => 'SIM B2',
                'no_hp' => '081234567801',
                'alamat' => 'Jl. Merdeka No. 10, Cirebon',
                'status' => 'aktif',
            ],
            [
                'nama_sopir' => 'Ahmad Wijaya',
                'nik' => '3201012345670002',
                'no_sim' => 'SIM1234567890002',
                'jenis_sim' => 'SIM B2',
                'no_hp' => '081234567802',
                'alamat' => 'Jl. Sudirman No. 25, Cirebon',
                'status' => 'aktif',
            ],
            [
                'nama_sopir' => 'Dedi Suryadi',
                'nik' => '3201012345670003',
                'no_sim' => 'SIM1234567890003',
                'jenis_sim' => 'SIM B2',
                'no_hp' => '081234567803',
                'alamat' => 'Jl. Kartini No. 15, Cirebon',
                'status' => 'aktif',
            ],
            [
                'nama_sopir' => 'Eko Prasetyo',
                'nik' => '3201012345670004',
                'no_sim' => 'SIM1234567890004',
                'jenis_sim' => 'SIM B2',
                'no_hp' => '081234567804',
                'alamat' => 'Jl. Diponegoro No. 30, Cirebon',
                'status' => 'aktif',
            ],
            [
                'nama_sopir' => 'Faisal Rahman',
                'nik' => '3201012345670005',
                'no_sim' => 'SIM1234567890005',
                'jenis_sim' => 'SIM B1',
                'no_hp' => '081234567805',
                'alamat' => 'Jl. Gatot Subroto No. 45, Cirebon',
                'status' => 'aktif',
            ],
            [
                'nama_sopir' => 'Hendra Gunawan',
                'nik' => '3201012345670006',
                'no_sim' => 'SIM1234567890006',
                'jenis_sim' => 'SIM B2',
                'no_hp' => '081234567806',
                'alamat' => 'Jl. Ahmad Yani No. 20, Cirebon',
                'status' => 'cuti',
            ],
            [
                'nama_sopir' => 'Indra Kusuma',
                'nik' => '3201012345670007',
                'no_sim' => 'SIM1234567890007',
                'jenis_sim' => 'SIM B2',
                'no_hp' => '081234567807',
                'alamat' => 'Jl. Veteran No. 12, Cirebon',
                'status' => 'aktif',
            ],
            [
                'nama_sopir' => 'Joko Widodo',
                'nik' => '3201012345670008',
                'no_sim' => 'SIM1234567890008',
                'jenis_sim' => 'SIM B1',
                'no_hp' => '081234567808',
                'alamat' => 'Jl. Pemuda No. 8, Cirebon',
                'status' => 'nonaktif',
            ],
            [
                'nama_sopir' => 'Kurniawan Saputra',
                'nik' => '3201012345670009',
                'no_sim' => 'SIM1234567890009',
                'jenis_sim' => 'SIM B2',
                'no_hp' => '081234567809',
                'alamat' => 'Jl. Kesambi No. 18, Cirebon',
                'status' => 'aktif',
            ],
            [
                'nama_sopir' => 'Lukman Hakim',
                'nik' => '3201012345670010',
                'no_sim' => 'SIM1234567890010',
                'jenis_sim' => 'SIM B2',
                'no_hp' => '081234567810',
                'alamat' => 'Jl. Cendana No. 22, Cirebon',
                'status' => 'aktif',
            ],
        ];

        foreach ($sopirs as $sopir) {
            Sopir::create($sopir);
        }
    }
}
