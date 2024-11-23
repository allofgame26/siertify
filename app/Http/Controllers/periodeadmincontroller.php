<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\periodemodel;
use Illuminate\Support\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;

class periodeadmincontroller extends Controller
{
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Data Periode',
            'list' => ['Selamat Datang','Data Periode']
        ];

        $page = (object)[
            'title' => 'Data Periode'
        ];

        $activeMenu = 'periode';

        return view('admin.periode.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $periode= periodemodel::select('id_periode','nama_periode','tanggal_mulai','tanggal_selesai','tahun_periode','deskripsi_periode');

        // Return data untuk DataTables
        return DataTables::of($periode)
            ->addIndexColumn() // menambahkan kolom index / nomor urut
            ->addColumn('aksi', function ($periode) {
                $btn = '<button onclick="modalAction(\'' . url('/periode/' . $periode->id_periode . '/show') . '\')" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i>Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/periode/' . $periode->id_periode . '/edit') . '\')" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i>Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/periode/' . $periode->id_periode . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
            
                return $btn;
            })
            

            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi berisi HTML
            ->make(true);
    }

    public function create(){
        return view('admin.periode.create');
    }

    public function store(Request $request){
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_periode' => '  required|string|min:8|max:10',
                'tanggal_mulai' => '  required|date',
                'tanggal_selesai' => '  required|date',
                'tahun_periode' => 'required|string|min:8|max:20',
                'deskripsi_periode' => 'required|string|min:10|max:30'
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
            $periode = periodemodel::create([
                'nama_jenis_pengguna' => $request->nama_periode,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'tahun_periode' => $request->tahun_periode,
                'deskripsi_periode' => $request->deskripsi_periode
            ]);

            if($periode){
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
        return redirect('/periode');
    }

    public function edit(string $id){
        $periode = periodemodel::find($id);
        return view('admin.periode.edit', ['periode' => $periode]);
    }

    public function update(Request $request,$id){
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_periode' => '  required|string|min:8|max:10',
                'tanggal_mulai' => '  required|date',
                'tanggal_selesai' => '  required|date',
                'tahun_periode' => 'required|string|min:8|max:20',
                'deskripsi_periode' => 'required|string|min:10|max:30'
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
            $check = periodemodel::find($id);
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
        return redirect('/periode');
    }

    public function show(string $id)
    {
        $periode = periodemodel::find($id);
        return view('admin.periode.show', ['periode' => $periode]);
    }

    public function delete(Request $request,$id){
        if ($request->ajax() || $request->wantsJson()) {
            $periode = periodemodel::find($id);
            if ($periode) {
                $periode->delete();
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
        return redirect('/periode');
    }

    public function confirm(string $id){
        $periode = periodemodel::find($id);
        return view('admin.periode.delete', ['periode' => $periode]);
    }
    
    public function import(){
        return view('admin.periode.import');
    }

    public function import_proses(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
        // validasi file harus xls atau xlsx, max 1MB
                'file_fileperiode' => ['required', 'mimes:xlsx', 'max:1024'],
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $file = $request->file('file_fileperiode'); // ambil file dari request
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
                            'nam_periode' => $value['A'],
                            'tanggal_mulai' => $value['B'],
                            'tanggal_selesai' => $value['C'],
                            'tahun_periode' => $value['D'],
                            'deskripsi_periode' => $value['E'],
                        ];
                    }
                }
                if (count($insert) > 0) {
            // insert data ke database, jika data sudah ada, maka diabaikan
                    periodemodel::insertOrIgnore($insert);
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
        return redirect('/periode');
    }
    public function export_excel()
    {
        //ambil data yang akan di export
        $periode = periodemodel::select('id_periode', 'nama_periode', 'tanggal_mulai','tanggal_selesai','tahun_periode','deskripsi_periode')
            ->orderBy('id_periode')
            ->get();

        //load library
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(); // membuat Sheet baru

        $sheet->setCellValue('A1', 'No'); // Header baru
        $sheet->setCellValue('B1', 'Nama Periode');
        $sheet->setCellValue('C1', 'Tanggal Mulai');
        $sheet->setCellValue('D1', 'Tanggal Selesai');
        $sheet->setCellValue('E1', 'Tahun periode');
        $sheet->setCellValue('F1', 'Deskripsi Periode');

        $sheet->getStyle('A1:C1')->getFont()->setBold(true); //bold header

        $no = 1;
        $baris = 2;
        foreach ($periode as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->nnama_periode);
            $sheet->setCellValue('C' . $baris, $value->tanggal_mulai);
            $sheet->setCellValue('D' . $baris, $value->tanggal_selesai);
            $sheet->setCellValue('E' . $baris, $value->tahun_periode);
            $sheet->setCellValue('F' . $baris, $value->deskripsi_periode);
            $baris++;
            $no++;

        }

        foreach (range('A', 'F') as $columID) {
            $sheet->getColumnDimension($columID)->setAutoSize(true); //set auto size kolom
        }

        $sheet->setTitle('Data Periode');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Periode ' . date('Y-m-d H:i:s') . '.xlsx';
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
         $periode = periodemodel::select('id_periode', 'nama_periode', 'tanggal_mulai','tanggal_selesai','tahun_periode','deskripsi_periode')
            ->orderBy('id_periode')
            ->get();

         //use Barruvdh\DomPDF\Facade\\Pdf
        $pdf = Pdf::loadView('admin.periode.export', ['periode'=>$periode]);
        $pdf->setPaper('a4', 'potrait');
        $pdf->setOption("isRemoteEnabled", false);
        $pdf->render();

        return $pdf->download('Data Periode '.date('Y-m-d H:i:s').'.pdf');
    }
}
