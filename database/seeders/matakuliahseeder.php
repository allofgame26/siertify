<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class matakuliahseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_mk' => 'Machine Learning',
                'kode_mk' => 'ML101',
                'deskripsi_mk' => 'Pengenalan konsep machine learning dan penerapannya.',
                'created_at' => now()
            ],
            [
                'nama_mk' => 'Data Mining',
                'kode_mk' => 'DM102',
                'deskripsi_mk' => 'Teknik dan algoritma untuk mengekstraksi informasi dari data.',
                'created_at' => now()
            ],
            [
                'nama_mk' => 'Computer Vision',
                'kode_mk' => 'CV201',
                'deskripsi_mk' => 'Dasar-dasar computer vision dan aplikasi dalam kehidupan nyata.',
                'created_at' => now()
            ],
            [
                'nama_mk' => 'Network Security',
                'kode_mk' => 'NS202',
                'deskripsi_mk' => 'Konsep keamanan jaringan dan kriptografi.',
                'created_at' => now()
            ],
            [
                'nama_mk' => 'IoT Systems',
                'kode_mk' => 'IOT303',
                'deskripsi_mk' => 'Pengenalan teknologi IoT dan penerapannya.',
                'created_at' => now()
            ],
            [
                'nama_mk' => 'Software Engineering',
                'kode_mk' => 'SE101',
                'deskripsi_mk' => 'Prinsip-prinsip pengembangan perangkat lunak.',
                'created_at' => now()
            ],
            [
                'nama_mk' => 'Robotics and Automation',
                'kode_mk' => 'RA305',
                'deskripsi_mk' => 'Dasar-dasar robotika dan otomatisasi.',
                'created_at' => now()
            ],
        ];
        DB::table('m_mata_kuliah')->insert($data);
    }
}
