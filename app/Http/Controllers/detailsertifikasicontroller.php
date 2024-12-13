<?php

namespace App\Http\Controllers;

use App\Models\bidangminatmodel;
use Illuminate\Http\Request;
use App\Models\detailsertifikasi;
use App\Models\matakuliahmodel;
use App\Models\periodemodel;
use App\Models\sertifikasimodel;
use App\Models\tagbdsertifikasimodel;
use App\Models\tagmksertifikasimodel;
use Illuminate\Support\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\support\Facades\Auth;
use PhpOffice\PhpWord\PhpWord;


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

        $periode = periodemodel::select('id_periode','nama_periode')->get();

        return view('admin.pelatihansertifikasi.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'periode' => $periode]);
    }

    public function list(Request $request)
    {
        $detailsertifikasi = detailsertifikasi::select(
                            'id_detail_sertifikasi',
                            'id_sertifikasi',
                            'id_periode',
                            'tanggal_mulai',
                            'tanggal_selesai',
                            'lokasi',
                            'biaya',
                            'status_disetujui',
                        )
        ->with(['sertifikasi', 'periode'])
        ->get();

        if ($request->id_periode) {
            $detailsertifikasi->where('id_periode', $request->id_periode);
        }


    // Return data untuk DataTables
    return DataTables::of($detailsertifikasi)
        ->addIndexColumn()
        ->addColumn('nama_sertifikasi', function ($detailsertifikasi) {
            return $detailsertifikasi->sertifikasi->nama_sertifikasi ?? '';
        })
        ->addColumn('nama_periode', function ($detailsertifikasi) {
            return $detailsertifikasi->periode->nama_periode ?? '';
        })
        ->addColumn('biaya_format', function ($detailsertifikasi) {
            return 'Rp' . number_format($detailsertifikasi->biaya, 0, ',', '.') ?? ' ';
        })
        ->addColumn('aksi', function ($detailsertifikasi) {
            $btn = '<button onclick="modalAction(\'' . url('/detailsertifikasi/' . $detailsertifikasi->id_detail_sertifikasi . '/surattugas') . '\')" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i>Surat Tugas</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/detailsertifikasi/' . $detailsertifikasi->id_detail_sertifikasi . '/show') . '\')" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i>Detail</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/detailsertifikasi/' . $detailsertifikasi->id_detail_sertifikasi . '/edit') . '\')" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i>Edit</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/detailsertifikasi/' . $detailsertifikasi->id_detail_sertifikasi . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
            
            return $btn;
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }

    public function create (){

        $sertifikasi = sertifikasimodel::select('id_sertifikasi','nama_sertifikasi')->get(); 

        $periode = periodemodel::select('id_periode','nama_periode')->get();

        $mk = matakuliahmodel::select('id_mk','nama_mk')->get();

        $bd = bidangminatmodel::select('id_bd','nama_bd')->get();
        
        return view('admin.pelatihansertifikasi.create', ['sertifikasi' => $sertifikasi, 'periode' => $periode, 'mk' => $mk, 'bd' => $bd]);
        
    }

    public function store(Request $request) {

        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'sertifikasi' => 'required|integer', // Validasi ID Identitas (harus ada di tabel 'identitas')
                'biaya' => 'required|integer', // Validasi ID Jenis Pengguna
                'lokasi' => 'required|max:50', // Validasi ID Periode
                'jumlah_peserta' => 'required|integer', // Validasi ID Periode
                'periode' => 'required|integer', // Validasi ID Periode
                'tanggal_mulai' => 'required|date', // Validasi ID Periode
                'tanggal_selesai' => 'required|date', // Validasi ID Periode
                'mata_kuliah' => 'required|integer', // Validasi ID Periode
                'bidang_minat' => 'required|integer', // Validasi ID Periode
            ]; 
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors() // pesan error validasi
                ]);
            }

            $detailsertifikasi = detailsertifikasi::create([
                'id_sertifikasi' => $request->sertifikasi,
                'id_periode' => $request->periode,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'lokasi' => $request->lokasi,
                'quota_peserta' => $request->jumlah_peserta,
                'biaya' => $request->biaya,
            ]);

            if($detailsertifikasi){
                return response()->json([
                    'status'    => true,
                    'message'   => 'Data user berhasil disimpan'
                ], 200);
            }


            return response()->json([
                'status' => true,
                'message' => 'Data Jenis berhasil disimpan'
            ]);
        }
        return redirect('/detailsertifikasi');
    }
}
