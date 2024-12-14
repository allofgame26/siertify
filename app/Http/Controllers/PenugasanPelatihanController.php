<?php

namespace App\Http\Controllers;

use App\Models\detailpelatihan;
use App\Models\jenispelatihansertifikasimodel;
use App\Models\pelatihanmodel;
use App\Models\periodemodel;
use App\Models\vendorpelatihanmodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\akunusermodel;

class PenugasanPelatihanController extends Controller
{
    public function index()
    {
        $activeMenu = 'penugasan';
        $breadcrumb = (object) [
            'title' => 'Data Penugasan Pelatihan dan Sertifikasi',
            'list' => ['Home', 'Pelatihan dan Sertifikasi'],
        ];
        $page = (object) [
            'title' => 'Penugasan Pelatihan',
        ];

        $pelatihan = pelatihanmodel::all();
        $jenisPelatihan = jenispelatihansertifikasimodel::all();
        $vendorPelatihan = vendorpelatihanmodel::all();
        $detail = detailpelatihan::all();
        $periode = periodemodel::all();

        return view('dosen.penugasanpelatihan.index', [
            'activeMenu' => $activeMenu,
            'breadcrumb' => $breadcrumb,
            'pelatihan' => $pelatihan,
            'jenisPelatihan' => $jenisPelatihan,
            'vendor' => $vendorPelatihan,
            'detail' => $detail,
            'periode' => $periode,
            'page' => $page,
        ]);
    }

    public function list(Request $request)
    {
        $user_id = Auth::user()->id_user; // Ambil ID user yang login

        $pelatihan = detailpelatihan::join(
            'm_pelatihan as pelatihan',
            'pelatihan.id_pelatihan', '=', 't_detailpelatihan.id_pelatihan'
        )->join(
            'm_vendor_pelatihan as vendor',
            'pelatihan.id_vendor_pelatihan', '=', 'vendor.id_vendor_pelatihan'
        )->join(
            'm_jenis_pelatihan_sertifikasi as j',
            'j.id_jenis_pelatihan_sertifikasi', '=', 'pelatihan.id_jenis_pelatihan_sertifikasi'
        )->join(
            'm_periode as periode',
            'periode.id_periode', '=', 't_detailpelatihan.id_periode'
        )->join(
            't_peserta_pelatihan as p',
            'p.id_detail_pelatihan', '=', 't_detailpelatihan.id_detail_pelatihan'
        )->select(
            'pelatihan.*',
            'vendor.*',
            'j.*',
            'periode.*',
            't_detailpelatihan.*',
            'p.*'
        )->where(
            'p.id_user', '=', $user_id
        )->orderBy('t_detailpelatihan.tanggal_mulai');

           // Apply filter berdasarkan id_periode jika ada
           if ($request->id_periode_pelatihan) {
            $pelatihan->where('t_detailpelatihan.id_periode', $request->id_periode_pelatihan);
        }

        // Ambil data setelah semua filter diterapkan
        $pelatihan = $pelatihan->get();

        return DataTables::of($pelatihan)
            ->addIndexColumn()
            ->addColumn('aksi', function ($penugasan) {
                $btn = '<button onclick="modalAction(\'' . url('/penugasan/pelatihan/' . $penugasan->id_detail_pelatihan . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/penugasan/pelatihan/' . $penugasan->id_detail_pelatihan . '/create') . '\')" class="btn btn-success btn-sm"><i class="fas fa-plus-square"
                                style="margin-right: 8px;"></i>Riwayat</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);

    }

    public function show(string $id)
    {
        // Ambil data sertifikasi
        $pelatihan = detailpelatihan::join(
            'm_pelatihan as pelatihan',
            'pelatihan.id_pelatihan', '=', 't_detailpelatihan.id_pelatihan'
        )->join(
            'm_vendor_pelatihan as vendor',
            'pelatihan.id_vendor_pelatihan', '=', 'vendor.id_vendor_pelatihan'
        )->join(
            'm_jenis_pelatihan_sertifikasi as j',
            'j.id_jenis_pelatihan_sertifikasi', '=', 'pelatihan.id_jenis_pelatihan_sertifikasi'
        )->join(
            'm_periode as periode',
            'periode.id_periode', '=', 't_detailpelatihan.id_periode'
        )->join(
            't_peserta_pelatihan as p',
            'p.id_detail_pelatihan', '=', 't_detailpelatihan.id_detail_pelatihan'
        )->select(
            'pelatihan.*',
            'vendor.*',
            'j.*',
            'periode.*',
            't_detailpelatihan.*',
            'p.*'
        )->where(
            't_detailpelatihan.id_detail_pelatihan', '=', $id
        )->first();

        // Ambil mata kuliah terkait
        $mataKuliah = DB::table('t_tagging_mk_pelatihan as tagmk')
            ->join('m_mata_kuliah as mk', 'tagmk.id_mk', '=', 'mk.id_mk')
            ->where('tagmk.id_pelatihan', '=', $pelatihan->id_pelatihan)
            ->get();

        $mataKuliah = $mataKuliah->pluck('nama_mk')->toArray();

        // Ambil mata kuliah terkait
        $bidangMinat = DB::table('t_tagging_bd_pelatihan as tagbd')
            ->join('m_bidang_minat as bd', 'tagbd.id_bd', '=', 'bd.id_bd')
            ->where('tagbd.id_pelatihan', '=', $pelatihan->id_pelatihan)
            ->pluck('bd.nama_bd')
            ->toArray();

        $peserta = detailpelatihan::join(
            't_peserta_pelatihan as p',
            'p.id_detail_pelatihan', '=', 't_detailpelatihan.id_detail_pelatihan'
        )->join(
            'm_akun_user as us',
            'us.id_user', '=', 'p.id_user'
        )->join(
            'm_identitas_diri as id',
            'id.id_identitas', '=', 'us.id_identitas'
        )
            ->select(
                'id.nama_lengkap',
                'id.NIP'
            )->where(
            't_detailpelatihan.id_detail_pelatihan', '=', $id
        )->get();

        return view('dosen.penugasanpelatihan.show', compact('mataKuliah', 'bidangMinat', 'pelatihan', 'peserta'));
    }

    public function surat_tugas(Request $request, string $id)
    {

        // Cari data detail pelatihan berdasarkan ID
        $detailPelatihan = detailpelatihan::find($id);

        // Periksa apakah data ditemukan
        if (!$detailPelatihan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Detail pelatihan tidak ditemukan.',
            ], 404);
        }

        // Periksa apakah kolom surat tugas null
        if (is_null($detailPelatihan->surat_tugas)) {
            return response()->json([
                'status' => 'processing',
                'message' => 'Surat tugas masih dalam proses. Silakan tunggu.',
            ], 200);
        }

        // Path surat tugas di folder public/suratTugas
        $filePath = public_path('suratTugas/' . $detailPelatihan->surat_tugas);

        // Periksa apakah file surat tugas tersedia
        if (!file_exists($filePath)) {
            return response()->json([
                'status' => 'error',
                'message' => 'File surat tugas tidak tersedia.',
            ], 404);
        }

        // Unduh file surat tugas
        return response()->download($filePath);

    }

    public function create(string $id)
    {

        // Ambil data pelatihan
        $pelatihan = pelatihanmodel::join(
            'm_jenis_pelatihan_sertifikasi as jenis',
            'm_pelatihan.id_jenis_pelatihan_sertifikasi', '=', 'jenis.id_jenis_pelatihan_sertifikasi'
        )
            ->join(
                'm_vendor_pelatihan as vendor',
                'm_pelatihan.id_vendor_pelatihan', '=', 'vendor.id_vendor_pelatihan'
            )
            ->join(
                't_detailpelatihan as detail',
                'm_pelatihan.id_pelatihan', '=', 'detail.id_pelatihan'
            )
            ->join(
                'm_periode as periode',
                'detail.id_periode', '=', 'periode.id_periode'
            )
            ->select(
                'm_pelatihan.*',
                'jenis.*',
                'vendor.*',
                'periode.*',
                'detail.*'
            )
            ->where('detail.id_detail_pelatihan', '=', $id)
            ->distinct()
            ->first();

        // Ambil mata kuliah terkait
        $mataKuliah = DB::table('t_tagging_mk_pelatihan as tagmk')
            ->join('m_mata_kuliah as mk', 'tagmk.id_mk', '=', 'mk.id_mk')
            ->where('tagmk.id_pelatihan', '=', $pelatihan->id_pelatihan)
            ->select('mk.*')
            ->get()
            ->toArray();

        // Ambil mata kuliah terkait
        $bidangMinat = DB::table('t_tagging_bd_pelatihan as tagbd')
            ->join('m_bidang_minat as bd', 'tagbd.id_bd', '=', 'bd.id_bd')
            ->where('tagbd.id_pelatihan', '=', $pelatihan->id_pelatihan)
            ->select('bd.*')
            ->get()
            ->toArray();

        $jenisPelatihan = jenispelatihansertifikasimodel::all();
        $vendorPelatihan = vendorpelatihanmodel::all();
        $periode = periodemodel::all(); // Tetap diambil untuk kebutuhan lain

        return view('dosen.penugasanpelatihan.create', compact('mataKuliah', 'bidangMinat', 'pelatihan', 'jenisPelatihan', 'vendorPelatihan', 'periode'));

    }

    public function store(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            // Validasi input
            $rules = [
                'no_pelatihan' => 'required|string|max:20', // Validasi nomor pelatihan
                'bukti_pelatihan' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240', // Validasi bukti pelatihan (maks 10MB)
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }

            $dataDetail = detailpelatihan::find($id); // Temukan data berdasarkan ID

            // Setelah validasi berhasil, simpan data ke database
            $pelatihan = detailpelatihan::create([
                'id_pelatihan' => $dataDetail->id_pelatihan,
                'id_periode' => $dataDetail->id_periode,
                'id_user' => auth()->id(),
                'tanggal_mulai' => $dataDetail->tanggal_mulai,
                'tanggal_selesai' => $dataDetail->tanggal_selesai,
                'lokasi' => $dataDetail->lokasi,
                'biaya' => $dataDetail->biaya,
                'no_pelatihan' => $request->no_pelatihan,
                'bukti_pelatihan' => '', // Menyimpan nama file bukti pelatihan jika ada
                'input_by' => $request->input_by, // Menyimpan nilai 'input_by' berdasarkan role
            ]);

            // Menangani file bukti pelatihan jika ada
            if ($request->hasFile('bukti_pelatihan')) {

                if ($request->hasFile('bukti_pelatihan')) {
                    // Mengambil ID pengguna yang sedang login
                    $userId = Auth::user()->id_user;

                    // Menghitung jumlah bukti pelatihan yang sudah diupload oleh pengguna tersebut
                    $buktiCount = detailpelatihan::where('id_user', $userId)->count();

                    // Menentukan nama file
                    $fileName = 'bukti_' . $userId . '_' . ($buktiCount + 1) . '.' . $request->bukti_pelatihan->getClientOriginalExtension();

                    // Menyimpan file ke storage public/buktisertifikat
                    $request->bukti_pelatihan->move(public_path('buktiPelatihan'), $fileName);

                    // Update user dengan nama file avatar baru
                    $pelatihan->bukti_pelatihan = $fileName;
                    $pelatihan->save(); // Simpan perubahan ke database

                }
            }

            return response()->json([
                'status' => true,
                'message' => 'Data Jenis berhasil disimpan',
            ]);
        }

        // Mengembalikan respon atau redirect
        return redirect('/');
    }

    public function export_excel(){

        $user_id = Auth::user()->id_user; // Ambil ID user yang login

        $pelatihan = detailpelatihan::join(
            'm_pelatihan as pelatihan',
            'pelatihan.id_pelatihan', '=', 't_detailpelatihan.id_pelatihan'
        )->join(
            'm_vendor_pelatihan as vendor',
            'pelatihan.id_vendor_pelatihan', '=', 'vendor.id_vendor_pelatihan'
        )->join(
            'm_jenis_pelatihan_sertifikasi as j',
            'j.id_jenis_pelatihan_sertifikasi', '=', 'pelatihan.id_jenis_pelatihan_sertifikasi'
        )->join(
            'm_periode as periode',
            'periode.id_periode', '=', 't_detailpelatihan.id_periode'
        )->join(
            't_peserta_pelatihan as p',
            'p.id_detail_pelatihan', '=', 't_detailpelatihan.id_detail_pelatihan'
        )->select(
            'pelatihan.*',
            'vendor.*',
            'j.*',
            'periode.*',
            't_detailpelatihan.*',
            'p.*'
        )->where(
            'p.id_user', '=', $user_id
        )->orderBy('t_detailpelatihan.id_detail_pelatihan')
        ->get(); // Tambahkan get() untuk mengeksekusi query

          //load library
          $spreadsheet = new Spreadsheet();
          $sheet = $spreadsheet->getActiveSheet();
  
          $sheet->setCellValue('A1', 'No');
          $sheet->setCellValue('B1', 'Periode');
          $sheet->setCellValue('C1', 'Nama Pelatihan');
          $sheet->setCellValue('D1', 'Nama Vendor');
          $sheet->setCellValue('E1', 'Level');
          $sheet->setCellValue('F1', 'Tanggal Pelaksanaan');
          $sheet->setCellValue('G1', 'Lokasi');
  
          $sheet->getStyle('A1:G1')->getFont()->setBold(true); //bold header
  
          $no = 1;
          $baris = 2;
          foreach ($pelatihan as $key => $value) {
              $sheet->setCellValue('A' . $baris, $no);
              $sheet->setCellValue('B' . $baris, $value->nama_periode);
              $sheet->setCellValue('C' . $baris, $value->nama_pelatihan);
              $sheet->setCellValue('D' . $baris, $value->nama_vendor_pelatihan);
              $sheet->setCellValue('E' . $baris, $value->level_pelatihan);
              $sheet->setCellValue('F' . $baris, $value->tanggal_mulai);
              $sheet->setCellValue('G' . $baris, $value->lokasi);
              $baris++;
              $no++;
  
          }
  
          foreach (range('A', 'G') as $columID) {
              $sheet->getColumnDimension($columID)->setAutoSize(true); //set auto size kolom
          }
  
          $sheet->setTitle('Data Penugasan Pelatihan');
          $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
          $filename = 'Data Penugasan Pelatihan' . date('Y-m-d H:i:s') . '.xlsx';
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
        $user_id = Auth::user()->id_user; // Ambil ID user yang login

        $pelatihan = detailpelatihan::join(
            'm_pelatihan as pelatihan',
            'pelatihan.id_pelatihan', '=', 't_detailpelatihan.id_pelatihan'
        )->join(
            'm_vendor_pelatihan as vendor',
            'pelatihan.id_vendor_pelatihan', '=', 'vendor.id_vendor_pelatihan'
        )->join(
            'm_jenis_pelatihan_sertifikasi as j',
            'j.id_jenis_pelatihan_sertifikasi', '=', 'pelatihan.id_jenis_pelatihan_sertifikasi'
        )->join(
            'm_periode as periode',
            'periode.id_periode', '=', 't_detailpelatihan.id_periode'
        )->join(
            't_peserta_pelatihan as p',
            'p.id_detail_pelatihan', '=', 't_detailpelatihan.id_detail_pelatihan'
        )->select(
            'pelatihan.*',
            'vendor.*',
            'j.*',
            'periode.*',
            't_detailpelatihan.*',
            'p.*'
        )->where(
            'p.id_user', '=', $user_id
        )->orderBy('t_detailpelatihan.id_detail_pelatihan')
        ->get(); // Tambahkan get() untuk mengeksekusi query


        $identitas = akunusermodel::join(
            'm_identitas_diri as d',
            'd.id_identitas', '=', 'm_akun_user.id_identitas'
        )
            ->where(
                'm_akun_user.id_user', '=', $user_id
            )->first();

        //use Barruvdh\DomPDF\Facade\\Pdf
        $pdf = Pdf::loadView('dosen.penugasanpelatihan.export_pdf', ['pelatihan' => $pelatihan, 'identitas' => $identitas]);
        $pdf->setPaper('a4', 'potrait');
        $pdf->setOption("isRemoteEnabled", false);
        $pdf->render();

        return $pdf->download('Data Penugasan Pelatihan ' . date('Y-m-d H:i:s') . '.pdf');
    }



}
