<?php

namespace App\Http\Controllers;

use App\Models\detailpelatihan;
use App\Models\pelatihanmodel;
use App\Models\periodemodel;
use App\Models\pesertapelatihanmodel;
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
            'title' => 'Data Penugasan Pelatihan & Sertifikasi ',
            'list' => ['Welcome', 'Pengajuan Pelatihan dan Sertifikasi Pimpinan']
        ];

        $page = (object)[
            'title' => 'Penugasan Pelatihan  & Sertifikasi'
        ];

        $activeMenu = 'pengajuan'; //set menu yang sedang aktif

        $periode = periodemodel::select('id_periode','nama_periode')->get();

        return view('pimpinan.pengajuan.pelatihan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'periode' => $periode]);
    }

    public function list(Request $request)
    {

        $pengajuan = detailpelatihan::join(
            'm_pelatihan as pelatihan',
            'pelatihan.id_pelatihan', '=' , 't_detailpelatihan.id_pelatihan'
        )->join(
            'm_periode as periode',
            'periode.id_periode', '=', 't_detailpelatihan.id_periode'
        )->select(
            'pelatihan.*',
            't_detailpelatihan.*',
            'periode.nama_periode'
        )
        ->where(
            't_detailpelatihan.input_by', '=', 'admin'
        )->get();


        // Return data untuk DataTables
        return DataTables::of($pengajuan)
            ->addIndexColumn() // menambahkan kolom index / nomor urut
            ->addColumn('nama_pelatihan', function ($pengajuan) {
                return $pengajuan->pelatihan->nama_pelatihan ?? '';
            })
            ->addColumn('nama_periode', function ($pengajuan) {
                return $pengajuan->periode->nama_periode ?? '';
            })
            ->addColumn('biaya_format', function ($pengajuan) {
                return 'Rp' . number_format($pengajuan->biaya, 0, ',', '.') ?? ' ';
            })
            ->addColumn('status_disetujui', function ($pengajuan) {
                return $pengajuan->status_disetujui ?? 'Belum Di Balas';
            })
            ->addColumn('aksi', function ($pengajuan) {
                $btn  = '<button onclick="modalAction(\''.url('/pengajuan/pelatihan/' . $pengajuan->id_detail_pelatihan . '/show').'\')" class="btn btn-info btn-sm">Pengajuan</button> '; 

                return $btn;
            })

            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi berisi HTML
            ->make(true);
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

        return view('pimpinan.pengajuan.pelatihan.show', compact('mataKuliah', 'bidangMinat', 'pelatihan', 'peserta'));
    }

    public function showpeserta(Request $request,string $id){

        $pesertapelatihan = pesertapelatihanmodel::select('id_user','id_detail_pelatihan')->with('akun')->where('id_detail_pelatihan','=', $id)->get();

        // Return data untuk DataTables
        return DataTables::of($pesertapelatihan)
        ->addIndexColumn()
        ->addColumn('nama_peserta', function ($pesertapelatihan) {
            return $pesertapelatihan->akun->username ?? '';
        })
        // ->addColumn('nip', function ($pesertapelatihan) {
        //     return $pesertapelatihan->akun->identitas->NIP ?? '';
        // })
        ->make(true);
    }

    public function update(Request $request, string $id)
    {
    
        try {
            // Cari record detail berdasarkan ID
            $detailPelatihan = detailpelatihan::findOrFail($id); // Ganti DetailPelatihan dengan model tabel detail Anda
    
            // Update record dengan input dari form
            $detailPelatihan->update([
                'status_disetujui' => 'iya', // Tetapkan langsung nilai 'iya'
                'updated_at' => now(), // Update waktu terakhir
            ]);


     return response()->json([
            'status' => true,
            'message' => 'Data berhasil diupdate',
        ]);

        return redirect('/');

        } catch (\Exception $e) {
            // Tangani error jika terjadi
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }
    


}
