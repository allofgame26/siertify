<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\detailpelatihan;
use App\Models\akunusermodel;
use App\Models\bidangminatmodel;
use App\Models\matakuliahmodel;
use App\Models\periodemodel;
use App\Models\pelatihanmodel;
use App\Models\tagbdpelatihanmodel;
use App\Models\tagmkpelatihanmodel;
use App\Models\vendorpelatihanmodel;
use App\Models\jenispelatihansertifikasimodel;
use App\Models\pesertapelatihanmodel;
use App\Models\pesertasertifikasimodel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\support\Facades\Auth;
use PhpOffice\PhpWord\PhpWord;

class detailpelatihancontroller extends Controller
{
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Detail Pelatihan',
            'list' => ['Selamat Datang','Detail Pelatihan']
        ];

        $page = (object)[
            'title' => 'Detail Pelatihan'
        ];

        $activeMenu = 'detailsertifikasi';

        $user = akunusermodel::select('id_user','username')->get();

        return view('admin.detailsertifikasi.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'user' => $user]);
    }

    public function list(Request $request)
    {
        $detailpelatihan = detailpelatihan::select(
                            'id_detail_pelatihan',
                            'id_pelatihan',
                            'id_periode',
                            'tanggal_mulai',
                            'tanggal_selesai',
                            'lokasi',
                            'biaya',
                            'status_disetujui',
                        )
        ->with(['pelatihan', 'periode'])
        ->get();

        if ($request->id_periode) {
            $detailpelatihan->where('id_periode', $request->id_periode);
        }


    // Return data untuk DataTables
    return DataTables::of($detailpelatihan)
        ->addIndexColumn()
        ->addColumn('nama_pelatihan', function ($detailpelatihan) {
            return $detailpelatihan->pelatihan->nama_pelatihan ?? '';
        })
        ->addColumn('nama_periode', function ($detailpelatihan) {
            return $detailpelatihan->periode->nama_periode ?? '';
        })
        ->addColumn('biaya_format', function ($detailpelatihan) {
            return 'Rp' . number_format($detailpelatihan->biaya, 0, ',', '.') ?? ' ';
        })
        ->addColumn('aksi', function ($detailpelatihan) {
            $btn = '<button onclick="modalAction(\'' . url('/detailpelatihan/' . $detailpelatihan->id_detail_pelatihan . '/show') . '\')" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i>Detail</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/detailpelatihan/' . $detailpelatihan->id_detail_pelatihan . '/edit') . '\')" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i>Edit</button> ';
            $btn .= '<button onclick="modalAction(\'' . url('/detailpelatihan/' . $detailpelatihan->id_detail_pelatihan . '/confirm') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
            
            return $btn;
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }

    public function create (){

        $pelatihan = pelatihanmodel::select('id_pelatihan','nama_pelatihan')->get(); 

        $periode = periodemodel::select('id_periode','nama_periode')->get();

        // $mk = matakuliahmodel::select('id_mk','nama_mk')->get();

        // $bd = bidangminatmodel::select('id_bd','nama_bd')->get();
        
        return view('admin.detailpelatihan.create', ['pelatihan' => $pelatihan, 'periode' => $periode]);
        
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
            'id_pelatihan' => 'required',
            'biaya' => 'required|integer', 
            'lokasi' => 'required|max:50', 
            'quota_peserta' => 'required|max:5',
            'id_periode' => 'required', 
            'tanggal_mulai' => 'required|date|after:today',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai', 
            // 'mata_kuliah' => 'required|integer',
            // 'bidang_minat' => 'required|integer',
        ];
        
        $validatedData = $request->validate([
            'id_pelatihan' => 'required|integer',
            'quota_peserta' => 'required|integer|min:1',
            'id_mk' => 'required|array',
            'id_mk.*' => 'integer',
            'id_bd' => 'required|array',
            'id_bd.*' => 'integer',
            'biaya' => 'required|numeric',
            'lokasi' => 'required|string|max:255',
            'id_periode' => 'required|integer',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors() // pesan error validasi
                ]);
            }

            DB::beginTransaction();


            $idDetailPelatihan = DB::table('t_detailpelatihan')->insertGetId([
                'id_pelatihan' => $validatedData['id_pelatihan'],
                'biaya' => $validatedData['biaya'],
                'id_user' => Auth::user()->id_user,
                'quota_peserta' => $request->quota_peserta,
                'lokasi' => $validatedData['lokasi'],
                'id_periode' => $validatedData['id_periode'],
                'tanggal_mulai' => $validatedData['tanggal_mulai'],
                'tanggal_selesai' => $validatedData['tanggal_selesai'],
                'input_by' => $request->input_by,
                'status_disetujui' => $request->status_disetujui,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Query untuk mencari dosen yang relevan berdasarkan mata kuliah dan bidang minat
            $dosenQuery = DB::table('m_akun_user as akun')
                ->join('m_detailmkdosen as tagmk', 'akun.id_user', '=', 'tagmk.id_user')
                ->join('m_detailbddosen as tagbd', 'akun.id_user', '=', 'tagbd.id_user')
                ->whereIn('tagmk.id_mk', $validatedData['id_mk'])
                ->whereIn('tagbd.id_bd', $validatedData['id_bd'])
                ->select('akun.id_user', 'akun.username', DB::raw('COUNT(*) as pelatihan_count'))
                ->groupBy('akun.id_user', 'akun.username')
                ->orderBy('pelatihan_count', 'asc')
                ->limit($validatedData['quota_peserta'])
                ->get();

            // Tambahkan data ke tabel t_peserta_sertifikasi
            $pesertaData = [];
            foreach ($dosenQuery as $dosen) {
                $pesertaData[] = [
                    'id_detail_pelatihan' => $idDetailPelatihan,
                    'id_user' => $dosen->id_user,
                ];
            }

            pesertapelatihanmodel::insert($pesertaData);

            $idpelatihanBaru = $request->id_pelatihan;

            // Menyimpan data ke tabel tagmkpelatihanmodel jika session 'id_mk' ada
            foreach ($request->id_mk as $id_mk) {
                tagmkpelatihanmodel::create([
                    'id_pelatihan' => $idpelatihanBaru,
                    'id_mk' => $id_mk,
                ]);
            }

            foreach ($request->id_bd as $id_bd) {
                tagbdpelatihanmodel::create([
                    'id_pelatihan' => $idpelatihanBaru,
                    'id_bd' => $id_bd,
                ]);
            }

            // Commit transaction jika semua berhasil
            DB::commit();

            if($idDetailPelatihan){
                return response()->json([
                    'status'    => true,
                    'message'   => 'Data berhasil disimpan'
                ], 200);
            }


            return response()->json([
                'status' => true,
                'message' => 'Data berhasil disimpan'
            ]);
        }
        DB::rollBack();

        return redirect('/detailpelatihan');
    }

    // CREATE TAG MK

    public function createmk()
    {
        $mk = matakuliahmodel::all();

        return view('admin.detailpelatihan.create_mk', ['mk' => $mk]);
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

        return view('admin.detailpelatihan.create_bd', ['bd' => $bd]);
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
        
        $detailpelatihan = detailpelatihan::select(
                            'id_detail_pelatihan',
                            'id_pelatihan',
                            'id_periode',
                            'tanggal_mulai',
                            'tanggal_selesai',
                            'lokasi',
                            'quota_peserta',
                            'biaya',
                            'status_disetujui',
                            'input_by')
                            ->with('pelatihan','periode')
                            ->find($id);
        
        $pelatihan = pelatihanmodel::select(
            'id_pelatihan',
            'nama_pelatihan',
            'id_vendor_pelatihan',
            'id_jenis_pelatihan_sertifikasi',
            'level_pelatihan'
            )->with('jenispelatihan','vendorpelatihan');

        $periode = periodemodel::select('id_periode','nama_periode');

        $mataKuliah = DB::table('t_tagging_mk_pelatihan as tagmk')
        ->join('m_mata_kuliah as mk', 'tagmk.id_mk', '=', 'mk.id_mk')
        ->where('tagmk.id_pelatihan', '=', $detailpelatihan->id_pelatihan)
        ->pluck('mk.nama_mk')
        ->toArray(); 


    // Ambil mata kuliah terkait
        $bidangMinat = DB::table('t_tagging_bd_pelatihan as tagbd')
        ->join('m_bidang_minat as bd', 'tagbd.id_bd', '=', 'bd.id_bd')
        ->where('tagbd.id_pelatihan', '=', $detailpelatihan->id_pelatihan)
        ->pluck('bd.nama_bd')
        ->toArray();

        return view('admin.detailpelatihan.show', ['detailpelatihan' => $detailpelatihan, 'pelatihan' => $pelatihan, 'periode' => $periode, 'mataKuliah' => $mataKuliah, 'bidangMinat' => $bidangMinat,]);
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

    public function confirm($id){

        $detailpelatihan = detailpelatihan::select(
            'id_detail_pelatihan',
            'id_pelatihan',
            'id_periode',
            'tanggal_mulai',
            'tanggal_selesai',
            'lokasi',
            'quota_peserta',
            'biaya',
            'status_disetujui',
            'input_by')
            ->with('pelatihan','periode')
            ->find($id);

        $pelatihan = pelatihanmodel::select('id_pelatihan', 'nama_pelatihan')->get();
        
        return view('admin.detailpelatihan.delete', ['detailpelatihan' => $detailpelatihan,'pelatihan' => $pelatihan]);
        
    } 

    public function delete(Request $request, $id)
    {

        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $detailpelatihan = detailpelatihan::find($id);
            if ($detailpelatihan) {
                $detailpelatihan->delete();
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
        return redirect('/detailpelatihan');

    }

    public function edit(string $id){
        $detailpelatihan = detailpelatihan::select(
                            'id_detail_pelatihan',
                            'id_pelatihan',
                            'id_periode',
                            'tanggal_mulai',
                            'tanggal_selesai',
                            'lokasi',
                            'quota_peserta',
                            'biaya',
                            'status_disetujui',
                            'input_by')
                            ->with('pelatihan','periode')
                            ->find($id);
        
                $pelatihan = pelatihanmodel::select(
                    'id_pelatihan',
                    'nama_pelatihan',
                    'id_vendor_pelatihan',
                    'id_jenis_pelatihan_sertifikasi',
                    'level_pelatihan'
                    )->with('jenispelatihan','vendorpelatihan')->get();

                $jenis = jenispelatihansertifikasimodel::select('id_jenis_pelatihan_sertifikasi','nama_jenis_sertifikasi')->get();

                $vendor = vendorpelatihanmodel::select('id_vendor_pelatihan','nama_vendor_pelatihan')->get();

                $periode = periodemodel::select('id_periode','nama_periode')->get();

                $mataKuliah = DB::table('t_tagging_mk_pelatihan as tagmk')
                ->join('m_mata_kuliah as mk', 'tagmk.id_mk', '=', 'mk.id_mk')
                ->where('tagmk.id_pelatihan', '=', $detailpelatihan->id_pelatihan)
                ->select('mk.*')
                ->get()
                ->toArray();


            // Ambil mata kuliah terkait
                $bidangMinat = DB::table('t_tagging_bd_pelatihan as tagbd')
                ->join('m_bidang_minat as bd', 'tagbd.id_bd', '=', 'bd.id_bd')
                ->where('tagbd.id_pelatihan', '=', $detailpelatihan->id_pelatihan)
                ->select('bd.*')
                ->get()
                ->toArray();           

                return view('admin.detailpelatihan.edit', ['detailpelatihan' => $detailpelatihan, 'pelatihan' => $pelatihan, 'periode' => $periode, 'mataKuliah' => $mataKuliah, 'bidangMinat' => $bidangMinat, 'vendor' => $vendor, 'jenis' => $jenis]);             
    }

    public function edit_mk(string $id_detail)
    {

        // Ambil id_pelatihan berdasarkan id_detail_pelatihan
        $id_pelatihan = DB::table('t_detailpelatihan')
            ->where('id_detail_pelatihan', '=', $id_detail)
            ->value('id_pelatihan');

        // Ambil mata kuliah terkait
        $mataKuliah = DB::table('t_tagging_mk_pelatihan as tagmk')
            ->join('m_mata_kuliah as mk', 'tagmk.id_mk', '=', 'mk.id_mk')
            ->where('tagmk.id_pelatihan', '=', $id_pelatihan)
            ->pluck('mk.nama_mk')
            ->toArray();

        $mk = matakuliahmodel::all();

        return view('admin.detailpelatihan.edit_mk', compact('mataKuliah', 'mk', 'id_detail'));

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

        // Ambil id_pelatihan berdasarkan id_detail_pelatihan
        $id_pelatihan = DB::table('t_detailpelatihan')
            ->where('id_detail_pelatihan', '=', $id_detail)
            ->value('id_pelatihan');

        // Ambil mata kuliah terkait
        $bidangMinat = DB::table('t_tagging_bd_pelatihan as tagbd')
            ->join('m_bidang_minat as bd', 'tagbd.id_bd', '=', 'bd.id_bd')
            ->where('tagbd.id_pelatihan', '=', $id_pelatihan)
            ->pluck('bd.nama_bd')
            ->toArray();

        $bd = bidangminatmodel::all();

        return view('admin.detailpelatihan.edit_bd', compact('bidangMinat', 'bd', 'id_detail'));

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
            'id_pelatihan' => 'required',
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

        $detailpelatihan = detailpelatihan::find($id);

        if ($detailpelatihan) {
            $detailpelatihan->update([ // Perbarui data
                'id_pelatihan' => $request->id_pelatihan,
                'id_periode' => $request->id_periode,
                'id_user' => auth()->id(),
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'lokasi' => $request->lokasi,
                'biaya' => $request->biaya,
                'input_by' => $request->input_by, // Menyimpan nilai 'input_by' berdasarkan role
            ]);
        }

        if (session()->has('id_mk')) {
            // Hapus data lama terkait id_mk di tagmkpelatihanmodel
            tagmkpelatihanmodel::where('id_pelatihan', $detailpelatihan->id_pelatihan)->delete();

            // Menyimpan data baru ke tabel tagmkpelatihanmodel
            foreach ($request->id_mk as $id_mk) {
                tagmkpelatihanmodel::create([
                    'id_pelatihan' => $detailpelatihan->id_pelatihan,
                    'id_mk' => $id_mk,
                ]);
            }
        }

        // Proses update untuk id_bd (selalu update)
        if ($request->has('id_bd')) {
            // Hapus data lama terkait id_bd di tagbdpelatihanmodel
            tagbdpelatihanmodel::where('id_pelatihan', $detailpelatihan->id_pelatihan)->delete();

            // Menyimpan data baru ke tabel tagbdpelatihanmodel
            foreach ($request->id_bd as $id_bd) {
                tagbdpelatihanmodel::create([
                    'id_pelatihan' => $detailpelatihan->id_pelatihan,
                    'id_bd' => $id_bd,
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diupdate',
        ]);

        return redirect('/detailpelatihan');

    }

    public function excel()
    {

        //ambil data yang akan di export
        $detailpelatihan = detailpelatihan::select(
                            'id_pelatihan',
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
        $detailpelatihan = new Spreadsheet();
        $sheet = $detailpelatihan->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'ID pelatihan');
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
        foreach ($detailpelatihan as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->id_pelatihan);
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

        $sheet->setTitle('Data Detail pelatihan');
        $writer = IOFactory::createWriter($detailpelatihan, 'Xlsx');
        $filename = 'Data Deyail pelatihan' . date('Y-m-d H:i:s') . '.xlsx';
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
        $detailpelatihan = detailpelatihan::select(
            'id_pelatihan',
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
    $pdf = Pdf::loadView('admin.detailpelatihan.export', ['detailpelatihan'=>$detailpelatihan]);
    $pdf->setPaper('a4', 'potrait');
    $pdf->setOption("isRemoteEnabled", false);
    $pdf->render();

    return $pdf->download('Data Akun Pengguna '.date('Y-m-d H:i:s').'.pdf');
    }
}
