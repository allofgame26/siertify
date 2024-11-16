<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\jenispelatihansertifikasimodel;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;

class JenisPelatihanSertifikasiController extends Controller
{
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Data Jenis Pelatihan dan Sertifikasi',
            'list' => ['Welcome','Jenis Pelatihan dan Sertifikasi']
        ];

        $page = (object)[
            'title' => 'Jenis Pelatihan dan Sertifikasi '
        ];

        $activeMenu = 'jenis';

        return view('admin.jenis.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $jenis = jenispelatihansertifikasimodel::select('id_jenis_pelatihan_sertifikasi', 'nama_jenis_sertifikasi', 'deskripsi_pendek');

        // Return data untuk DataTables
        return DataTables::of($jenis)
            ->addIndexColumn() // menambahkan kolom index / nomor urut
            ->addColumn('aksi', function ($jenis) {
                $btn = '<button onclick="modalAction(\'' . url('/jenis/' . $jenis->id_jenis_pelatihan_sertifikasi . '/edit_ajax') . '\')" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i>Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/jenis/' . $jenis->id_jenis_pelatihan_sertifikasi . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
            
                return $btn;
            })
            

            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi berisi HTML
            ->make(true);
    }

    public function create_ajax()
    {
        return view('admin.jenis.create');
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_jenis_sertifikasi' => 'required|string|min:3|max:50',
                'deskripsi_pendek' => 'required|string|min:1|max:255'
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
            jenispelatihansertifikasimodel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data Jenis berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $jenis = jenispelatihansertifikasimodel::find($id);
        return view('admin.jenis.edit', ['jenis' => $jenis]);
    }

    // 4. public function update_ajax(Request $request, $id)
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
              'nama_jenis_sertifikasi' => 'required|string|min:3|max:50',
            'deskripsi_pendek' => 'required|string|min:1|max:255'
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
            $check = jenispelatihansertifikasimodel::find($id);
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
        return redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $jenis = jenispelatihansertifikasimodel::find($id);
        return view('admin.jenis.confirm_delete', ['jenis' => $jenis]);
    }

    // 6. public function delete_ajax(Request $request, $id)
    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $jenis = jenispelatihansertifikasimodel::find($id);
            if ($jenis) {
                $jenis->delete();
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
        return redirect('/');
    }

    public function import(){
        return view('admin.jenis.import_excel');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
        // validasi file harus xls atau xlsx, max 1MB
                'file_jenis' => ['required', 'mimes:xlsx', 'max:1024'],
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $file = $request->file('file_jenis'); // ambil file dari request
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
                            'nama_jenis_sertifikasi' => $value['A'],
                            'deskripsi_pendek' => $value['B'],
                        ];
                    }
                }
                if (count($insert) > 0) {
            // insert data ke database, jika data sudah ada, maka diabaikan
                    jenispelatihansertifikasimodel::insertOrIgnore($insert);
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
        return redirect('/');
    }

    public function export_excel()
    {
        //ambil data yang akan di export
        $jenis = jenispelatihansertifikasimodel::select('id_jenis_pelatihan_sertifikasi', 'nama_jenis_sertifikasi', 'deskripsi_pendek')
            ->orderBy('id_jenis_pelatihan_sertifikasi')
            ->get();

        //load library
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Jenis Pelatihan dan Sertifikasi');
        $sheet->setCellValue('C1', 'Deskripsi');

        $sheet->getStyle('A1:C1')->getFont()->setBold(true); //bold header

        $no = 1;
        $baris = 2;
        foreach ($jenis as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->nama_jenis_sertifikasi);
            $sheet->setCellValue('C' . $baris, $value->deskripsi_pendek);
            $baris++;
            $no++;

        }

        foreach (range('A', 'F') as $columID) {
            $sheet->getColumnDimension($columID)->setAutoSize(true); //set auto size kolom
        }

        $sheet->setTitle('Data Jenis');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Jenis Pelatihan dan Sertifikasi ' . date('Y-m-d H:i:s') . '.xlsx';
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
         $jenis = jenispelatihansertifikasimodel::select('id_jenis_pelatihan_sertifikasi', 'nama_jenis_sertifikasi', 'deskripsi_pendek')
         ->orderBy('id_jenis_pelatihan_sertifikasi')
         ->get();

         //use Barruvdh\DomPDF\Facade\\Pdf
        $pdf = Pdf::loadView('admin.jenis.export_pdf', ['jenis'=>$jenis]);
        $pdf->setPaper('a4', 'potrait');
        $pdf->setOption("isRemoteEnabled", false);
        $pdf->render();

        return $pdf->download('Data jenis '.date('Y-m-d H:i:s').'.pdf');
    }














}
