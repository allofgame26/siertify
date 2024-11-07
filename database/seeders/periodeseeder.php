<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class periodeseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama_periode' => '2024/2025',
            'tanggal_mulai' => '2024-01-01',
            'tanggal_selesai' => '2025-01-01',
            'tahun_periode' => 'Ganjil',
            'deskripsi_periode' => 'Periode 2024/2025 Tahun ganjil',
            'created_at' => now()
            ],[
            'nama_periode' => '2025/2026',
            'tanggal_mulai' => '2025-01-01',
            'tanggal_selesai' => '2026-01-01',
            'tahun_periode' => 'Genap',
            'deskripsi_periode' => 'Periode 2025/2026 Tahun genap',
            'created_at' => now()
            ]
        ];
        DB::table('m_periode')->insert($data);
    }
}
