<?php

namespace App\Http\Controllers;

use App\Models\bidangminatmodel;
use Illuminate\Http\Request;
use App\Models\detailsertifikasi;
use App\Models\jenispelatihansertifikasimodel;
use App\Models\matakuliahmodel;
use App\Models\periodemodel;
use App\Models\sertifikasimodel;
use App\Models\tagbdsertifikasimodel;
use App\Models\tagmksertifikasimodel;
use App\Models\vendorsertifikasimodel;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\support\Facades\Auth;
use PhpOffice\PhpWord\PhpWord;


class detailsertifikasicontroller extends Controller
{
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Detail Sertifikasi',
            'list' => ['Selamat Datang','Detail Sertifikasi']
        ];

        $page = (object)[
            'title' => 'Detail Sertifikasi'
        ];

        $activeMenu = 'detailsertifikasi';

        $periode = periodemodel::select('id_periode','nama_periode')->get();

        return view('admin.pelatihansertifikasi.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'periode' => $periode]);
    }

    public function list(Request $request)
    {
        $detailsertifikasi = detailsertifikasi::select(
                            'id_detail_sertifikasi',
                            'id_sertifikasi',
                            'id_periode',
                            'tanggal_mulai',
                            'tanggal_selesai',
                            'lokasi',
                            'biaya',
                            'status_disetujui',
                        )
        ->with(['sertifikasi', 'periode'])
        ->get();

        if ($request->id_periode_sertifikasi) {
            $detailsertifikasi->where('id_periode', $request->id_periode_sertifikasi);
        }


    // Return data untuk DataTables
    return DataTables::of($detailsertifikasi)
        ->addIndexColumn()
        ->addColumn('nama_sertifikasi', function ($detailsertifikasi) {
            return $detailsertifikasi->sertifikasi->nama_sertifikasi ?? '';
        })
        ->addColumn('nama_periode', function ($detailsertifikasi) {
            return $detailsertifikasi->periode->nama_periode ?? '';
        })
        ->addColumn('biaya_format', function ($detailsertifikasi) {
            return 'Rp' . number_format($detailsertifikasi->biaya, 0, ',', '.') ?? ' ';
        })
        ->addColumn('aksi', function ($detailsertifikasi) {
            $btn = '<button onclick="modalAction(\'' . url('/detailsertifikasi/' . $detailsertifikasi->id_detail_sertifikasi . '/surattugas') . '\')" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i>Surat Tugas</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/detailsertifikasi/' . $detailsertifikasi->id_detail_sertifikasi . '/show') . '\')" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i>Detail</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/detailsertifikasi/' . $detailsertifikasi->id_detail_sertifikasi . '/edit') . '\')" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i>Edit</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/detailsertifikasi/' . $detailsertifikasi->id_detail_sertifikasi . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
            
            return $btn;
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }

    public function create (){

        $sertifikasi = sertifikasimodel::select('id_sertifikasi','nama_sertifikasi')->get(); 

        $periode = periodemodel::select('id_periode','nama_periode')->get();

        // $mk = matakuliahmodel::select('id_mk','nama_mk')->get();

        // $bd = bidangminatmodel::select('id_bd','nama_bd')->get();
        
        return view('admin.pelatihansertifikasi.create', ['sertifikasi' => $sertifikasi, 'periode' => $periode]);
        
    }

    public function store(Request $request) {

        // dd($request->headers);

        $id_mk = [];
        if ($search = $request->nama_mk) {
            $tags = matakuliahmodel::where('nama_mk', 'LIKE', "%$search%")->get();
            // Ambil id_mk dari hasil pencarian
            foreach ($tags as $tag) {
                $id_mk[] = $tag->id_mk; // Menyimpan id_mk ke dalam array
            }
            return response()->json($id_mk); // Kembalikan hasil pencarian dalam format JSON
        }

        // Menyimpan data id_mk yang dikirim dari AJAX
        $id_bd = [];
        if ($search = $request->nama_bd) {
            $tags = matakuliahmodel::where('nama_bd', 'LIKE', "%$search%")->get();
            // Ambil id_bd dari hasil pencarian
            foreach ($tags as $tag) {
                $id_bd[] = $tag->id_bd; // Menyimpan id_bd ke dalam array
            }
            return response()->json($id_bd); // Kembalikan hasil pencarian dalam format JSON
        }

        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_sertifikasi' => 'required',
                'biaya' => 'required|integer', 
                'lokasi' => 'required|max:50', 
                'quota_peserta' => 'required|max:5',
                'id_periode' => 'required', 
                'tanggal_mulai' => 'required|date|after:today',
                'tanggal_selesai' => 'required|date|after:tanggal_mulai', 
                // 'mata_kuliah' => 'required|integer',
                // 'bidang_minat' => 'required|integer',
            ]; 

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors() // pesan error validasi
                ]);
            }

            DB::beginTransaction();

            $detailsertifikasi = detailsertifikasi::create([
                'id_sertifikasi' => $request->id_sertifikasi,
                'id_periode' => $request->id_periode,
                'id_user' => Auth::user()->id_user,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'lokasi' => $request->lokasi,
                'quota_peserta' => $request->quota_peserta,
                'biaya' => $request->biaya,
                'input_by' => $request->input_by,
            ]);

            $idsertifikasiBaru = $request->id_sertifikasi;

            // Menyimpan data ke tabel tagmkpelatihanmodel jika session 'id_mk' ada
            foreach ($request->id_mk as $id_mk) {
                tagmksertifikasimodel::create([
                    'id_sertifikasi' => $idsertifikasiBaru,
                    'id_mk' => $id_mk,
                ]);
            }

            foreach ($request->id_bd as $id_bd) {
                tagbdsertifikasimodel::create([
                    'id_sertifikasi' => $idsertifikasiBaru,
                    'id_bd' => $id_bd,
                ]);
            }

            // Commit transaction jika semua berhasil
            DB::commit();

            if($detailsertifikasi){
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
        DB::rollBack();

        return redirect('/detailsertifikasi');
    }

    // CREATE TAG MK

    public function createmk()
    {
        $mk = matakuliahmodel::all();

        return view('admin.pelatihansertifikasi.create_mk', ['mk' => $mk]);
    }

    public function store_mk(Request $request)
    {

        $selectedMk = $request->input('id_mk');

        if (empty($selectedMk)) {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada mata kuliah yang dipilih.',
            ]);
        }

        $mkData = [];
        foreach ($selectedMk as $id) {
            $matakuliah = matakuliahmodel::find($id);
            if ($matakuliah) {
                $mkData[$id] = $matakuliah->nama_mk;
            }
        }

        session(['id_mk' => $mkData]);
        // session()->flash('showModal', true);

        // Kirimkan response JSON ke frontend
        return response()->json([
            'status' => true,
            'message' => 'Data mata kuliah berhasil disimpan.',
        ]);

    }

    // CREATE TAG BD

    public function createbd()
    {
        $bd = bidangminatmodel::all();

        return view('admin.pelatihansertifikasi.create_bd', ['bd' => $bd]);
    }

    public function store_bd(Request $request)
    {

        $selectedbd = $request->input('id_bd');

        if (empty($selectedbd)) {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada Bidang Minat yang dipilih.',
            ]);
        }

        $bdData = [];
        foreach ($selectedbd as $id) {
            $bidangminat = bidangminatmodel::find($id);
            if ($bidangminat) {
                $bdData[$id] = $bidangminat->nama_bd;
            }
        }

        session(['id_bd' => $bdData]);
        // session()->flash('showModal', true);

        // Kiribdan response JSON ke frontend
        return response()->json([
            'status' => true,
            'message' => 'Data bidang minat berhasil disimpan.',
        ]);
    }

    public function show($id){
        
        $detailsertifikasi = detailsertifikasi::select(
                            'id_detail_sertifikasi',
                            'id_sertifikasi',
                            'id_periode',
                            'tanggal_mulai',
                            'tanggal_selesai',
                            'lokasi',
                            'quota_peserta',
                            'biaya',
                            'no_sertifikasi',
                            'bukti_sertifikasi',
                            'tanggal_kadaluarsa',
                            'status_disetujui',
                            'input_by')
                            ->with('sertifikasi','periode')
                            ->find($id);
        
        $sertifikasi = sertifikasimodel::select(
            'id_sertifikasi',
            'nama_sertifikasi',
            'id_vendor_sertifikasi',
            'id_jenis_pelatihan_sertifikasi',
            'level_sertifikasi'
            )->with('jenissertifikasi','vendorsertifikasi');

        $periode = periodemodel::select('id_periode','nama_periode');

        $mataKuliah = DB::table('t_tagging_mk_sertifikasi as tagmk')
        ->join('m_mata_kuliah as mk', 'tagmk.id_mk', '=', 'mk.id_mk')
        ->where('tagmk.id_sertifikasi', '=', $detailsertifikasi->id_sertifikasi)
        ->pluck('mk.nama_mk')
        ->toArray(); 


    // Ambil mata kuliah terkait
        $bidangMinat = DB::table('t_tagging_bd_sertifikasi as tagbd')
        ->join('m_bidang_minat as bd', 'tagbd.id_bd', '=', 'bd.id_bd')
        ->where('tagbd.id_sertifikasi', '=', $detailsertifikasi->id_sertifikasi)
        ->pluck('bd.nama_bd')
        ->toArray();            

        return view('admin.pelatihansertifikasi.show', ['detailsertifikasi' => $detailsertifikasi, 'sertifikasi' => $sertifikasi, 'periode' => $periode, 'mataKuliah' => $mataKuliah, 'bidangMinat' => $bidangMinat]);
    }

    public function confirm($id){

        $detailsertifikasi = detailsertifikasi::select(
            'id_detail_sertifikasi',
            'id_sertifikasi',
            'id_periode',
            'tanggal_mulai',
            'tanggal_selesai',
            'lokasi',
            'quota_peserta',
            'biaya',
            'no_sertifikasi',
            'bukti_sertifikasi',
            'tanggal_kadaluarsa',
            'status_disetujui',
            'input_by')
            ->with('sertifikasi','periode')
            ->find($id);

        $sertifikasi = sertifikasimodel::select('id_sertifikasi', 'nama_sertifikasi')->get();
        
        return view('admin.pelatihansertifikasi.delete', ['detailsertifikasi' => $detailsertifikasi,'sertifikasi' => $sertifikasi]);
        
    } 

    public function delete(Request $request, $id)
    {

        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $detailsertifikasi = detailsertifikasi::find($id);
            if ($detailsertifikasi) {
                $detailsertifikasi->delete();
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
        return redirect('/detailsertifikasi');

    }

    public function edit(string $id){
        $detailsertifikasi = detailsertifikasi::select(
                            'id_detail_sertifikasi',
                            'id_sertifikasi',
                            'id_periode',
                            'tanggal_mulai',
                            'tanggal_selesai',
                            'lokasi',
                            'quota_peserta',
                            'biaya',
                            'no_sertifikasi',
                            'bukti_sertifikasi',
                            'tanggal_kadaluarsa',
                            'status_disetujui',
                            'input_by')
                            ->with('sertifikasi','periode')
                            ->find($id);
        
                $sertifikasi = sertifikasimodel::select(
                    'id_sertifikasi',
                    'nama_sertifikasi',
                    'id_vendor_sertifikasi',
                    'id_jenis_pelatihan_sertifikasi',
                    'level_sertifikasi'
                    )->with('jenissertifikasi','vendorsertifikasi')->get();

                $jenis = jenispelatihansertifikasimodel::select('id_jenis_pelatihan_sertifikasi','nama_jenis_sertifikasi')->get();

                $vendor = vendorsertifikasimodel::select('id_vendor_sertifikasi','nama_vendor_sertifikasi')->get();

                $periode = periodemodel::select('id_periode','nama_periode')->get();

                $mataKuliah = DB::table('t_tagging_mk_sertifikasi as tagmk')
                ->join('m_mata_kuliah as mk', 'tagmk.id_mk', '=', 'mk.id_mk')
                ->where('tagmk.id_sertifikasi', '=', $detailsertifikasi->id_sertifikasi)
                ->select('mk.*')
                ->get()
                ->toArray();


            // Ambil mata kuliah terkait
                $bidangMinat = DB::table('t_tagging_bd_sertifikasi as tagbd')
                ->join('m_bidang_minat as bd', 'tagbd.id_bd', '=', 'bd.id_bd')
                ->where('tagbd.id_sertifikasi', '=', $detailsertifikasi->id_sertifikasi)
                ->select('bd.*')
                ->get()
                ->toArray();           

                return view('admin.pelatihansertifikasi.edit', ['detailsertifikasi' => $detailsertifikasi, 'sertifikasi' => $sertifikasi, 'periode' => $periode, 'mataKuliah' => $mataKuliah, 'bidangMinat' => $bidangMinat, 'vendor' => $vendor, 'jenis' => $jenis]);             
    }

    public function edit_mk(string $id_detail)
    {

        // Ambil id_sertifikasi berdasarkan id_detail_sertifikasi
        $id_sertifikasi = DB::table('t_detailsertifikasi')
            ->where('id_detail_sertifikasi', '=', $id_detail)
            ->value('id_sertifikasi');

        // Ambil mata kuliah terkait
        $mataKuliah = DB::table('t_tagging_mk_sertifikasi as tagmk')
            ->join('m_mata_kuliah as mk', 'tagmk.id_mk', '=', 'mk.id_mk')
            ->where('tagmk.id_sertifikasi', '=', $id_sertifikasi)
            ->pluck('mk.nama_mk')
            ->toArray();

        $mk = matakuliahmodel::all();

        return view('admin.pelatihansertifikasi.edit_mk', compact('mataKuliah', 'mk', 'id_detail'));

    }

    public function update_mk(Request $request)
    {
        $selectedMk = $request->input('id_mk');

        if (empty($selectedMk)) {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada mata kuliah yang dipilih.',
            ]);
        }

        $mkData = [];
        foreach ($selectedMk as $id) {
            $matakuliah = matakuliahmodel::find($id);
            if ($matakuliah) {
                $mkData[$id] = $matakuliah->nama_mk;
            }
        }

        session(['id_mk' => $mkData]);
        // session()->flash('showModal', true);

        // Kirimkan response JSON ke frontend
        return response()->json([
            'status' => true,
            'message' => 'Data mata kuliah berhasil disimpan.',
        ]);
    }

    public function edit_bd(string $id_detail)
    {

        // Ambil id_sertifikasi berdasarkan id_detail_sertifikasi
        $id_sertifikasi = DB::table('t_detailsertifikasi')
            ->where('id_detail_sertifikasi', '=', $id_detail)
            ->value('id_sertifikasi');

        // Ambil mata kuliah terkait
        $bidangMinat = DB::table('t_tagging_bd_sertifikasi as tagbd')
            ->join('m_bidang_minat as bd', 'tagbd.id_bd', '=', 'bd.id_bd')
            ->where('tagbd.id_sertifikasi', '=', $id_sertifikasi)
            ->pluck('bd.nama_bd')
            ->toArray();

        $bd = bidangminatmodel::all();

        return view('admin.pelatihansertifikasi.edit_bd', compact('bidangMinat', 'bd', 'id_detail'));

    }

    public function update_bd(Request $request)
    {

        $selectedbd = $request->input('id_bd');

        if (empty($selectedbd)) {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada mata kuliah yang dipilih.',
            ]);
        }

        $bdData = [];
        foreach ($selectedbd as $id) {
            $bidangminat = bidangminatmodel::find($id);
            if ($bidangminat) {
                $bdData[$id] = $bidangminat->nama_bd;
            }
        }

        session(['id_bd' => $bdData]);
        // session()->flash('showModal', true);

        // Kiribdan response JSON ke frontend
        return response()->json([
            'status' => true,
            'message' => 'Data bidang minat berhasil disimpan.',
        ]);

    }

    public function update(Request $request, $id){

        // Menyimpan data id_mk yang dikirim dari AJAX
        $id_mk = [];
        if ($search = $request->nama_mk) {
            $tags = matakuliahmodel::where('nama_mk', 'LIKE', "%$search%")->get();
            // Ambil id_mk dari hasil pencarian
            foreach ($tags as $tag) {
                $id_mk[] = $tag->id_mk; // Menyimpan id_mk ke dalam array
            }
            return response()->json($id_mk); // Kembalikan hasil pencarian dalam format JSON
        }

        // Menyimpan data id_mk yang dikirim dari AJAX
        $id_bd = [];
        if ($search = $request->nama_bd) {
            $tags = matakuliahmodel::where('nama_bd', 'LIKE', "%$search%")->get();
            // Ambil id_bd dari hasil pencarian
            foreach ($tags as $tag) {
                $id_bd[] = $tag->id_bd; // Menyimpan id_bd ke dalam array
            }
            return response()->json($id_bd); // Kembalikan hasil pencarian dalam format JSON
        }

        $rules = [
            'id_sertifikasi' => 'required',
            'id_periode' => 'required|exists:m_periode,id_periode', // Validasi periode
            'tanggal_mulai' => 'required|date', // Validasi tanggal mulai
            'tanggal_selesai' => 'required|date', // Validasi tanggal selesai
            'lokasi' => 'required|string|max:50', // Validasi lokasi
            'biaya' => 'required|integer', // Validasi biaya
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false, // response status, false: error/gagal, true: berhasil
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors(), // pesan error validasi
            ]);
        }

        $detailsertifikasi = detailsertifikasi::find($id);

        if ($detailsertifikasi) {
            $detailsertifikasi->update([ // Perbarui data
                'detailsertifikasi' => $request->id_sertifikasi,
                'id_periode' => $request->id_periode,
                'id_user' => auth()->id(),
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
                'lokasi' => $request->lokasi,
                'biaya' => $request->biaya,
                'no_sertifikasi' => $request->no_sertifikasi,
                'input_by' => $request->input_by, // Menyimpan nilai 'input_by' berdasarkan role
            ]);
        }

        if (session()->has('id_mk')) {
            // Hapus data lama terkait id_mk di tagmksertifikasimodel
            tagmksertifikasimodel::where('id_sertifikasi', $detailsertifikasi->id_sertifikasi)->delete();

            // Menyimpan data baru ke tabel tagmksertifikasimodel
            foreach ($request->id_mk as $id_mk) {
                tagmksertifikasimodel::create([
                    'id_sertifikasi' => $detailsertifikasi->id_sertifikasi,
                    'id_mk' => $id_mk,
                ]);
            }
        }

        // Proses update untuk id_bd (selalu update)
        if ($request->has('id_bd')) {
            // Hapus data lama terkait id_bd di tagbdsertifikasimodel
            tagbdsertifikasimodel::where('id_sertifikasi', $detailsertifikasi->id_sertifikasi)->delete();

            // Menyimpan data baru ke tabel tagbdsertifikasimodel
            foreach ($request->id_bd as $id_bd) {
                tagbdsertifikasimodel::create([
                    'id_sertifikasi' => $detailsertifikasi->id_sertifikasi,
                    'id_bd' => $id_bd,
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diupdate',
        ]);

        return redirect('/detailsertifikasi');

    }

    public function excel()
    {

        //ambil data yang akan di export
        $detailsertifikasi = detailsertifikasi::select(
                            'id_sertifikasi',
                            'id_periode',
                            'id_user',
                            'tanggal_mulai',
                            'tanggal_selesai',
                            'lokasi',
                            'quota_peserta',
                            'biaya',
                            'input_by')
                            ->get();

        //load library
        $detailsertifikasi = new Spreadsheet();
        $sheet = $detailsertifikasi->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'ID Sertifikasi');
        $sheet->setCellValue('C1', 'ID Periode');
        $sheet->setCellValue('D1', 'ID User');
        $sheet->setCellValue('E1', 'Tanggal Mulai');
        $sheet->setCellValue('F1', 'Tanggal Selesai');
        $sheet->setCellValue('G1', 'Lokasi');
        $sheet->setCellValue('H1', 'Quota Peserta');
        $sheet->setCellValue('I1', 'Biaya');
        $sheet->setCellValue('J1', 'Input');

        $sheet->getStyle('A1:J1')->getFont()->setBold(true); //bold header

        $no = 1;
        $baris = 2;
        foreach ($detailsertifikasi as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->id_sertifikasi);
            $sheet->setCellValue('C' . $baris, $value->id_periode);
            $sheet->setCellValue('D' . $baris, $value->id_user);
            $sheet->setCellValue('E' . $baris, $value->tanggal_mulai);
            $sheet->setCellValue('F' . $baris, $value->tanggal_selesai);
            $sheet->setCellValue('G' . $baris, $value->lokasi);
            $sheet->setCellValue('H' . $baris, $value->biaya);
            $sheet->setCellValue('I' . $baris, $value->input_by);
            $baris++;
            $no++;

        }

        foreach (range('A', 'I') as $columID) {
            $sheet->getColumnDimension($columID)->setAutoSize(true); //set auto size kolom
        }

        $sheet->setTitle('Data Detail Sertifikasi');
        $writer = IOFactory::createWriter($detailsertifikasi, 'Xlsx');
        $filename = 'Data Deyail Sertifikasi' . date('Y-m-d H:i:s') . '.xlsx';
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

    public function pdf()
    {
        //ambil data yang akan di export
        $detailsertifikasi = detailsertifikasi::select(
            'id_sertifikasi',
            'id_periode',
            'id_user',
            'tanggal_mulai',
            'tanggal_selesai',
            'lokasi',
            'quota_peserta',
            'biaya',
            'input_by')
            ->get();

     //use Barruvdh\DomPDF\Facade\\Pdf
    $pdf = Pdf::loadView('admin.pelatihansertifikasi.export', ['detailsertifikasi'=>$detailsertifikasi]);
    $pdf->setPaper('a4', 'potrait');
    $pdf->setOption("isRemoteEnabled", false);
    $pdf->render();

    return $pdf->download('Data Akun Pengguna '.date('Y-m-d H:i:s').'.pdf');
    }
}