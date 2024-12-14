<?php

namespace App\Http\Controllers;

use App\Models\akunusermodel;
use App\Models\detailpelatihan;
use App\Models\detailsertifikasi;
use App\Models\identitasmodel;
use App\Models\jenispenggunamodel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Dashboard',
            'list' => ['Welcome', 'Dashboard'],
        ];

        $page = (object) [
            'title' => 'Dashboard ',
        ];

        $activeMenu = 'dashboard';

        $user_id = Auth::id();

        // data dashboard superadmin
        $jenispengguna = jenispenggunamodel::count();

        $dosen = identitasmodel::count();

        $akun = akunusermodel::count();

        // data dashboard Admin dan pimpinan

        $jmlSertifikasiAcc = detailsertifikasi::where('status_disetujui', 'iya')->count();
        $jmlSertifikasiBelum = detailsertifikasi::where('status_disetujui', 'tidak')->count();
        $jmlPelatihanAcc = detailpelatihan::where('status_disetujui', 'iya')->count();
        $jmlPelatihanBelum = detailpelatihan::where('status_disetujui', 'tidak')->count();

        // data dashboard dosen

        $sertifikasi = detailsertifikasi::where([
            ['input_by', '=', 'dosen'],
            ['id_user', '=', $user_id],
        ])->count();

        $penugasanSertifikasi = detailsertifikasi::join(
            't_peserta_sertifikasi as ps',
            'ps.id_detail_sertifikasi', '=', 't_detailsertifikasi.id_detail_sertifikasi'
        )->where(
            'ps.id_user', '=', $user_id
        )->count();

        $pelatihan = detailpelatihan::where([
            ['input_by', '=', 'dosen'],
            ['id_user', '=', $user_id],
        ])->count();

        $penugasanPelatihan = detailpelatihan::join(
            't_peserta_pelatihan as ps',
            'ps.id_detail_pelatihan', '=', 't_detailpelatihan.id_detail_pelatihan'
        )->where(
            'ps.id_user', '=', $user_id
        )->count();

        // data pie chart

        $sertifikasiData = detailsertifikasi::where('input_by', 'dosen')->count();
        $pelatihanData = detailpelatihan::where('input_by', 'dosen')->count();

        // Hitung total keseluruhan
        $totalData = $sertifikasiData + $pelatihanData;

        // Hitung persentase masing-masing
        $sertifikasiPercentage = ($totalData > 0) ? ($sertifikasiData / $totalData) * 100 : 0;
        $pelatihanPercentage = ($totalData > 0) ? ($pelatihanData / $totalData) * 100 : 0;

        // Format persentase dengan 2 desimal
        $sertifikasiPercentage = number_format($sertifikasiPercentage, 2);
        $pelatihanPercentage = number_format($pelatihanPercentage, 2);

        $chartData = [
            'sertifikasiData' => (float) $sertifikasiPercentage, // pastikan angka
            'pelatihanData' => (float) $pelatihanPercentage, // pastikan angka
        ];

        // data bar chart
        $bidangMinatTerbanyak = DB::table(DB::raw("(
            SELECT id_bd FROM m_detailbddosen
            UNION ALL
            SELECT id_bd FROM t_tagging_bd_pelatihan
            UNION ALL
            SELECT id_bd FROM t_tagging_bd_sertifikasi
        ) as combined"))
            ->join('m_bidang_minat', 'combined.id_bd', '=', 'm_bidang_minat.id_bd')
            ->select('m_bidang_minat.nama_bd', DB::raw('COUNT(*) as total'))
            ->groupBy('m_bidang_minat.nama_bd')
            ->orderBy('total', 'DESC')
            ->limit(10) // Ambil 10 bidang minat terbanyak
            ->get();

        // DATA BAR CHART
        $startYear = 2022;
        $endYear = now()->year + 2;

        // Mengambil jumlah pelatihan per tahun dari 2022 hingga 2 tahun ke depan
        $jmlPelatihanPerTahun = detailpelatihan::select(
            DB::raw('YEAR(tanggal_mulai) as tahun'),
            DB::raw('COUNT(*) as total_pelatihan')
        )
            ->where('id_user', $user_id)
            ->whereBetween(DB::raw('YEAR(tanggal_mulai)'), [$startYear, $endYear])
            ->groupBy(DB::raw('YEAR(tanggal_mulai)'))
            ->orderBy('tahun', 'ASC')
            ->get();

        // Mengambil jumlah sertifikasi per tahun dari 2022 hingga 2 tahun ke depan
        $jmlSertifikasiPerTahun = detailsertifikasi::select(
            DB::raw('YEAR(tanggal_mulai) as tahun'),
            DB::raw('COUNT(*) as total_sertifikasi')
        )
            ->where('id_user', $user_id)
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

        // returnn view
        return view('dashboard.dashboard', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'jenispengguna' => $jenispengguna,
            'dosen' => $dosen,
            'akun' => $akun,
            'jmlSertifikasiAcc' => $jmlSertifikasiAcc,
            'jmlSertifikasiBelum' => $jmlSertifikasiBelum,
            'jmlPelatihanAcc' => $jmlPelatihanAcc,
            'jmlPelatihanBelum' => $jmlPelatihanBelum,
            'sertifikasi' => $sertifikasi,
            'pelatihan' => $pelatihan,
            'penugasanSertifikasi' => $penugasanSertifikasi,
            'penugasanPelatihan' => $penugasanPelatihan,
            'chartData' => $chartData,
            'bidangMinatTerbanyak' => $bidangMinatTerbanyak,
            'labels' => $labels,
            'pelatihanData' => $pelatihanData,
            'sertifikasiData' => $sertifikasiData
        ]);
    }
}
