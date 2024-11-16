<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\identitasmodel;
use Illuminate\Support\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;

class datapenggunaSuperadminController extends Controller
{
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Data Pengguna',
            'list' => ['Selamat Datang','Data Pengguna']
        ];

        $page = (object)[
            'title' => 'Data Pengguna'
        ];

        $activeMenu = 'datapengguna';

        return view('superadmin.data.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $identitas= identitasmodel::select('id_identitas','nama_lengkap','NIP','jenis_kelamin','alamat','no_telp');

        // Return data untuk DataTables
        return DataTables::of($identitas)
            ->addIndexColumn() // menambahkan kolom index / nomor urut
            ->addColumn('aksi', function ($identitas) {
                $btn = '<button onclick="modalAction(\'' . url('/jenis/' . $identitas->id_identitas . '/edit_ajax') . '\')" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i>Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/jenis/' . $identitas->id_identitas . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
            
                return $btn;
            })
            

            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi berisi HTML
            ->make(true);
    }

    public function create(){
        return view('superadmin.data.create');
    }

    public function store(Request $request){
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_lengkap' => 'required|string|min:10|max:100',
                'NIP' => 'required|string|min:10|max:20',
                'tempat_lahir' => 'required|string|min:5|max:10',
                'tanggal_lahir' => 'required|date|before:today',
                'jenis_kelamin' => 'required|string|in:laki,perempuan',
                'alamat' => 'required|string|min:10|max:100',
                'no_telp' => 'required|string|min:10|max:15',
                'email' => 'required|string|min:10|max:50',
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
            identitasmodel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data Jenis berhasil disimpan'
            ]);
        }
        return redirect('/datapengguna');
    }
}
