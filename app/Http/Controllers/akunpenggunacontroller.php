<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\akunusermodel;
use App\Models\identitasmodel;
use App\Models\jenispenggunamodel;
use App\Models\periodemodel;
use Illuminate\Support\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;

class akunpenggunacontroller extends Controller
{
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Akun Pengguna',
            'list' => ['Selamat Datang','Akun Pengguna']
        ];

        $page = (object)[
            'title' => 'Akun Pengguna'
        ];

        $activeMenu = 'akunpengguna';

        $identitas = identitasmodel::select('id_identitas','nama_lengkap')->get();

        $jenispengguna = jenispenggunamodel::select('id_jenis_pengguna','nama_jenis_pengguna')->get();

        $periode = periodemodel::select('id_periode','nama_periode')->get();

        return view('superadmin.akun.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'jenispengguna' => $jenispengguna , 'identitas' => $identitas, 'periode' => $periode]);
    }

    public function list(Request $request)
    {
        $akunpengguna = akunusermodel::select('id_user', 'id_identitas', 'id_jenis_pengguna', 'id_periode', 'username')
        ->with(['identitas', 'jenis_pengguna', 'periode'])
        ->get();


    // Return data untuk DataTables
    return DataTables::of($akunpengguna)
        ->addIndexColumn()
        ->addColumn('nama_lengkap', function ($akunpengguna) {
            return $akunpengguna->identitas->nama_lengkap ?? '';
        })
        ->addColumn('nama_jenis_pengguna', function ($akunpengguna) {
            return $akunpengguna->jenis_pengguna->nama_jenis_pengguna ?? '';
        })
        ->addColumn('aksi', function ($akunpengguna) {
            $btn = '<button onclick="modalAction(\'' . url('/akunpengguna/' . $akunpengguna->id_user . '/show') . '\')" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i>Detail</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/akunpengguna/' . $akunpengguna->id_user . '/edit') . '\')" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i>Edit</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/akunpengguna/' . $akunpengguna->id_user . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
            
            return $btn;
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }

    public function create(){

        $identitas = identitasmodel::select('id_identitas','nama_lengkap')->get();

        $jenispengguna = jenispenggunamodel::select('id_jenis_pengguna','nama_jenis_pengguna')->get();

        $periode = periodemodel::select('id_periode','nama_periode')->get();


        return view('superadmin.akun.create')->with(['identitas' => $identitas, 'jenispengguna' => $jenispengguna, 'periode' => $periode]);
    }

    public function store(Request $request){
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_identitas' => 'required|integer', // Validasi ID Identitas (harus ada di tabel 'identitas')
                'id_jenis_pengguna' => 'required|integer', // Validasi ID Jenis Pengguna
                'id_periode' => 'required|integer', // Validasi ID Periode
                'username' => 'required|string|min:5|max:20|unique:m_akun_user,username', // Username unik
                'password' => 'required|string|min:8|max:255',
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
            $akunpengguna = akunusermodel::create([
                'id_identitas' => $request->id_identitas,
                'id_jenis_pengguna' => $request->id_jenis_pengguna,
                'id_periode' => $request->id_periode,
                'username' => $request->username,
                'password' => bcrypt($request->password), // Hash password sebelum disimpan
            ]);

            if($akunpengguna){
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
        return redirect('/akunpengguna');
    }

    public function edit(string $id){
        $akunpengguna = akunusermodel::find($id);

        $identitas = identitasmodel::select('id_identitas','nama_lengkap')->get();

        $jenispengguna = jenispenggunamodel::select('id_jenis_pengguna','nama_jenis_pengguna')->get();

        $periode = periodemodel::select('id_periode','nama_periode')->get();

        return view('superadmin.akun.edit')->with(['akunpengguna' => $akunpengguna,'identitas' => $identitas, 'jenispengguna' => $jenispengguna, 'periode' => $periode]);
    }

    public function update(Request $request,$id){
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_identitas' => 'required|integer', // Validasi ID Identitas (harus ada di tabel 'identitas')
                'id_jenis_pengguna' => 'required|integer', // Validasi ID Jenis Pengguna
                'id_periode' => 'required|integer', // Validasi ID Periode
                'username' => 'required|string|min:5|max:20', // Username unik
                'password' => 'nullable|string|min:8|max:255',
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

            $check = akunusermodel::find($id);

            if ($check) {

                // Jika password tidak diisi, hapus dari request agar tidak di-update
                if (!$request->filled('password')) {
                    $request->request->remove('password');
                }
                
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
        return redirect('/akunpengguna');
    }


    public function delete(Request $request,$id){
        if ($request->ajax() || $request->wantsJson()) {
            $akunpengguna = akunusermodel::find($id);
            if ($akunpengguna) {
                $akunpengguna->delete();
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
        return redirect('/akunpengguna');
    }

    public function confirm(string $id){
        $akunpengguna = akunusermodel::find($id);

        $identitas = identitasmodel::select('id_identitas','nama_lengkap')->get();

        $jenispengguna = jenispenggunamodel::select('id_jenis_pengguna','nama_jenis_pengguna')->get();

        $periode = periodemodel::select('id_periode','nama_periode')->get();

        return view('superadmin.akun.delete')->with(['akunpengguna' => $akunpengguna,'identitas' => $identitas, 'jenispengguna' => $jenispengguna, 'periode' => $periode]);
    }

    public function show(string $id){
        $akunpengguna = akunusermodel::find($id);

        $identitas = identitasmodel::select('id_identitas','nama_lengkap')->get();

        $jenispengguna = jenispenggunamodel::select('id_jenis_pengguna','nama_jenis_pengguna')->get();

        $periode = periodemodel::select('id_periode','nama_periode')->get();

        return view('superadmin.akun.show')->with(['akunpengguna' => $akunpengguna,'identitas' => $identitas, 'jenispengguna' => $jenispengguna, 'periode' => $periode]);
    }
    
    public function import(){
        return view('superadmin.akun.import');
    }

    public function import_proses(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
        // validasi file harus xls atau xlsx, max 1MB
                'file_akunpengguna' => ['required', 'mimes:xlsx', 'max:1024'],
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $file = $request->file('file_akunpengguna'); // ambil file dari request
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
                            'id_identitas' => $value['A'],
                            'id_jenis_pengguna' => $value['B'],
                            'id_periode' => $value['C'],
                            'username' => $value['D'],
                            'password' => $value['E'],
                        ];
                    }
                }
                if (count($insert) > 0) {
            // insert data ke database, jika data sudah ada, maka diabaikan
                    akunusermodel::insertOrIgnore($insert);
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
        return redirect('/akunpengguna');
    }
    public function export_excel()
    {
        //ambil data yang akan di export
        $akunpengguna = akunusermodel::select('id_user', 'id_identitas', 'id_jenis_pengguna', 'id_periode','username','password')
            ->orderBy('id_user')
            ->get();

        //load library
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'ID Identitas');
        $sheet->setCellValue('C1', 'ID Jenis Pengguna');
        $sheet->setCellValue('D1', 'ID Periode');
        $sheet->setCellValue('E1', 'Username');
        $sheet->setCellValue('F1', 'Password');

        $sheet->getStyle('A1:F1')->getFont()->setBold(true); //bold header

        $no = 1;
        $baris = 2;
        foreach ($akunpengguna as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->id_identitas);
            $sheet->setCellValue('C' . $baris, $value->id_jenis_pengguna);
            $sheet->setCellValue('D' . $baris, $value->id_periode);
            $sheet->setCellValue('E' . $baris, $value->username);
            $sheet->setCellValue('F' . $baris, $value->password);
            $baris++;
            $no++;

        }

        foreach (range('A', 'F') as $columID) {
            $sheet->getColumnDimension($columID)->setAutoSize(true); //set auto size kolom
        }

        $sheet->setTitle('Data Akun Pengguna');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Identitas Pengguna ' . date('Y-m-d H:i:s') . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, dMY H:i:s') . 'GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');
        $writer->save('php://output');
        exit;

    }

    public function export_pdf(){
         //ambil data yang akan di export
         $akunpengguna = akunusermodel::select('id_user', 'id_identitas', 'id_jenis_pengguna', 'id_periode','username','password')
            ->orderBy('id_user')
            ->get();

         //use Barruvdh\DomPDF\Facade\\Pdf
        $pdf = Pdf::loadView('superadmin.akun.export', ['akunpengguna'=>$akunpengguna]);
        $pdf->setPaper('a4', 'potrait');
        $pdf->setOption("isRemoteEnabled", false);
        $pdf->render();

        return $pdf->download('Data Akun Pengguna '.date('Y-m-d H:i:s').'.pdf');
    }
}
