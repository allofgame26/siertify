<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class jenispelatihansertifikasiseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_jenis_setifikasi' => 'Data Science',
                'deskripsi_pendek' => 'Pelatihan yang fokus pada analisis data dan pembelajaran mesin.',
                'created_at' => now(),
            ],
            [
                'nama_jenis_setifikasi' => 'Data Mining',
                'deskripsi_pendek' => 'Pelatihan yang mengajarkan teknik untuk mengeksplorasi dan menganalisis data besar.',
                'created_at' => now(),
            ],
            [
                'nama_jenis_setifikasi' => 'Machine Learning',
                'deskripsi_pendek' => 'Pelatihan tentang algoritma dan teknik untuk membangun model pembelajaran otomatis.',
                'created_at' => now(),
            ],
            [
                'nama_jenis_setifikasi' => 'Big Data',
                'deskripsi_pendek' => 'Pelatihan mengenai pengelolaan dan analisis data dalam skala besar.',
                'created_at' => now(),
            ],
            [
                'nama_jenis_setifikasi' => 'Artificial Intelligence',
                'deskripsi_pendek' => 'Pelatihan tentang pengembangan sistem yang dapat meniru kecerdasan manusia.',
                'created_at' => now(),
            ],
        ];
        DB::table('m_jenis_pelatihan_sertifikasi')->insert($data);
    }
}
