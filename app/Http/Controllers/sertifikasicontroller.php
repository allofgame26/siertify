<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sertifikasimodel;
use App\Models\vendorsertifikasimodel;
use App\Models\jenispelatihansertifikasimodel;
use Illuminate\Support\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;

class sertifikasicontroller extends Controller
{
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Sertifikasi',
            'list' => ['Selamat Datang','Sertifikasi']
        ];

        $page = (object)[
            'title' => 'Data Sertifikasi'
        ];

        $activeMenu = 'sertifikasi';

        $vendor = vendorsertifikasimodel::select('id_vendor_sertifikasi','nama_vendor_sertifikasi')->get();

        $jenis = jenispelatihansertifikasimodel::select('id_jenis_pelatihan_sertifikasi','nama_jenis_sertifikasi')->get();

        $sertifikasi = sertifikasimodel::select('id_sertifikasi','nama_sertifikasi','id_jenis_pelatihan_sertifikasi','id_vendor_sertifikasi','level_sertifikasi')->get();

        return view('admin.mastersertifikasi.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'vendor' => $vendor, 'jenis' => $jenis, 'sertifikasi' => $sertifikasi]);
    }

    public function list(Request $request)
    {
        $sertifikasi= sertifikasimodel::select('id_sertifikasi','nama_sertifikasi','id_vendor_sertifikasi','id_jenis_pelatihan_sertifikasi','level_sertifikasi')
        ->with(['vendorsertifikasi','jenissertifikasi'])
        ->get();

        // Return data untuk DataTables
        return DataTables::of($sertifikasi)
            ->addIndexColumn() // menambahkan kolom index / nomor urut
            ->addColumn('nama_jenis_sertifikasi', function ($sertifikasi) {
                return $sertifikasi->jenissertifikasi->nama_jenis_sertifikasi ?? 'Error';
            })
            ->addColumn('nama_vendor_sertifikasi', function ($sertifikasi) {
                return $sertifikasi->vendorsertifikasi->nama_vendor_sertifikasi ?? 'Error';
            })
            ->addColumn('aksi', function ($sertifikasi) {
                $btn = '<button onclick="modalAction(\'' . url('/sertifikasi/' . $sertifikasi->id_sertifikasi . '/show') . '\')" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i>Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/sertifikasi/' . $sertifikasi->id_sertifikasi . '/edit') . '\')" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i>Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/sertifikasi/' . $sertifikasi->id_sertifikasi . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            

            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi berisi HTML
            ->make(true);
    }

    public function show(string $id){

        $sertifikasi= sertifikasimodel::select('id_sertifikasi','nama_sertifikasi','id_vendor_sertifikasi','id_jenis_pelatihan_sertifikasi','level_sertifikasi')
        ->with(['vendorsertifikasi','jenissertifikasi'])
        ->find($id);

        return view('admin.mastersertifikasi.show')->with(['sertifikasi' => $sertifikasi]);
    }

    public function create(){

        $sertifikasi= sertifikasimodel::select('id_sertifikasi','nama_sertifikasi','id_vendor_sertifikasi','id_jenis_pelatihan_sertifikasi','level_sertifikasi')->get();

        $vendor = vendorsertifikasimodel::select('id_vendor_sertifikasi','nama_vendor_sertifikasi')->get();

        $jenis = jenispelatihansertifikasimodel::select('id_jenis_pelatihan_sertifikasi','nama_jenis_sertifikasi')->get();

        return view('admin.mastersertifikasi.create')->with(['sertifikasi' => $sertifikasi, 'vendor' => $vendor, 'jenis' => $jenis]);
    }


}
