<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\jenispenggunamodel;
use Illuminate\Support\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;

class JenispenggunaSuperadminController extends Controller
{
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Jenis Pengguna',
            'list' => ['Selamat Datang','Jenis Pengguna']
        ];

        $page = (object)[
            'title' => 'Jenis Pengguna'
        ];

        $activeMenu = 'jenispengguna';

        return view('superadmin.jenis.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $jenispengguna= jenispenggunamodel::select('id_jenis_pengguna','nama_jenis_pengguna','kode_jenis_pengguna');

        // Return data untuk DataTables
        return DataTables::of($jenispengguna)
            ->addIndexColumn() // menambahkan kolom index / nomor urut
            ->addColumn('aksi', function ($jenispengguna) {
                $btn = '<button onclick="modalAction(\'' . url('/jenispengguna/' . $jenispengguna->id_jenis_pengguna . '/edit') . '\')" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i>Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/jenispengguna/' . $jenispengguna->id_jenis_pengguna . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
            
                return $btn;
            })
            

            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi berisi HTML
            ->make(true);
    }

    public function create(){
        return view('superadmin.jenis.create');
    }

    public function store(Request $request){
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_jenis_pengguna' => 'required|string|min:5|max:50',
                'kode_jenis_pengguna' => 'required|string|min:3|max:5'
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
            $jenispengguna = jenispenggunamodel::create([
                'nama_jenis_pengguna' => $request->nama_jenis_pengguna,
                'kode_jenis_pengguna' => $request->kode_jenis_pengguna,
            ]);

            if($jenispengguna){
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
        return redirect('/jenispengguna');
    }

    public function edit(string $id){
        $jenispengguna = jenispenggunamodel::find($id);
        return view('superadmin.jenis.edit', ['jenispengguna' => $jenispengguna]);
    }

    public function update(Request $request,$id){
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_jenis_pengguna' => 'required|string|min:10|max:50',
                'kode_jenis_pengguna' => 'required|string|min:3|max:5'
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
            $check = jenispenggunamodel::find($id);
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
        return redirect('/jenispengguna');
    }
    public function delete(Request $request,$id){
        if ($request->ajax() || $request->wantsJson()) {
            $jenispengguna = jenispenggunamodel::find($id);
            if ($jenispengguna) {
                $jenispengguna->delete();
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
        return redirect('/jenispengguna');
    }

    public function confirm(string $id){
        $jenispengguna = jenispenggunamodel::find($id);
        return view('superadmin.jenis.delete', ['jenispengguna' => $jenispengguna]);
    }
    
    public function import(){
        return view('superadmin.jenis.import');
    }

    public function import_proses(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
        // validasi file harus xls atau xlsx, max 1MB
                'file_jenispengguna' => ['required', 'mimes:xlsx', 'max:1024'],
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $file = $request->file('file_jenispengguna'); // ambil file dari request
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
                            'nama_jenis_pengguna' => $value['A'],
                            'kode_jenis_pengguna' => $value['B'],
                        ];
                    }
                }
                if (count($insert) > 0) {
            // insert data ke database, jika data sudah ada, maka diabaikan
                    jenispenggunamodel::insertOrIgnore($insert);
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
        return redirect('/datapengguna');
    }
    public function export_excel()
    {
        //ambil data yang akan di export
        $jenispengguna = jenispenggunamodel::select('id_jenis_pengguna', 'nama_jenis_pengguna', 'kode_jenis_pengguna')
            ->orderBy('id_jenis_pengguna')
            ->get();

        //load library
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Jenis Pengguna');
        $sheet->setCellValue('C1', 'Kode Jenis Pengguna');

        $sheet->getStyle('A1:C1')->getFont()->setBold(true); //bold header

        $no = 1;
        $baris = 2;
        foreach ($jenispengguna as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->nama_jenis_pengguna);
            $sheet->setCellValue('C' . $baris, $value->kode_jenis_pengguna);
            $baris++;
            $no++;

        }

        foreach (range('A', 'C') as $columID) {
            $sheet->getColumnDimension($columID)->setAutoSize(true); //set auto size kolom
        }

        $sheet->setTitle('Data Jenis Pengguna');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Jenis Pengguna ' . date('Y-m-d H:i:s') . '.xlsx';
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
         $jenispengguna = jenispenggunamodel::select('id_jenis_pengguna', 'nama_jenis_pengguna', 'kode_jenis_pengguna')
            ->orderBy('id_jenis_pengguna')
            ->get();

         //use Barruvdh\DomPDF\Facade\\Pdf
        $pdf = Pdf::loadView('superadmin.jenis.export', ['jenispengguna'=>$jenispengguna]);
        $pdf->setPaper('a4', 'potrait');
        $pdf->setOption("isRemoteEnabled", false);
        $pdf->render();

        return $pdf->download('Data Jenis Pengguna '.date('Y-m-d H:i:s').'.pdf');
    }
}
