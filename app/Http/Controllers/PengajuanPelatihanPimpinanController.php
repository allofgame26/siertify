<?php

namespace App\Http\Controllers;

use App\Models\pelatihanmodel;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;

class PengajuanPelatihanPimpinanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Data Penawaran Pelatihan & Sertifikasi ',
            'list' => ['Welcome', 'Pengajuan Pelatihan dan Sertifikasi Pimpinan']
        ];

        $page = (object)[
            'title' => 'Penawaran Pelatihan  & Sertifikasi'
        ];

        $activeMenu = 'pengajuan'; //set menu yang sedang aktif

        return view('pimpinan.pengajuan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $pengajuan = pelatihanmodel::select('nama_pelatihan', 'tanggal_mulai', 'id_vendor_pelatihan', 'status_disetujui');

        // Return data untuk DataTables
        return DataTables::of($pengajuan)
            ->addIndexColumn() // menambahkan kolom index / nomor urut
            ->addColumn('aksi', function ($pengajuan) {
                $btn  = '<button onclick="modalAction(\''.url('/pengajuan/' . $pengajuan->id_pelatihan . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> '; 
                $btn = '<button onclick="modalAction(\'' . url('/pengajuan/' . $pengajuan->id_pelatihan . '/edit_ajax') . '\')" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i>Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/pengajuan/' . $pengajuan->id_pelatihan . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })


            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi berisi HTML
            ->make(true);
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_pelatihan' => 'required|string|min:3|max:50',
                'tanggal_mulai' => 'required|string|min:1|max:255',
                'id_vendor_pelatihan' => 'required|string|min:1|max:255',
                'status_disetujui' => 'required|string|min:1|max:255',
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
            pelatihanmodel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data Jenis berhasil disimpan'
            ]);
        }
        return redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $pengajauan = pelatihanmodel::find($id);
        return view('pimpinan.pengajuan.edit', ['jenis' => $pengajauan]);
    }

    // 4. public function update_ajax(Request $request, $id)
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_pelatihan' => 'required|string|min:3|max:50',
                'tanggal_mulai' => 'required|string|min:1|max:255',
                'id_vendor_pelatihan' => 'required|string|min:1|max:30',
                'status_disetujui' => 'required|string|min:1|max:5',
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
        return redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $pengajauan = pelatihanmodel::find($id);
        return view('pimpinan.pengajuan.confirm_delete', ['pengajuan' => $pengajauan]);
    }

    // 6. public function delete_ajax(Request $request, $id)
    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $jenis = pelatihanmodel::find($id);
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

    public function export_excel()
    {
        //ambil data yang akan di export
        $pengajauan = pelatihanmodel::select('nama_pelatihan', 'tanggal_mulai', 'id_vendor_pelatihan', 'status_disetujui')
            ->orderBy('id_pelatihan')
            ->get();

        //load library
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Pelatihan');
        $sheet->setCellValue('C1', 'Tanggal Pelaksanaan');
        $sheet->setCellValue('D1', 'Nama vendor');
        $sheet->setCellValue('E1', 'Status');

        $sheet->getStyle('A1:E1')->getFont()->setBold(true); //bold header

        $no = 1;
        $baris = 2;
        foreach ($pengajauan as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->nama_pelatihan);
            $sheet->setCellValue('C' . $baris, $value->tanggal_mulai);
            $sheet->setCellValue('D' . $baris, $value->id_vendor_pelatihan);
            $sheet->setCellValue('E' . $baris, $value->status_disetujui);
            $baris++;
            $no++;
        }

        foreach (range('A', 'F') as $columID) {
            $sheet->getColumnDimension($columID)->setAutoSize(true); //set auto size kolom
        }

        $sheet->setTitle('Data Pelatihan');
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

    public function export_pdf()
    {
        //ambil data yang akan di export
        $pengajauan = pelatihanmodel::select('nama_pelatihan', 'tanggal_mulai', 'id_vendor_pelatihan', 'status_disetujui')
            ->orderBy('id_pelatihan')
            ->get();

        //use Barruvdh\DomPDF\Facade\\Pdf
        $pdf = Pdf::loadView('pimpinan.pengajuan.export_pdf', ['pengajuan' => $pengajauan]);
        $pdf->setPaper('a4', 'potrait');
        $pdf->setOption("isRemoteEnabled", false);
        $pdf->render();

        return $pdf->download('Data Peangajuan ' . date('Y-m-d H:i:s') . '.pdf');
    }

     public function show_ajax(string $id) {
        // Cari barang berdasarkan id
        $pengajuan = pelatihanmodel::find($id);
    
        // Periksa apakah barang ditemukan
        if ($pengajuan) {
            // Tampilkan halaman show_ajax dengan data barang
            return view('pengajuan.show_ajax', ['pengajuan' => $pengajuan]);
        } else {
            // Tampilkan pesan kesalahan jika barang tidak ditemukan
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }
}
