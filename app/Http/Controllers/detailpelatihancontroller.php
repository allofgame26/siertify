<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\detailpelatihan;
use App\Models\akunusermodel;
use Illuminate\Support\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;

class detailpelatihancontroller extends Controller
{
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Detail Pelatihan',
            'list' => ['Selamat Datang','Detail Pelatihan']
        ];

        $page = (object)[
            'title' => 'Detail Pelatihan'
        ];

        $activeMenu = 'detailsertifikasi';

        $user = akunusermodel::select('id_user','username')->get();

        return view('admin.pelatihansertifikasi.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'user' => $user]);
    }

    public function list(Request $request)
    {
        $detailpelatihan = detailpelatihan::select(
                            'id_detail_pelatihan',
                            'id_pelatihan',
                            'id_periode',
                            'tanggal_mulai',
                            'tanggal_selesai',
                            'lokasi',
                            'biaya',
                            'status_disetujui',
                        )
        ->with(['pelatihan', 'periode'])
        ->get();

        if ($request->id_periode) {
            $detailpelatihan->where('id_periode', $request->id_periode);
        }


    // Return data untuk DataTables
    return DataTables::of($detailpelatihan)
        ->addIndexColumn()
        ->addColumn('nama_pelatihan', function ($detailpelatihan) {
            return $detailpelatihan->pelatihan->nama_pelatihan ?? '';
        })
        ->addColumn('nama_periode', function ($detailpelatihan) {
            return $detailpelatihan->periode->nama_periode ?? '';
        })
        ->addColumn('biaya_format', function ($detailpelatihan) {
            return 'Rp' . number_format($detailpelatihan->biaya, 0, ',', '.') ?? ' ';
        })
        ->addColumn('aksi', function ($detailpelatihan) {
            $btn = '<button onclick="modalAction(\'' . url('/detailpelatihan/' . $detailpelatihan->id_detail_sertifikasi . '/show') . '\')" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i>Detail</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/detailpelatihan/' . $detailpelatihan->id_detail_sertifikasi . '/edit') . '\')" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i>Edit</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/detailpelatihan/' . $detailpelatihan->id_detail_sertifikasi . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
            
            return $btn;
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }
}
