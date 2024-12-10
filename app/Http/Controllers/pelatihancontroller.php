<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pelatihanmodel;
use App\Models\vendorsertifikasimodel;
use App\Models\jenispelatihansertifikasimodel;
use App\Models\vendorpelatihanmodel;
use Illuminate\Support\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;

class pelatihancontroller extends Controller
{
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Pelatihan',
            'list' => ['Selamat Datang','Pelatihan']
        ];

        $page = (object)[
            'title' => 'Data Pelatihan'
        ];

        $activeMenu = 'pelatihan';

        $vendor = vendorpelatihanmodel::select('id_vendor_pelatihan','nama_vendor_pelatihan')->get();

        $jenis = jenispelatihansertifikasimodel::select('id_jenis_pelatihan_sertifikasi','nama_jenis_sertifikasi')->get();

        $pelatihan = pelatihanmodel::select('id_pelatihan','nama_pelatihan','id_jenis_pelatihan_sertifikasi','id_vendor_pelatihan','level_pelatihan')->get();

        return view('admin.masterpelatihan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'vendor' => $vendor, 'jenis' => $jenis, 'pelatihan' => $pelatihan]);
    }

    public function list(Request $request)
    {
        $pelatihan = pelatihanmodel::select('id_pelatihan','nama_pelatihan','id_jenis_pelatihan_sertifikasi','id_vendor_pelatihan','level_pelatihan')
        ->with(['vendorpelatihan','jenispelatihan'])
        ->get();

        // Return data untuk DataTables
        return DataTables::of($pelatihan)
            ->addIndexColumn() // menambahkan kolom index / nomor urut
            ->addColumn('nama_jenis_sertifikasi', function ($pelatihan) {
                return $pelatihan->jenispelatihan->nama_jenis_sertifikasi ?? 'Error';
            })
            ->addColumn('nama_vendor_pelatihan', function ($pelatihan) {
                return $pelatihan->vendorpelatihan->nama_vendor_pelatihan ?? 'Error';
            })
            ->addColumn('aksi', function ($pelatihan) {
                $btn = '<button onclick="modalAction(\'' . url('/masterpelatihan/' . $pelatihan->id_pelatihan . '/show') . '\')" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i>Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/masterpelatihan/' . $pelatihan->id_pelatihan . '/edit') . '\')" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i>Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/masterpelatihan/' . $pelatihan->id_pelatihan . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            

            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi berisi HTML
            ->make(true);
    }

    public function show(string $id){

        $pelatihan= pelatihanmodel::select('id_pelatihan','nama_pelatihan','id_jenis_pelatihan_sertifikasi','id_vendor_pelatihan','level_pelatihan')
        ->with(['vendorpelatihan','jenispelatihan'])
        ->find($id);

        return view('admin.masterpelatihan.show')->with(['pelatihan' => $pelatihan]);
    }

    public function create(){

        $vendor = vendorpelatihanmodel::select('id_vendor_pelatihan','nama_vendor_pelatihan')->get();

        $jenis = jenispelatihansertifikasimodel::select('id_jenis_pelatihan_sertifikasi','nama_jenis_sertifikasi')->get();

        $pelatihan = pelatihanmodel::select('id_pelatihan','nama_pelatihan','id_jenis_pelatihan_sertifikasi','id_vendor_pelatihan','level_pelatihan')->get();

        return view('admin.masterpelatihan.create')->with(['pelatihan' => $pelatihan, 'vendor' => $vendor, 'jenis' => $jenis]);
    }

    public function store(Request $request){
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_pelatihan' => 'required|max:100', // Validasi ID Identitas (harus ada di tabel 'identitas')
                'id_jenis_pelatihan_sertifikasi' => 'required|integer', // Validasi ID Jenis Pengguna
                'id_vendor_pelatihan' => 'required|integer', // Validasi ID Periode
                'level_pelatihan' => 'required', // Username unik
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
            $pelatihan = pelatihanmodel::create([
                'nama_pelatihan' => $request->nama_pelatihan,
                'id_vendor_pelatihan' => $request->id_vendor_pelatihan,
                'id_jenis_pelatihan_sertifikasi' => $request->id_jenis_pelatihan_sertifikasi,
                'level_pelatihan' => $request->level_pelatihan,
            ]);

            if($pelatihan){
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
        return redirect('/masterpelatihan');
    }

    public function edit(string $id){

        $vendor = vendorpelatihanmodel::select('id_vendor_pelatihan','nama_vendor_pelatihan')->get();

        $jenis = jenispelatihansertifikasimodel::select('id_jenis_pelatihan_sertifikasi','nama_jenis_sertifikasi')->get();

        $pelatihan = pelatihanmodel::select('id_pelatihan','nama_pelatihan','id_jenis_pelatihan_sertifikasi','id_vendor_pelatihan','level_pelatihan')->find($id);

        return view('admin.masterpelatihan.edit')->with(['pelatihan' => $pelatihan, 'vendor' => $vendor, 'jenis' => $jenis]);
    }
    
    public function update(Request $request,$id){
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_pelatihan' => 'required|max:100', // Validasi ID Identitas (harus ada di tabel 'identitas')
                'id_jenis_pelatihan_sertifikasi' => 'required|integer', // Validasi ID Jenis Pengguna
                'id_vendor_pelatihan' => 'required|integer', // Validasi ID Periode
                'level_pelatihan' => 'required', // Username unik
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

            $check = pelatihanmodel::find($id);

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
        return redirect('/masterpelatihan');
    }

    public function delete(Request $request,$id){
        if ($request->ajax() || $request->wantsJson()) {
            $pelatihan = pelatihanmodel::find($id);
            if ($pelatihan) {
                $pelatihan->delete();
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
        return redirect('/masterpelatihan');
    }
    
    public function confirm(string $id){

        $vendor = vendorpelatihanmodel::select('id_vendor_pelatihan','nama_vendor_pelatihan')->get();

        $jenis = jenispelatihansertifikasimodel::select('id_jenis_pelatihan_sertifikasi','nama_jenis_sertifikasi')->get();

        $pelatihan = pelatihanmodel::select('id_pelatihan','nama_pelatihan','id_jenis_pelatihan_sertifikasi','id_vendor_pelatihan','level_pelatihan')->find($id);

        return view('admin.masterpelatihan.delete')->with(['pelatihan' => $pelatihan, 'vendor' => $vendor, 'jenis' => $jenis]);
    }

    public function import(){
        return view('admin.masterpelatihan.import');
    }

    public function import_proses(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
        // validasi file harus xls atau xlsx, max 1MB
                'file_masterpelatihan' => ['required', 'mimes:xlsx', 'max:1024'],
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $file = $request->file('file_masterpelatihan'); // ambil file dari request
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
                            'id_pelatihan' => $value['A'],
                            'id_vendor_pelatihan' => $value['B'],
                            'id_jenis_pelatihan_sertifikasi' => $value['C'],
                            'level_pelatihan' => $value['D'],
                        ];
                    }
                }
                if (count($insert) > 0) {
            // insert data ke database, jika data sudah ada, maka diabaikan
                    pelatihanmodel::insertOrIgnore($insert);
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
        return redirect('/masterpelatihan');
    }

    public function export_excel()
    {
        //ambil data yang akan di export
        $pelatihan = pelatihanmodel::select('id_pelatihan','nama_pelatihan','id_jenis_pelatihan_sertifikasi','id_vendor_pelatihan','level_pelatihan')
        ->with(['vendorpelatihan','jenispelatihan'])
        ->get();

        //load library
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'ID Pelatihan');
        $sheet->setCellValue('C1', 'Nama Pelatihan');
        $sheet->setCellValue('D1', 'ID Vendor Pelatihan');
        $sheet->setCellValue('E1', 'ID Jenis Pelatihan Sertifikasi');
        $sheet->setCellValue('F1', 'Level Pelatihan');

        $sheet->getStyle('A1:F1')->getFont()->setBold(true); //bold header

        $no = 1;
        $baris = 2;
        foreach ($pelatihan as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->id_pelatihan);
            $sheet->setCellValue('C' . $baris, $value->nama_pelatihan);
            $sheet->setCellValue('D' . $baris, $value->id_vendor_pelatihan);
            $sheet->setCellValue('E' . $baris, $value->id_jenis_pelatihan_sertifikasi);
            $sheet->setCellValue('F' . $baris, $value->level_pelatihan);
            $baris++;
            $no++;

        }

        foreach (range('A', 'F') as $columID) {
            $sheet->getColumnDimension($columID)->setAutoSize(true); //set auto size kolom
        }

        $sheet->setTitle('Data Master Pelatihan');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Master Pelatihan ' . date('Y-m-d H:i:s') . '.xlsx';
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
         $pelatihan = pelatihanmodel::select('id_pelatihan','nama_pelatihan','id_jenis_pelatihan_sertifikasi','id_vendor_pelatihan','level_pelatihan')
        ->with(['vendorpelatihan','jenispelatihan'])
        ->get();

         //use Barruvdh\DomPDF\Facade\\Pdf
        $pdf = Pdf::loadView('admin.masterpelatihan.export', ['pelatihan'=>$pelatihan]);
        $pdf->setPaper('a4', 'potrait');
        $pdf->setOption("isRemoteEnabled", false);
        $pdf->render();

        return $pdf->download('Data Master Sertifikasi '.date('Y-m-d H:i:s').'.pdf');
    }


}
