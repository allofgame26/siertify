<?php

namespace App\Http\Controllers;

use App\Models\akunusermodel;
use Illuminate\Http\Request;
use App\Models\detailsertifikasi;
use Illuminate\Support\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;


class detailsertifikasicontroller extends Controller
{
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Detail Sertifikasi',
            'list' => ['Selamat Datang','Detail Sertifikasi']
        ];

        $page = (object)[
            'title' => 'Detail Sertifikasi'
        ];

        $activeMenu = 'detailsertifikasi';

        $user = akunusermodel::select('id_user','username')->get();

        return view('admin.pelatihansertifikasi.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'user' => $user]);
    }

    public function list(Request $request)
    {
        $detailsertifikasi = detailsertifikasi::select(
                            'id_sertifikasi',
                            'id_periode',
                            'id_user',
                            'tanggal_mulai',
                            'tanggal_selesai',
                            'lokasi',
                            'quota_peserta',
                            'biaya',
                            'status_disetujui',
                            'input_by'
                        )
        ->with(['sertifikasi', 'periode', 'user'])
        ->get();

        if ($request->id_user) {
            $detailsertifikasi->where('id_user', $request->id_user);
        }


    // Return data untuk DataTables
    return DataTables::of($detailsertifikasi)
        ->addIndexColumn()
        ->addColumn('nama_sertifikasi', function ($detailsertifikasi) {
            return $detailsertifikasi->sertifikasi->nama_sertifikasi ?? '';
        })
        ->addColumn('aksi', function ($detailsertifikasi) {
            $btn = '<button onclick="modalAction(\'' . url('/detailsertifikasi/' . $detailsertifikasi->id_detail_sertifikasi . '/show') . '\')" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i>Detail</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/detailsertifikasi/' . $detailsertifikasi->id_detail_sertifikasi . '/edit') . '\')" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i>Edit</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/detailsertifikasi/' . $detailsertifikasi->id_detail_sertifikasi . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
            
            return $btn;
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }
}
