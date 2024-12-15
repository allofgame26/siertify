<?php

namespace App\Http\Controllers;

use App\Models\akunusermodel;
use App\Models\bidangminatmodel;
use App\Models\detailpelatihan;
use App\Models\detailsertifikasi;
use App\Models\matakuliahmodel;
use App\Models\pelatihanmodel;
use App\Models\periodemodel;
use App\Models\sertifikasimodel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Yajra\DataTables\Facades\DataTables;

class StatistikController extends Controller
{

    public function index()
    {

        $breadcrumb = (object) [
            'title' => 'Statistik Dosen',
            'list' => ['Welcome', 'Statistik Dosen'],
        ];

        $page = (object) [
            'title' => 'Statistik Dosen ',
        ];

        $activeMenu = 'statistik';

        // DATA BAR CHART
        $startYear = 2022;
        $endYear = now()->year + 2;

        // Mengambil jumlah pelatihan per tahun dari 2022 hingga 2 tahun ke depan
        $jmlPelatihanPerTahun = detailpelatihan::select(
            DB::raw('YEAR(tanggal_mulai) as tahun'),
            DB::raw('COUNT(*) as total_pelatihan')
        )
            ->whereBetween(DB::raw('YEAR(tanggal_mulai)'), [$startYear, $endYear])
            ->groupBy(DB::raw('YEAR(tanggal_mulai)'))
            ->orderBy('tahun', 'ASC')
            ->get();

        // Mengambil jumlah sertifikasi per tahun dari 2022 hingga 2 tahun ke depan
        $jmlSertifikasiPerTahun = detailsertifikasi::select(
            DB::raw('YEAR(tanggal_mulai) as tahun'),
            DB::raw('COUNT(*) as total_sertifikasi')
        )
            ->whereBetween(DB::raw('YEAR(tanggal_mulai)'), [$startYear, $endYear])
            ->groupBy(DB::raw('YEAR(tanggal_mulai)'))
            ->orderBy('tahun', 'ASC')
            ->get();

        // Proses data untuk chart
        $dataChart = [];
        for ($year = $startYear; $year <= $endYear; $year++) {
            $dataChart[$year] = [
                'pelatihan' => $jmlPelatihanPerTahun->where('tahun', $year)->first()->total_pelatihan ?? 0,
                'sertifikasi' => $jmlSertifikasiPerTahun->where('tahun', $year)->first()->total_sertifikasi ?? 0,
            ];
        }

        // Buat format untuk chart.js
        $labels = array_keys($dataChart);
        $pelatihanData = array_column($dataChart, 'pelatihan');
        $sertifikasiData = array_column($dataChart, 'sertifikasi');

        // DATA FILTER
        $periode = periodemodel::all();
        $bidangMinat = bidangminatmodel::all();
        $mataKuliah = matakuliahmodel::all();

        return view('statistik.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'labels' => $labels,
            'pelatihanData' => $pelatihanData,
            'sertifikasiData' => $sertifikasiData,
            'periode' => $periode,
            'bidangMinat' => $bidangMinat,
            'mataKuliah' => $mataKuliah,
        ]);
    }

    public function list(Request $request)
    {

        // Ambil data dengan cara yang sama
        $data = DB::table('m_identitas_diri as diri')
            ->join('m_akun_user as users', 'users.id_identitas', '=', 'diri.id_identitas')
            ->leftJoin('t_detailpelatihan as detail', 'detail.id_user', '=', 'users.id_user')
            ->leftJoin('m_pelatihan as pelatihan', 'pelatihan.id_pelatihan', '=', 'detail.id_pelatihan')
            ->leftJoin('m_periode as periode', 'periode.id_periode', '=', 'users.id_periode')
            ->leftJoin('t_detailsertifikasi as sertifikasi', 'sertifikasi.id_user', '=', 'users.id_user')
            ->select(
                'diri.nama_lengkap',
                'periode.nama_periode',
                'users.id_user',
                'periode.id_periode',
                DB::raw('COUNT(DISTINCT detail.id_pelatihan) as jumlah_pelatihan'),
                DB::raw('COUNT(DISTINCT sertifikasi.id_sertifikasi) as jumlah_sertifikasi')
            )
            ->where('users.id_jenis_pengguna', '=', '3')
            ->groupBy('diri.nama_lengkap', 'periode.nama_periode', 'users.id_user', 'periode.id_periode')
            ->orderByDesc('jumlah_pelatihan')
            ->orderByDesc('jumlah_sertifikasi');

        // Apply filter berdasarkan id_periode jika ada
        if ($request->id_periode) {
            // Filter menggunakan nama kolom yang benar
            $data->where('periode.id_periode', $request->id_periode);
        }

        $data = $data->get();

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('aksi', function ($statistik) {
                // Gunakan concatenation di PHP untuk membangun URL
                $url = url('/statistik/pelatihan/' . $statistik->id_user . '/detail');
                // Gunakan anchor tag dengan URL yang dibangun
                $btn = '<a href="' . url('/statistik/pelatihan/' . $statistik->id_user . '/detail/' . $statistik->id_periode) . '">
            <button class="btn btn-info btn-sm">Detail</button>
         </a>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);

    }

    // detail

    public function show(string $id)
    {

        $user = akunusermodel::join(
            'm_identitas_diri as id',
            'id.id_identitas', '=', 'm_akun_user.id_identitas'
        )->join(
            'm_jenis_pengguna as j',
            'j.id_jenis_pengguna', '=', 'm_akun_user.id_jenis_pengguna'
        )->join(
            'm_periode as periode',
            'periode.id_periode', '=', 'm_akun_user.id_periode'
        )->select(
            'id.*',
            'j.*',
            'm_akun_user.id_user',
            'periode.id_periode'
        )
            ->where(
                'm_akun_user.id_user', '=', $id
            )->first();

        // Ambil mata kuliah terkait
        $bidangMinat = DB::table('m_detailbddosen  as tagbd')
            ->join('m_bidang_minat as bd', 'tagbd.id_bd', '=', 'bd.id_bd')
            ->where('tagbd.id_user', '=', $id)
            ->pluck('bd.nama_bd')
            ->toArray();

        $mataKuliah = DB::table('m_detailmkdosen  as tagmk')
            ->join('m_mata_kuliah as mk', 'tagmk.id_mk', '=', 'mk.id_mk')
            ->where('tagmk.id_user', '=', $id)
            ->pluck('mk.nama_mk')
            ->toArray();

        $breadcrumb = (object) [
            'title' => $user->nama_lengkap,
            'list' => ['Welcome', 'Statistik Dosen'],
        ];

        $page = (object) [
            'title' => 'Statistik Dosen ',
        ];

        $activeMenu = 'statistik';

        $jmlPelatihan = detailpelatihan::where([
            ['input_by', '=', 'dosen'],
            ['id_user', '=', $id],
        ])->count();

        $jmlSertifikasi = detailsertifikasi::where([
            ['input_by', '=', 'dosen'],
            ['id_user', '=', $id],
        ])->count();

        return view('statistik.show',
            compact(
                'user',
                'bidangMinat',
                'mataKuliah',
                'activeMenu',
                'page',
                'breadcrumb',
                'jmlPelatihan',
                'jmlSertifikasi'));

    }

    public function showList(Request $request, string $id, string $id_periode)
    {

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
                'm_pelatihan.id_pelatihan',
                'm_pelatihan.nama_pelatihan',
                'jenis.nama_jenis_sertifikasi',
                'vendor.nama_vendor_pelatihan',
                'm_pelatihan.level_pelatihan',
                'periode.nama_periode',
                'detail.*'
            )
            ->where(
                [
                    ['detail.id_user', '=', $id],
                    ['detail.id_periode', '=', $id_periode],
                ])
            ->get();

        return DataTables::of($pelatihan)
            ->addIndexColumn()
            ->addColumn('aksi', function ($statistik) {
                $btn = '<button onclick="modalAction(\'' . url('/statistik/pelatihan/' . $statistik->id_detail_pelatihan . '/detailpelatihan') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);

    }

    public function showList2(Request $request, string $id, string $id_periode)
    {

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
                'm_sertifikasi.id_sertifikasi',
                'm_sertifikasi.nama_sertifikasi',
                'jenis.nama_jenis_sertifikasi',
                'vendor.nama_vendor_sertifikasi',
                'm_sertifikasi.level_sertifikasi',
                'periode.nama_periode',
                'detail.*'
            )
            ->where(
                [
                    ['detail.id_user', '=', $id],
                    ['detail.id_periode', '=', $id_periode],
                ])
            ->get();

        return DataTables::of($sertifikasi)
            ->addIndexColumn()
            ->addColumn('aksi', function ($statistik) {
                $btn = '<button onclick="modalAction(\'' . url('/statistik/sertifikasi/' . $statistik->id_detail_sertifikasi . '/detailsertifikasi') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);

    }

    public function detailPelatihan(string $id)
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
                'm_pelatihan.id_pelatihan',
                'm_pelatihan.nama_pelatihan',
                'jenis.nama_jenis_sertifikasi',
                'vendor.nama_vendor_pelatihan',
                'm_pelatihan.level_pelatihan',
                'periode.nama_periode',
                'detail.*'
            )
            ->where('detail.id_detail_pelatihan', '=', $id)
            ->distinct()
            ->first();

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

        return view('statistik.showPelatihan', compact('mataKuliah', 'bidangMinat', 'pelatihan'));
    }

    public function detailSertifikasi(string $id)
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
                'm_sertifikasi.id_sertifikasi',
                'm_sertifikasi.nama_sertifikasi',
                'jenis.nama_jenis_sertifikasi',
                'vendor.nama_vendor_sertifikasi',
                'm_sertifikasi.level_sertifikasi',
                'periode.nama_periode',
                'detail.*'
            )
            ->where('detail.id_detail_sertifikasi', '=', $id)
            ->distinct()
            ->first();

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

        return view('statistik.showSertifikasi', compact('mataKuliah', 'bidangMinat', 'sertifikasi'));
    }

    public function export_excel()
    {

        $data = DB::table('m_identitas_diri as diri')
            ->join('m_akun_user as users', 'users.id_identitas', '=', 'diri.id_identitas')
            ->leftJoin('t_detailpelatihan as detail', 'detail.id_user', '=', 'users.id_user')
            ->leftJoin('m_pelatihan as pelatihan', 'pelatihan.id_pelatihan', '=', 'detail.id_pelatihan')
            ->leftJoin('m_periode as periode', 'periode.id_periode', '=', 'users.id_periode')
            ->leftJoin('t_detailsertifikasi as sertifikasi', 'sertifikasi.id_user', '=', 'users.id_user')
            ->select(
                'diri.nama_lengkap',
                'periode.nama_periode',
                'users.id_user',
                'periode.id_periode',
                DB::raw('COUNT(DISTINCT detail.id_pelatihan) as jumlah_pelatihan'),
                DB::raw('COUNT(DISTINCT sertifikasi.id_sertifikasi) as jumlah_sertifikasi')
            )
            ->where('users.id_jenis_pengguna', '=', '3')
            ->groupBy('diri.nama_lengkap', 'periode.nama_periode', 'users.id_user', 'periode.id_periode')
            ->orderByDesc('jumlah_pelatihan')
            ->orderByDesc('jumlah_sertifikasi')
            ->get();

        //load library
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nama Dosen');
        $sheet->setCellValue('C1', 'Periode');
        $sheet->setCellValue('D1', 'Jumlah Pelatihan');
        $sheet->setCellValue('E1', 'Jumlah Sertifikasi');

        $sheet->getStyle('A1:E1')->getFont()->setBold(true); //bold header

        $no = 1;
        $baris = 2;
        foreach ($data as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->nama_lengkap);
            $sheet->setCellValue('C' . $baris, $value->nama_periode);
            $sheet->setCellValue('D' . $baris, $value->jumlah_pelatihan);
            $sheet->setCellValue('E' . $baris, $value->jumlah_sertifikasi);
            $baris++;
            $no++;

        }

        foreach (range('A', 'E') as $columID) {
            $sheet->getColumnDimension($columID)->setAutoSize(true); //set auto size kolom
        }

        $sheet->setTitle('Data Statistik Dosen');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Statistik Dosen' . date('Y-m-d H:i:s') . '.xlsx';
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

        $data = DB::table('m_identitas_diri as diri')
            ->join('m_akun_user as users', 'users.id_identitas', '=', 'diri.id_identitas')
            ->leftJoin('t_detailpelatihan as detail', 'detail.id_user', '=', 'users.id_user')
            ->leftJoin('m_pelatihan as pelatihan', 'pelatihan.id_pelatihan', '=', 'detail.id_pelatihan')
            ->leftJoin('m_periode as periode', 'periode.id_periode', '=', 'users.id_periode')
            ->leftJoin('t_detailsertifikasi as sertifikasi', 'sertifikasi.id_user', '=', 'users.id_user')
            ->select(
                'diri.nama_lengkap',
                'periode.nama_periode',
                'users.id_user',
                'periode.id_periode',
                DB::raw('COUNT(DISTINCT detail.id_pelatihan) as jumlah_pelatihan'),
                DB::raw('COUNT(DISTINCT sertifikasi.id_sertifikasi) as jumlah_sertifikasi')
            )
            ->where('users.id_jenis_pengguna', '=', '3')
            ->groupBy('diri.nama_lengkap', 'periode.nama_periode', 'users.id_user', 'periode.id_periode')
            ->orderByDesc('jumlah_pelatihan')
            ->orderByDesc('jumlah_sertifikasi')
            ->get();

        //use Barruvdh\DomPDF\Facade\\Pdf
        $pdf = Pdf::loadView('statistik.export_pdf', ['data' => $data]);
        $pdf->setPaper('a4', 'potrait');
        $pdf->setOption("isRemoteEnabled", false);
        $pdf->render();

        return $pdf->download('Data Statistik Dosen ' . date('Y-m-d H:i:s') . '.pdf');
    }

}
