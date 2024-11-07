<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class vendorpelatihanseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data =[
            [
                'nama_vendor_pelatihan' => 'PT. Edukasi Mandiri',
                'alamat_vendor_pelatihan' => 'Jl. Pendidikan No. 10, Jakarta',
                'kota_vendor_pelatihan' => 'Jakarta',
                'notelp_vendor_pelatihan' => '021-12345678',
                'web_vendor_pelatihan' => 'www.edukasimandiri.com',
                'created_at' => now(),
            ],
            [
                'nama_vendor_pelatihan' => 'CV. Teknologi Canggih',
                'alamat_vendor_pelatihan' => 'Jl. Teknologi No. 5, Bandung',
                'kota_vendor_pelatihan' => 'Bandung',
                'notelp_vendor_pelatihan' => '022-87654321',
                'web_vendor_pelatihan' => 'www.teknologicanggih.com',
                'created_at' => now(),
            ],
            [
                'nama_vendor_pelatihan' => 'Yayasan Pelatihan Kreatif',
                'alamat_vendor_pelatihan' => 'Jl. Kreatif No. 20, Yogyakarta',
                'kota_vendor_pelatihan' => 'Yogyakarta',
                'notelp_vendor_pelatihan' => '0274-1234567',
                'web_vendor_pelatihan' => 'www.pelatihankreatif.org',
                'created_at' => now(),
            ],
            [
                'nama_vendor_pelatihan' => 'Lembaga Pelatihan Profesional',
                'alamat_vendor_pelatihan' => 'Jl. Profesional No. 15, Surabaya',
                'kota_vendor_pelatihan' => 'Surabaya',
                'notelp_vendor_pelatihan' => '031-7654321',
                'web_vendor_pelatihan' => 'www.pelatihanprofesional.com',
                'created_at' => now(),
            ],
            [
                'nama_vendor_pelatihan' => 'Institut Pelatihan Digital',
                'alamat_vendor_pelatihan' => 'Jl. Digital No. 30, Bali',
                'kota_vendor_pelatihan' => 'Denpasar',
                'notelp_vendor_pelatihan' => '0361-9876543',
                'web_vendor_pelatihan' => 'www.pelatihandigital.id',
                'created_at' => now(),
            ],
        ];
        DB::table('m_vendor_pelatihan')->insert($data);
    }
}
