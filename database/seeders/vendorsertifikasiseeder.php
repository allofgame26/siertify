<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class vendorsertifikasiseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data =[
            [
                'nama_vendor_sertifikasi' => 'PT. Sertifikasi Utama',
                'alamat_vendor_sertifikasi' => 'Jl. Sertifikasi No. 1, Jakarta',
                'kota_vendor_sertifikasi' => 'Jakarta',
                'notelp_vendor_sertifikasi' => '021-12345678',
                'web_vendor_sertifikasi' => 'www.sertifikasiutama.com',
                'created_at' => now(),
            ],
            [
                'nama_vendor_sertifikasi' => 'CV. Edukasi Bersertifikat',
                'alamat_vendor_sertifikasi' => 'Jl. Edukasi No. 10, Bandung',
                'kota_vendor_sertifikasi' => 'Bandung',
                'notelp_vendor_sertifikasi' => '022-87654321',
                'web_vendor_sertifikasi' => 'www.edukasibersertifikat.com',
                'created_at' => now(),
            ],
            [
                'nama_vendor_sertifikasi' => 'Lembaga Sertifikasi Profesional',
                'alamat_vendor_sertifikasi' => 'Jl. Profesional No. 5, Yogyakarta',
                'kota_vendor_sertifikasi' => 'Yogyakarta',
                'notelp_vendor_sertifikasi' => '0274-1234567',
                'web_vendor_sertifikasi' => 'www.sertifikasiprofesional.org',
                'created_at' => now(),
            ],
            [
                'nama_vendor_sertifikasi' => 'Institut Sertifikasi Digital',
                'alamat_vendor_sertifikasi' => 'Jl. Digital No. 15, Surabaya',
                'kota_vendor_sertifikasi' => 'Surabaya',
                'notelp_vendor_sertifikasi' => '031-7654321',
                'web_vendor_sertifikasi' => 'www.sertifikasidigital.com',
                'created_at' => now(),
            ],
            [
                'nama_vendor_sertifikasi' => 'Yayasan Sertifikasi Mandiri',
                'alamat_vendor_sertifikasi' => 'Jl. Mandiri No. 20, Denpasar',
                'kota_vendor_sertifikasi' => 'Bali',
                'notelp_vendor_sertifikasi' => '0361-9876543',
                'web_vendor_sertifikasi' => 'www.sertifikasimandiri.id',
                'created_at' => now(),
            ],
        ];
        DB::table('m_vendor_sertifikasi')->insert($data);
    }
}
