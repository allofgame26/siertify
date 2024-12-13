<?php

namespace App\Http\Controllers;

use App\Models\akunusermodel;
use App\Models\detailsertifikasi;
use App\Models\jenispelatihansertifikasimodel;
use App\Models\periodemodel;
use App\Models\sertifikasimodel;
use App\Models\vendorsertifikasimodel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Yajra\DataTables\Facades\DataTables;

class PenugasanSertifikasiController extends Controller
{
    public function index()
    {
        $activeMenu = 'penugasan';
        $breadcrumb = (object) [
            'title' => 'Data Penugasan Pelatihan dan Sertifikasi',
            'list' => ['Home', 'Pelatihan dan Sertifikasi'],
        ];
        $page = (object) [
            'title' => 'Penugasan Sertifikasi',
        ];

        $sertifikasi = sertifikasimodel::all();
        $jenisPelatihan = jenispelatihansertifikasimodel::all();
        $vendorSertifikasi = vendorsertifikasimodel::all();
        $detail = detailsertifikasi::all();
        $periode = periodemodel::all();

        return view('dosen.penugasanpelatihan.index', [
            'activeMenu' => $activeMenu,
            'breadcrumb' => $breadcrumb,
            'sertifikasi' => $sertifikasi,
            'jenisPelatihan' => $jenisPelatihan,
            'vendor' => $vendorSertifikasi,
            'detail' => $detail,
            'periode' => $periode,
            'page' => $page,
        ]);
    }

    public function list(Request $request)
    {
        $user_id = Auth::user()->id_user; // Ambil ID user yang login

        $sertifikasi = detailsertifikasi::join(
            'm_sertifikasi as sertifikasi',
            'sertifikasi.id_sertifikasi', '=', 't_detailsertifikasi.id_sertifikasi'
        )->join(
            'm_vendor_sertifikasi as vendor',
            'sertifikasi.id_vendor_sertifikasi', '=', 'vendor.id_vendor_sertifikasi'
        )->join(
            'm_jenis_pelatihan_sertifikasi as j',
            'j.id_jenis_pelatihan_sertifikasi', '=', 'sertifikasi.id_jenis_pelatihan_sertifikasi'
        )->join(
            'm_periode as periode',
            'periode.id_periode', '=', 't_detailsertifikasi.id_periode'
        )->join(
            't_peserta_sertifikasi as p',
            'p.id_detail_sertifikasi', '=', 't_detailsertifikasi.id_detail_sertifikasi'
        )->select(
            'sertifikasi.*',
            'vendor.*',
            'j.*',
            'periode.*',
            't_detailsertifikasi.*',
            'p.*'
        )->where(
            'p.id_user', '=', $user_id
        )->orderBy('t_detailsertifikasi.tanggal_mulai'); // Tambahkan get() untuk mengeksekusi query

        // Apply filter berdasarkan id_periode jika ada
        if ($request->id_periode_sertifikasi) {
            $sertifikasi->where('t_detailsertifikasi.id_periode', $request->id_periode_sertifikasi);
        }

        // Ambil data setelah semua filter diterapkan
        $sertifikasi = $sertifikasi->get();

        return DataTables::of($sertifikasi)
            ->addIndexColumn()
            ->addColumn('aksi', function ($penugasan) {
                $btn = '<button onclick="modalAction(\'' . url('/penugasan/sertifikasi/' . $penugasan->id_detail_sertifikasi . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/penugasan/sertifikasi/' . $penugasan->id_detail_sertifikasi . '/create') . '\')" class="btn btn-success btn-sm"><i class="fas fa-plus-square"
                                style="margin-right: 8px;"></i>Riwayat</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);

    }

    public function show(string $id)
    {
        // Ambil data sertifikasi
        $sertifikasi = detailsertifikasi::join(
            'm_sertifikasi as sertifikasi',
            'sertifikasi.id_sertifikasi', '=', 't_detailsertifikasi.id_sertifikasi'
        )->join(
            'm_vendor_sertifikasi as vendor',
            'sertifikasi.id_vendor_sertifikasi', '=', 'vendor.id_vendor_sertifikasi'
        )->join(
            'm_jenis_pelatihan_sertifikasi as j',
            'j.id_jenis_pelatihan_sertifikasi', '=', 'sertifikasi.id_jenis_pelatihan_sertifikasi'
        )->join(
            'm_periode as periode',
            'periode.id_periode', '=', 't_detailsertifikasi.id_periode'
        )->join(
            't_peserta_sertifikasi as p',
            'p.id_detail_sertifikasi', '=', 't_detailsertifikasi.id_detail_sertifikasi'
        )->select(
            'sertifikasi.*',
            'vendor.*',
            'j.*',
            'periode.*',
            't_detailsertifikasi.*',
            'p.*'
        )->where(
            't_detailsertifikasi.id_detail_sertifikasi', '=', $id
        )->first();

        // Ambil mata kuliah terkait
        $mataKuliah = DB::table('t_tagging_mk_sertifikasi as tagmk')
            ->join('m_mata_kuliah as mk', 'tagmk.id_mk', '=', 'mk.id_mk')
            ->where('tagmk.id_sertifikasi', '=', $sertifikasi->id_sertifikasi)
            ->get();

        $mataKuliah = $mataKuliah->pluck('nama_mk')->toArray();

        // Ambil mata kuliah terkait
        $bidangMinat = DB::table('t_tagging_bd_sertifikasi as tagbd')
            ->join('m_bidang_minat as bd', 'tagbd.id_bd', '=', 'bd.id_bd')
            ->where('tagbd.id_sertifikasi', '=', $sertifikasi->id_sertifikasi)
            ->pluck('bd.nama_bd')
            ->toArray();

        $peserta = detailsertifikasi::join(
            't_peserta_sertifikasi as p',
            'p.id_detail_sertifikasi', '=', 't_detailsertifikasi.id_detail_sertifikasi'
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
            't_detailsertifikasi.id_detail_sertifikasi', '=', $id
        )->get();

        return view('dosen.penugasansertifikasi.show', compact('mataKuliah', 'bidangMinat', 'sertifikasi', 'peserta'));
    }

    public function surat_tugas(Request $request, string $id)
    {

        // Cari data detail sertifikasi berdasarkan ID
        $detailsertifikasi = detailsertifikasi::find($id);

        // Periksa apakah data ditemukan
        if (!$detailsertifikasi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Detail sertifikasi tidak ditemukan.',
            ], 404);
        }

        // Periksa apakah kolom surat tugas null
        if (is_null($detailsertifikasi->surat_tugas)) {
            return response()->json([
                'status' => 'processing',
                'message' => 'Surat tugas masih dalam proses. Silakan tunggu.',
            ], 200);
        }

        // Path surat tugas di folder public/suratTugas
        $filePath = public_path('suratTugas/' . $detailsertifikasi->surat_tugas);

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

        // Ambil data sertifikasi
        $sertifikasi = sertifikasimodel::join(
            'm_jenis_pelatihan_sertifikasi as jenis',
            'm_sertifikasi.id_jenis_pelatihan_sertifikasi', '=', 'jenis.id_jenis_pelatihan_sertifikasi'
        )
            ->join(
                'm_vendor_sertifikasi as vendor',
                'm_sertifikasi.id_vendor_sertifikasi', '=', 'vendor.id_vendor_sertifikasi'
            )
            ->join(
                't_detailsertifikasi as detail',
                'm_sertifikasi.id_sertifikasi', '=', 'detail.id_sertifikasi'
            )
            ->join(
                'm_periode as periode',
                'detail.id_periode', '=', 'periode.id_periode'
            )
            ->select(
                'm_sertifikasi.*',
                'jenis.*',
                'vendor.*',
                'periode.*',
                'detail.*'
            )
            ->where('detail.id_detail_sertifikasi', '=', $id)
            ->distinct()
            ->first();

        // Ambil mata kuliah terkait
        $mataKuliah = DB::table('t_tagging_mk_sertifikasi as tagmk')
            ->join('m_mata_kuliah as mk', 'tagmk.id_mk', '=', 'mk.id_mk')
            ->where('tagmk.id_sertifikasi', '=', $sertifikasi->id_sertifikasi)
            ->select('mk.*')
            ->get()
            ->toArray();

        // Ambil mata kuliah terkait
        $bidangMinat = DB::table('t_tagging_bd_sertifikasi as tagbd')
            ->join('m_bidang_minat as bd', 'tagbd.id_bd', '=', 'bd.id_bd')
            ->where('tagbd.id_sertifikasi', '=', $sertifikasi->id_sertifikasi)
            ->select('bd.*')
            ->get()
            ->toArray();

        $jenisPelatihan = jenispelatihansertifikasimodel::all();
        $vendorSertifikasi = vendorsertifikasimodel::all();
        $periode = periodemodel::all(); // Tetap diambil untuk kebutuhan lain

        return view('dosen.penugasansertifikasi.create', compact('mataKuliah', 'bidangMinat', 'sertifikasi', 'jenisPelatihan', 'vendorSertifikasi', 'periode'));

    }

    public function store(Request $request, string $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            // Validasi input
            $rules = [
                'tanggal_kadaluarsa' => 'required|date',
                'no_sertifikasi' => 'required|string|max:20', // Validasi nomor sertifikasi
                'bukti_sertifikasi' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240', // Validasi bukti sertifikasi (maks 10MB)
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors(), // pesan error validasi
                ]);
            }

            $dataDetail = detailsertifikasi::find($id); // Temukan data berdasarkan ID

            // Setelah validasi berhasil, simpan data ke database
            $sertifikasi = detailsertifikasi::create([
                'id_sertifikasi' => $dataDetail->id_sertifikasi,
                'id_periode' => $dataDetail->id_periode,
                'id_user' => auth()->id(),
                'tanggal_mulai' => $dataDetail->tanggal_mulai,
                'tanggal_selesai' => $dataDetail->tanggal_selesai,
                'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
                'lokasi' => $dataDetail->lokasi,
                'biaya' => $dataDetail->biaya,
                'no_sertifikasi' => $request->no_sertifikasi,
                'bukti_sertifikasi' => '', // Menyimpan nama file bukti sertifikasi jika ada
                'input_by' => $request->input_by, // Menyimpan nilai 'input_by' berdasarkan role
            ]);

            // Menangani file bukti sertifikasi jika ada
            if ($request->hasFile('bukti_sertifikasi')) {

                if ($request->hasFile('bukti_sertifikasi')) {
                    // Mengambil ID pengguna yang sedang login
                    $userId = Auth::user()->id_user;

                    // Menghitung jumlah bukti sertifikasi yang sudah diupload oleh pengguna tersebut
                    $buktiCount = detailsertifikasi::where('id_user', $userId)->count();

                    // Menentukan nama file
                    $fileName = 'bukti_' . $userId . '_' . ($buktiCount + 1) . '.' . $request->bukti_sertifikasi->getClientOriginalExtension();

                    // Menyimpan file ke storage public/buktisertifikat
                    $request->bukti_sertifikasi->move(public_path('buktiSertifikasi'), $fileName);

                    // Update user dengan nama file avatar baru
                    $sertifikasi->bukti_sertifikasi = $fileName;
                    $sertifikasi->save(); // Simpan perubahan ke database

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

    public function export_excel()
    {

        $user_id = Auth::user()->id_user; // Ambil ID user yang login

        $sertifikasi = detailsertifikasi::join(
            'm_sertifikasi as sertifikasi',
            'sertifikasi.id_sertifikasi', '=', 't_detailsertifikasi.id_sertifikasi'
        )->join(
            'm_vendor_sertifikasi as vendor',
            'sertifikasi.id_vendor_sertifikasi', '=', 'vendor.id_vendor_sertifikasi'
        )->join(
            'm_jenis_pelatihan_sertifikasi as j',
            'j.id_jenis_pelatihan_sertifikasi', '=', 'sertifikasi.id_jenis_pelatihan_sertifikasi'
        )->join(
            'm_periode as periode',
            'periode.id_periode', '=', 't_detailsertifikasi.id_periode'
        )->join(
            't_peserta_sertifikasi as p',
            'p.id_detail_sertifikasi', '=', 't_detailsertifikasi.id_detail_sertifikasi'
        )->select(
            'sertifikasi.*',
            'vendor.*',
            'j.*',
            'periode.*',
            't_detailsertifikasi.*',
            'p.*'
        )->where(
            'p.id_user', '=', $user_id
        )->orderBy('t_detailsertifikasi.id_detail_sertifikasi')
            ->get(); // Tambahkan get() untuk mengeksekusi query

        //load library
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Periode');
        $sheet->setCellValue('C1', 'Nama Sertifikasi');
        $sheet->setCellValue('D1', 'Nama Vendor');
        $sheet->setCellValue('E1', 'Level');
        $sheet->setCellValue('F1', 'Tanggal Pelaksanaan');
        $sheet->setCellValue('G1', 'Lokasi');

        $sheet->getStyle('A1:G1')->getFont()->setBold(true); //bold header

        $no = 1;
        $baris = 2;
        foreach ($sertifikasi as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->nama_periode);
            $sheet->setCellValue('C' . $baris, $value->nama_sertifikasi);
            $sheet->setCellValue('D' . $baris, $value->nama_vendor_sertifikasi);
            $sheet->setCellValue('E' . $baris, $value->level_sertifikasi);
            $sheet->setCellValue('F' . $baris, $value->tanggal_mulai);
            $sheet->setCellValue('G' . $baris, $value->lokasi);
            $baris++;
            $no++;

        }

        foreach (range('A', 'G') as $columID) {
            $sheet->getColumnDimension($columID)->setAutoSize(true); //set auto size kolom
        }

        $sheet->setTitle('Data Penugasan Sertifikasi');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Penugasan Sertifikasi' . date('Y-m-d H:i:s') . '.xlsx';
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

        $sertifikasi = detailsertifikasi::join(
            'm_sertifikasi as sertifikasi',
            'sertifikasi.id_sertifikasi', '=', 't_detailsertifikasi.id_sertifikasi'
        )->join(
            'm_vendor_sertifikasi as vendor',
            'sertifikasi.id_vendor_sertifikasi', '=', 'vendor.id_vendor_sertifikasi'
        )->join(
            'm_jenis_pelatihan_sertifikasi as j',
            'j.id_jenis_pelatihan_sertifikasi', '=', 'sertifikasi.id_jenis_pelatihan_sertifikasi'
        )->join(
            'm_periode as periode',
            'periode.id_periode', '=', 't_detailsertifikasi.id_periode'
        )->join(
            't_peserta_sertifikasi as p',
            'p.id_detail_sertifikasi', '=', 't_detailsertifikasi.id_detail_sertifikasi'
        )->select(
            'sertifikasi.*',
            'vendor.*',
            'j.*',
            'periode.*',
            't_detailsertifikasi.*',
            'p.*'
        )->where(
            'p.id_user', '=', $user_id
        )->orderBy('t_detailsertifikasi.id_detail_sertifikasi')
            ->get(); // Tambahkan get() untuk mengeksekusi query

        $identitas = akunusermodel::join(
            'm_identitas_diri as d',
            'd.id_identitas', '=', 'm_akun_user.id_identitas'
        )
            ->where(
                'm_akun_user.id_user', '=', $user_id
            )->first();

        //use Barruvdh\DomPDF\Facade\\Pdf
        $pdf = Pdf::loadView('dosen.penugasansertifikasi.export_pdf', ['sertifikasi' => $sertifikasi, 'identitas' => $identitas]);
        $pdf->setPaper('a4', 'potrait');
        $pdf->setOption("isRemoteEnabled", false);
        $pdf->render();

        return $pdf->download('Data Penugasan Sertifikasi ' . date('Y-m-d H:i:s') . '.pdf');
    }

}
