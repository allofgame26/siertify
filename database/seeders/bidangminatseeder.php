<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class bidangminatseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_bd' => 'Artificial Intelligence',
                'kode_bd' => 'AI',
                'deskripsi_bd' => 'Penelitian terkait kecerdasan buatan dan machine learning.',
                'created_at' => now(),
            ],
            [
                'nama_bd' => 'Data Science',
                'kode_bd' => 'DS',
                'deskripsi_bd' => 'Penelitian terkait pengolahan data, big data, dan statistik.',
                'created_at' => now(),
            ],
            [
                'nama_bd' => 'Computer Vision',
                'kode_bd' => 'CV',
                'deskripsi_bd' => 'Penelitian terkait pengenalan pola, image processing, dan visual computing.',
                'created_at' => now(),
            ],
            [
                'nama_bd' => 'Cyber Security',
                'kode_bd' => 'CS',
                'deskripsi_bd' => 'Penelitian terkait keamanan jaringan dan kriptografi.',
                'created_at' => now(),
            ],
            [
                'nama_bd' => 'Internet of Things (IoT)',
                'kode_bd' => 'IOT',
                'deskripsi_bd' => 'Penelitian terkait perangkat IoT dan sensor.',
                'created_at' => now(),
            ],
            [
                'nama_bd' => 'Software Engineering',
                'kode_bd' => 'SE',
                'deskripsi_bd' => 'Pengembangan dan pemeliharaan perangkat lunak.',
                'created_at' => now(),
            ],
            [
                'nama_bd' => 'Robotics',
                'kode_bd' => 'ROB',
                'deskripsi_bd' => 'Penelitian dan pengembangan teknologi robotik.',
                'created_at' => now(),
            ],
        ];
        DB::table('m_bidang_minat')->insert($data);
    }
}
