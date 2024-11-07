<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class jenispenggunaseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kode_jenis_pengguna' => 'ADM',
                'nama_jenis_pengguna' => 'Admin',
                'created_at' => now()
            ],[
                'kode_jenis_pengguna' => 'SDM',
                'nama_jenis_pengguna' => 'Super Admin',
                'created_at' => now()
            ],[
                'kode_jenis_pengguna' => 'DSN',
                'nama_jenis_pengguna' => 'Dosen',
                'created_at' => now()
            ],[
                'kode_jenis_pengguna' => 'PMP',
                'nama_jenis_pengguna' => 'Pemimpin',
                'created_at' => now()
            ]
        ];
        DB::table('m_jenis_pengguna')->insert($data);
    }
}
