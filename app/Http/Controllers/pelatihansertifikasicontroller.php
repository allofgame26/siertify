<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\DB;
use Illuminate\Support\Facades\Validator;

class pelatihansertifikasicontroller extends Controller
{
    public function index(){
        $activeMenu = 'pelatihansertifikasi';
        $breadcrumb = (object) [
            'title' => 'Data Pelatihan & Sertifikasi',
            'list' => ['Home', 'Pelatihan & Sertifikasi']
        ];
        $page = (object) [
            'title' => 'Daftar Pelatihan & Sertifikasi yang sudah diinputnkan'
        ];
        // $penjualan = PenjualanModel::all();
        // $barang = BarangModel::all();
        // $user = UserModel::all();
        return view('penjualan.index', [
            'activeMenu' => $activeMenu,
            'breadcrumb' => $breadcrumb,
            // 'penjualan' => $penjualan,
            // 'barang' => $barang,
            // 'user' => $user,
            'page' => $page
        ]);
    }
}
