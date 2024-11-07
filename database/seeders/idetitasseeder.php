<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class idetitasseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_lengkap' => 'Rizki Arya Prayoga',
                'NIP' => '211762051',
                'tempat_lahir' => 'Malang',
                'tanggal_lahir' => '2003-01-01',
                'jenis_kelamin' => 'laki',
                'alamat' => 'Jl. Candi Telaga Wangi No. 81',
                'no_telp' => '081515430129',
                'email' => 'rizkiarya79@yahoo.com',
                'foto_profil' => null,
                'created_at' => now()
            ]
        ];
        DB::table('m_identitas_diri')->insert($data);
    }
}
