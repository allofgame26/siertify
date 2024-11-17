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
                $btn = '<button onclick="modalAction(\'' . url('/datapengguna/' . $identitas->id_identitas . '/edit') . '\')" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i>Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/datapengguna/' . $identitas->id_identitas . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
            
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
                'tanggal_lahir' => 'required|date',
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
            $datapengguna = identitasmodel::create([
                'nama_lengkap' => $request->nama_lengkap,
                'NIP' => $request->NIP,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'no_telp' => $request->no_telp,
                'email' => $request->email
            ]);

            if($datapengguna){
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
        return redirect('/datapengguna');
    }

    public function edit(string $id){
        $datapengguna = identitasmodel::find($id);
        return view('superadmin.data.edit', ['datapengguna' => $datapengguna]);
    }

    public function update(Request $request,$id){
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
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }
            $check = identitasmodel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/datapengguna');
    }
    public function delete(Request $request,$id){
        if ($request->ajax() || $request->wantsJson()) {
            $datapengguna = identitasmodel::find($id);
            if ($datapengguna) {
                $datapengguna->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/datapengguna');
    }

    public function confirm(string $id){
        $datapengguna = identitasmodel::find($id);
        return view('superadmin.data.delete', ['datapengguna' => $datapengguna]);
    }
}
