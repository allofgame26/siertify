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
            'title' => 'Data Penawaran Pelatihan & Sertifikasi ',
            'list' => ['Welcome', 'Pengajuan Pelatihan dan Sertifikasi Pimpinan']
        ];

        $page = (object)[
            'title' => 'Penawaran Pelatihan  & Sertifikasi'
        ];

        $activeMenu = 'pengajuan'; //set menu yang sedang aktif

        $periode = periodemodel::select('id_periode','nama_periode')->get();

        return view('pimpinan.pengajuan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'periode' => $periode]);
    }

    public function list(Request $request)
    {
        $pengajuan = detailpelatihan::select(
            'id_detail_pelatihan',
            'id_pelatihan',
            'id_periode',
            'id_user',
            'tanggal_mulai',
            'tanggal_selesai',
            'lokasi',
            'quota_peserta',
            'biaya',
            'no_pelatihan',
            'status_disetujui',
            'input_by',
            'surat_tugas')
            ->with('pelatihan','periode')->get();


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
                $btn  = '<button onclick="modalAction(\''.url('/pengajuan/' . $pengajuan->id_detail_pelatihan . '/show').'\')" class="btn btn-info btn-sm">Pengajuan</button> '; 

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

     public function show(string $id) {
        // Cari barang berdasarkan id
        $pengajuan = detailpelatihan::select(
            'id_detail_pelatihan',
            'id_pelatihan',
            'id_periode',
            'id_user',
            'tanggal_mulai',
            'tanggal_selesai',
            'lokasi',
            'quota_peserta',
            'biaya',
            'no_pelatihan',
            'status_disetujui',
            'input_by',
            'surat_tugas')
            ->with('pelatihan','periode')->find($id);
    
            $pelatihan = pelatihanmodel::select(
                'id_pelatihan',
                'nama_pelatihan',
                'id_vendor_pelatihan',
                'id_jenis_pelatihan_sertifikasi',
                'level_pelatihan'
                )->with('jenispelatihan','vendorpelatihan');
    
            $periode = periodemodel::select('id_periode','nama_periode');
    
            $mataKuliah = DB::table('t_tagging_mk_sertifikasi as tagmk')
            ->join('m_mata_kuliah as mk', 'tagmk.id_mk', '=', 'mk.id_mk')
            ->where('tagmk.id_sertifikasi', '=', $pengajuan->id_pelatihan)
            ->pluck('mk.nama_mk')
            ->toArray(); 
    
    
        // Ambil mata kuliah terkait
            $bidangMinat = DB::table('t_tagging_bd_sertifikasi as tagbd')
            ->join('m_bidang_minat as bd', 'tagbd.id_bd', '=', 'bd.id_bd')
            ->where('tagbd.id_sertifikasi', '=', $pengajuan->id_pelatihan)
            ->pluck('bd.nama_bd')
            ->toArray(); 
        // Periksa apakah barang ditemukan
        if ($pengajuan) {
            // Tampilkan halaman show_ajax dengan data barang
            return view('pimpinan.pengajuan.show', ['pengajuan' => $pengajuan, 'pelatihan' => $pelatihan, 'periode' => $periode , 'mataKuliah' => $mataKuliah, 'bidangMinat' => $bidangMinat]);
        } else {
            // Tampilkan pesan kesalahan jika barang tidak ditemukan
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }
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
}
