<?php

namespace App\Http\Controllers;

use App\Models\notifikasimodel;
use App\Models\akunusermodel;
use App\Models\bidangminatmodel;
use App\Models\detailpelatihan;
use App\Models\detailsertifikasi;
use App\Models\identitasmodel;
use App\Models\matakuliahmodel;
use App\Models\pelatihanmodel;
use App\Models\periodemodel;
use App\Models\sertifikasimodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class NotifikasiController extends Controller
{

    public function index(){

        $breadcrumb = (object)[
            'title' => 'Notifikasi',
            'list' => ['Welcome','Notifikasi']
        ];

        $page = (object)[
            'title' => 'Notifikasi '
        ];

        $activeMenu = 'notifikasi';

        $periode = periodemodel::all();

        $id_user = Auth::id();

        return view('notifikasi.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'periode' => $periode, 'id_user' => $id_user]);
    }

    public function list(Request $request, string $id)
    {
        $id_user = Auth::id();

        $id_periode = $request->input('id_periode');
    
        $query = notifikasimodel::where('id_user', $id_user);
    
        if ($id_periode) {
            $query->where('id_periode', $id_periode);
        }
    
        $data = $query->get();
    
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('created_at', function ($notifikasi) {
                return $notifikasi->created_at; // Kirim data waktu mentah
            })
            ->addColumn('aksi', function ($notifikasi) {
                // Cek apakah id_detail_pelatihan null atau tidak
                $url = $notifikasi->id_detail_pelatihan ? 
                    url('/notifikasi/pelatihan/' . $notifikasi->id_detail_pelatihan . '/detail') : 
                    url('/notifikasi/sertifikasi/' .$notifikasi->id_detail_sertifikasi. '/detail');
        
                $btn = '<button onclick="modalAction(\'' . $url . '\')" class="btn btn-info btn-sm">Detail</button>';
        
                return $btn;
            })
            ->rawColumns(['created_at', 'aksi'])
            ->make(true);
    }

    public function detailPelatihan(string $id)
    {
        // Ambil data pelatihan
        $pelatihan = pelatihanmodel::join(
            'm_jenis_pelatihan_sertifikasi as jenis',
            'm_pelatihan.id_jenis_pelatihan_sertifikasi', '=', 'jenis.id_jenis_pelatihan_sertifikasi'
        )
            ->join(
                'm_vendor_pelatihan as vendor',
                'm_pelatihan.id_vendor_pelatihan', '=', 'vendor.id_vendor_pelatihan'
            )
            ->join(
                't_detailpelatihan as detail',
                'm_pelatihan.id_pelatihan', '=', 'detail.id_pelatihan'
            )
            ->join(
                'm_periode as periode',
                'detail.id_periode', '=', 'periode.id_periode'
            )
            ->select(
                'm_pelatihan.id_pelatihan',
                'm_pelatihan.nama_pelatihan',
                'jenis.nama_jenis_sertifikasi',
                'vendor.nama_vendor_pelatihan',
                'm_pelatihan.level_pelatihan',
                'periode.nama_periode',
                'detail.*'
            )
            ->where('detail.id_detail_pelatihan', '=', $id)
            ->distinct()
            ->first();

        // Ambil mata kuliah terkait
        $mataKuliah = DB::table('t_tagging_mk_pelatihan as tagmk')
            ->join('m_mata_kuliah as mk', 'tagmk.id_mk', '=', 'mk.id_mk')
            ->where('tagmk.id_pelatihan', '=', $pelatihan->id_pelatihan)
            ->get();

        $mataKuliah = $mataKuliah->pluck('nama_mk')->toArray();

        // Ambil mata kuliah terkait
        $bidangMinat = DB::table('t_tagging_bd_pelatihan as tagbd')
            ->join('m_bidang_minat as bd', 'tagbd.id_bd', '=', 'bd.id_bd')
            ->where('tagbd.id_pelatihan', '=', $pelatihan->id_pelatihan)
            ->pluck('bd.nama_bd')
            ->toArray();

        return view('notifikasi.showPelatihan', compact('mataKuliah', 'bidangMinat', 'pelatihan'));
    }

    public function detailSertifikasi(string $id)
    {
        // Ambil data sertifikasi
        $sertifikasi = sertifikasimodel::join(
            'm_jenis_pelatihan_sertifikasi as jenis',
            'm_sertifikasi.id_jenis_pelatihan_sertifikasi', '=', 'jenis.id_jenis_pelatihan_sertifikasi'
        )
            ->join(
                'm_vendor_sertifikasi as vendor',
                'm_sertifikasi.id_vendor_sertifikasi', '=', 'vendor.id_vendor_sertifikasi'
            )
            ->join(
                't_detailsertifikasi as detail',
                'm_sertifikasi.id_sertifikasi', '=', 'detail.id_sertifikasi'
            )
            ->join(
                'm_periode as periode',
                'detail.id_periode', '=', 'periode.id_periode'
            )
            ->select(
                'm_sertifikasi.id_sertifikasi',
                'm_sertifikasi.nama_sertifikasi',
                'jenis.nama_jenis_sertifikasi',
                'vendor.nama_vendor_sertifikasi',
                'm_sertifikasi.level_sertifikasi',
                'periode.nama_periode',
                'detail.*'
            )
            ->where('detail.id_detail_sertifikasi', '=', $id)
            ->distinct()
            ->first();

        // Ambil mata kuliah terkait
        $mataKuliah = DB::table('t_tagging_mk_sertifikasi as tagmk')
            ->join('m_mata_kuliah as mk', 'tagmk.id_mk', '=', 'mk.id_mk')
            ->where('tagmk.id_sertifikasi', '=', $sertifikasi->id_sertifikasi)
            ->get();

        $mataKuliah = $mataKuliah->pluck('nama_mk')->toArray();

        // Ambil mata kuliah terkait
        $bidangMinat = DB::table('t_tagging_bd_sertifikasi as tagbd')
            ->join('m_bidang_minat as bd', 'tagbd.id_bd', '=', 'bd.id_bd')
            ->where('tagbd.id_sertifikasi', '=', $sertifikasi->id_sertifikasi)
            ->pluck('bd.nama_bd')
            ->toArray();

        return view('notifikasi.showSertifikasi', compact('mataKuliah', 'bidangMinat', 'sertifikasi'));
    }
    
}
