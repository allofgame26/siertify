<?php

namespace App\Http\Controllers;

use App\Models\vendorpelathihanmodel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Yajra\DataTables\Facades\DataTables;

class VendorPelatihanController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Data Vendor Pelatihan',
            'list' => ['Welcome', 'Vendor Pelatihan'],
        ];

        $page = (object) [
            'title' => 'Vendor Pelatihan ',
        ];

        $activeMenu = 'pelatihan';

        return view('admin.vendorpelatihan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $vendorPelatihan = vendorpelathihanmodel::select(
            'id_vendor_pelatihan',
            'nama_vendor_pelatihan',
            'alamat_vendor_pelatihan',
            'kota_vendor_pelatihan',
            'notelp_vendor_pelatihan',
            'web_vendor_pelatihan'
        );

        // Return data untuk DataTables
        return DataTables::of($vendorPelatihan)
            ->addIndexColumn() // menambahkan kolom index / nomor urut
            ->addColumn('aksi', function ($vendorPelatihan) {
                $btn = '<button onclick="modalAction(\'' . url('/vendor/pelatihan/' . $vendorPelatihan->id_vendor_pelatihan . '/show') . '\')" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i>Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/vendor/pelatihan/' . $vendorPelatihan->id_vendor_pelatihan . '/edit_ajax') . '\')" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i>Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/vendor/pelatihan/' . $vendorPelatihan->id_vendor_pelatihan . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })

            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi berisi HTML
            ->make(true);
    }

    public function create_ajax()
    {
        return view('admin.vendorpelatihan.create');
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_vendor_pelatihan' => 'required|string|min:3|max:50',
                'alamat_vendor_pelatihan' => 'required|string|min:3|max:255',
                'kota_vendor_pelatihan' => 'required|string|min:3|max:25',
                'notelp_vendor_pelatihan' => 'required|string|min:3|max:15',
                'web_vendor_pelatihan' => 'required|string|min:1|max:30',
            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }
            vendorpelathihanmodel::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Data Jenis berhasil disimpan',
            ]);
        }
        return redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $vendor = vendorpelathihanmodel::find($id);
        return view('admin.vendorpelatihan.edit', ['vendor' => $vendor]);
    }

    // 4. public function update_ajax(Request $request, $id)
    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nama_vendor_pelatihan' => 'required|string|min:3|max:50',
                'alamat_vendor_pelatihan' => 'required|string|min:3|max:255',
                'kota_vendor_pelatihan' => 'required|string|min:3|max:25',
                'notelp_vendor_pelatihan' => 'required|string|min:3|max:15',
                'web_vendor_pelatihan' => 'required|string|min:1|max:30',
            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Validasi gagal.',
                    'msgField' => $validator->errors(), // menunjukkan field mana yang error
                ]);
            }
            $check = vendorpelathihanmodel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil diupdate',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ]);
            }
        }

        return redirect('/');

    }

    public function show(string $id)
    {
        $vendor = vendorpelathihanmodel::find($id);
        return view('admin.vendorpelatihan.show', ['vendor' => $vendor]);
    }

    public function confirm_ajax(string $id)
    {
        $vendor = vendorpelathihanmodel::find($id);
        return view('admin.vendorpelatihan.confirm_delete', ['vendor' => $vendor]);
    }

    // 6. public function delete_ajax(Request $request, $id)
    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $vendor = vendorpelathihanmodel::find($id);
            if ($vendor) {
                $vendor->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Data berhasil dihapus',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan',
                ]);
            }
        }
        return redirect('/');
    }

    public function import()
    {
        return view('admin.vendorpelatihan.import_excel');
    }

    public function import_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                // validasi file harus xls atau xlsx, max 1MB
                'file_vendor' => ['required', 'mimes:xlsx', 'max:1024'],
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(),
                ]);
            }

            $file = $request->file('file_vendor'); // ambil file dari request
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
                            'nama_vendor_pelatihan' => $value['A'],
                            'alamat_vendor_pelatihan' => $value['B'],
                            'kota_vendor_pelatihan' => $value['C'],
                            'notelp_vendor_pelatihan' => $value['D'],
                            'web_vendor_pelatihan' => $value['E'],
                        ];
                    }
                }
                if (count($insert) > 0) {
                    // insert data ke database, jika data sudah ada, maka diabaikan
                    vendorpelathihanmodel::insertOrIgnore($insert);
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
        $vendor = vendorpelathihanmodel::select(
                'id_vendor_pelatihan',
                'nama_vendor_pelatihan',
                'alamat_vendor_pelatihan',
                'kota_vendor_pelatihan',
                'notelp_vendor_pelatihan',
                'web_vendor_pelatihan')
            ->orderBy('id_vendor_pelatihan')
            ->get();

        //load library
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Vendor');
        $sheet->setCellValue('C1', 'Alamat');
        $sheet->setCellValue('D1', 'Kota');
        $sheet->setCellValue('E1', 'Nomor Telp');
        $sheet->setCellValue('F1', 'Alamat Web');

        $sheet->getStyle('A1:F1')->getFont()->setBold(true); //bold header

        $no = 1;
        $baris = 2;
        foreach ($vendor as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->nama_vendor_pelatihan);
            $sheet->setCellValue('C' . $baris, $value->alamat_vendor_pelatihan);
            $sheet->setCellValue('D' . $baris, $value->kota_vendor_pelatihan);
            $sheet->setCellValue('E' . $baris, $value->notelp_vendor_pelatihan);
            $sheet->setCellValue('F' . $baris, $value->web_vendor_pelatihan);
            $baris++;
            $no++;

        }

        foreach (range('A', 'F') as $columID) {
            $sheet->getColumnDimension($columID)->setAutoSize(true); //set auto size kolom
        }

        $sheet->setTitle('Data Vendor Pelatihan');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Vendor Pelatihan' . date('Y-m-d H:i:s') . '.xlsx';
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
        $vendor = vendorpelathihanmodel::select(
                'id_vendor_pelatihan',
                'nama_vendor_pelatihan',
                'alamat_vendor_pelatihan',
                'kota_vendor_pelatihan',
                'notelp_vendor_pelatihan',
                'web_vendor_pelatihan')
            ->orderBy('id_vendor_pelatihan')
            ->get();

        //use Barruvdh\DomPDF\Facade\\Pdf
        $pdf = Pdf::loadView('admin.vendorpelatihan.export_pdf', ['vendor' => $vendor]);
        $pdf->setPaper('a4', 'potrait');
        $pdf->setOption("isRemoteEnabled", false);
        $pdf->render();

        return $pdf->download('Data Vendor Pelatihan ' . date('Y-m-d H:i:s') . '.pdf');
    }

}
