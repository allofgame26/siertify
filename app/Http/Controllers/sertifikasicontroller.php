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

    public function store(Request $request){
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_sertifikasi' => 'required|max:40', // Validasi ID Identitas (harus ada di tabel 'identitas')
                'id_jenis_pelatihan_sertifikasi' => 'required|integer', // Validasi ID Jenis Pengguna
                'id_vendor_sertifikasi' => 'required|integer', // Validasi ID Periode
                'level_sertifikasi' => 'required', // Username unik
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
            $sertifikasi = sertifikasimodel::create([
                'nama_sertifikasi' => $request->nama_sertifikasi,
                'id_vendor_sertifikasi' => $request->id_vendor_sertifikasi,
                'id_jenis_pelatihan_sertifikasi' => $request->id_jenis_pelatihan_sertifikasi,
                'level_sertifikasi' => $request->level_sertifikasi,
            ]);

            if($sertifikasi){
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
        return redirect('/sertifikasi');
    }

    public function edit(string $id){

        $sertifikasi = sertifikasimodel::select('id_sertifikasi','nama_sertifikasi','id_vendor_sertifikasi','id_jenis_pelatihan_sertifikasi','level_sertifikasi')->find($id);

        $vendor = vendorsertifikasimodel::select('id_vendor_sertifikasi','nama_vendor_sertifikasi')->get();

        $jenis = jenispelatihansertifikasimodel::select('id_jenis_pelatihan_sertifikasi','nama_jenis_sertifikasi')->get();

        return view('admin.mastersertifikasi.edit')->with(['sertifikasi' => $sertifikasi, 'vendor' => $vendor, 'jenis' => $jenis]);
    }
    
    public function update(Request $request,$id){
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_sertifikasi' => 'required|max:40', // Validasi ID Identitas (harus ada di tabel 'identitas')
                'id_jenis_pelatihan_sertifikasi' => 'required|integer', // Validasi ID Jenis Pengguna
                'id_vendor_sertifikasi' => 'required|integer', // Validasi ID Periode
                'level_sertifikasi' => 'required', // Username unik
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

            $check = sertifikasimodel::find($id);

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
        return redirect('/sertifikasi');
    }

    public function delete(Request $request,$id){
        if ($request->ajax() || $request->wantsJson()) {
            $sertifikasi = sertifikasimodel::find($id);
            if ($sertifikasi) {
                $sertifikasi->delete();
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
        return redirect('/sertifikasi');
    }
    
    public function confirm(string $id){

        $sertifikasi = sertifikasimodel::select('id_sertifikasi','nama_sertifikasi','id_vendor_sertifikasi','id_jenis_pelatihan_sertifikasi','level_sertifikasi')->find($id);

        $vendor = vendorsertifikasimodel::select('id_vendor_sertifikasi','nama_vendor_sertifikasi')->get();

        $jenis = jenispelatihansertifikasimodel::select('id_jenis_pelatihan_sertifikasi','nama_jenis_sertifikasi')->get();

        return view('admin.mastersertifikasi.delete')->with(['sertifikasi' => $sertifikasi, 'vendor' => $vendor, 'jenis' => $jenis]);
    }

    public function import(){
        return view('admin.mastersertifikasi.import');
    }

    public function import_proses(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
        // validasi file harus xls atau xlsx, max 1MB
                'file_mastersertifikasi' => ['required', 'mimes:xlsx', 'max:1024'],
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $file = $request->file('file_mastersertifikasi'); // ambil file dari request
            $reader = IOFactory::createReader('Xlsx'); // load reader file excel
            $reader->setReadDataOnly(true); // hanya membaca data
            $spreadsheet = $reader->load($file->getRealPath()); // load file excel
            $sheet = $spreadsheet->getActiveSheet(); // ambil sheet yang aktif
            $data = $sheet->toArray(null, false, true, true); // ambil data excel
            $insert = [];
            if (count($data) > 1) { // jika data lebih dari 1 baris
                foreach ($data as $baris => $value) {
                    if ($baris > 1) { // baris ke 1 adalah header, maka lewati
                        $insert[] = [
                            'id_sertifikasi' => $value['A'],
                            'id_vendor_sertifikasi' => $value['B'],
                            'id_jenis_pelatihan_sertifikasi' => $value['C'],
                            'level_sertifikasi' => $value['D'],
                        ];
                    }
                }
                if (count($insert) > 0) {
            // insert data ke database, jika data sudah ada, maka diabaikan
                    sertifikasimodel::insertOrIgnore($insert);
                }
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diimport',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data yang diimport',
                ]);
            }
        }
        return redirect('/sertifikasi');
    }



}
