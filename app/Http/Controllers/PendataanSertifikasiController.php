<?php

namespace App\Http\Controllers;

use App\Models\akunusermodel;
use App\Models\bidangminatmodel;
use App\Models\detailsertifikasi;
use App\Models\jenispelatihansertifikasimodel;
use App\Models\matakuliahmodel;
use App\Models\periodemodel;
use App\Models\sertifikasimodel;
use App\Models\tagbdsertifikasimodel;
use App\Models\tagmksertifikasimodel;
use App\Models\vendorsertifikasimodel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Yajra\DataTables\Facades\DataTables;

class PendataanSertifikasiController extends Controller
{

    public function index()
    {

        session()->forget('id_mk');
        session()->forget('id_bd');

        $activeMenu = 'pendataan';
        $breadcrumb = (object) [
            'title' => 'Data Pelatihan dan Sertifikasi',
            'list' => ['Home', 'Pelatihan dan Sertifikasi'],
        ];
        $page = (object) [
            'title' => 'Pendataan Riwayat Sertifikasi',
        ];

        $sertifikasi = sertifikasimodel::all();
        $jenisPelatihan = jenispelatihansertifikasimodel::all();
        $vendorSertifikasi = vendorsertifikasimodel::all();
        $detail = detailsertifikasi::all();
        $periode = periodemodel::all();

        return view('dosen.pendataanpelatihan.index', [
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

    // MENAMPILKAN DATATABLES DI INDEX
    public function list(Request $request)
    {
        $user_id = Auth::user()->id_user; // Ambil ID user yang login

        $sertifikasi = sertifikasimodel::join(
            'm_vendor_sertifikasi as vendor',
            'm_sertifikasi.id_vendor_sertifikasi', '=', 'vendor.id_vendor_sertifikasi'
        )->join(
            't_detailsertifikasi as detail', 'm_sertifikasi.id_sertifikasi', '=', 'detail.id_sertifikasi'
        )->join(
            'm_jenis_pelatihan_sertifikasi as j',
            'j.id_jenis_pelatihan_sertifikasi', '=', 'm_sertifikasi.id_jenis_pelatihan_sertifikasi'
        )
            ->join(
                'm_periode as periode', 'periode.id_periode', '=', 'detail.id_periode' // Perbaiki join untuk periode
            )->select(
            'm_sertifikasi.id_sertifikasi',
            'm_sertifikasi.nama_sertifikasi',
            'vendor.nama_vendor_sertifikasi',
            'm_sertifikasi.level_sertifikasi',
            'j.nama_jenis_sertifikasi',
            'periode.nama_periode',
            'detail.tanggal_mulai',
            'detail.id_detail_sertifikasi' // Ambil nama periode
        )->where(
            'detail.id_user', '=', $user_id
        ); // Tambahkan get() untuk mengeksekusi query

        // Apply filter berdasarkan id_periode jika ada
        if ($request->id_periode_sertifikasi) {
            $sertifikasi->where('detail.id_periode', $request->id_periode_sertifikasi);
        }

        // Ambil data setelah semua filter diterapkan
        $sertifikasi = $sertifikasi->get();

        return DataTables::of($sertifikasi)
            ->addIndexColumn()
            ->addColumn('aksi', function ($pendataan) {
                $btn = '<button onclick="modalAction(\'' . url('/pendataan/sertifikasi/' . $pendataan->id_detail_sertifikasi . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/pendataan/sertifikasi/' . $pendataan->id_detail_sertifikasi . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/pendataan/sertifikasi/' . $pendataan->id_detail_sertifikasi . '/delete') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);

    }

    // CREATE DARI DROPDOWN ADMIN
    public function create()
    {
        // Mengambil data pelatihan lengkap dengan join ke tabel terkait
        $sertifikasi = sertifikasimodel::join(
            'm_jenis_pelatihan_sertifikasi as jenis',
            'm_sertifikasi.id_jenis_pelatihan_sertifikasi', '=', 'jenis.id_jenis_pelatihan_sertifikasi'
        )
            ->join(
                'm_vendor_sertifikasi as vendor',
                'm_sertifikasi.id_vendor_sertifikasi', '=', 'vendor.id_vendor_sertifikasi'
            )
            ->select(
                'm_sertifikasi.id_sertifikasi',
                'm_sertifikasi.nama_sertifikasi',
                'jenis.nama_jenis_sertifikasi',
                'vendor.nama_vendor_sertifikasi',
                'm_sertifikasi.level_sertifikasi'
            )
            ->get();

        $periode = periodemodel::all(); // Tetap diambil untuk kebutuhan lain

        return view('dosen.pendataansertifikasi.create', compact('sertifikasi', 'periode'));
    }

    public function store(Request $request)
    {

        if ($request->ajax() || $request->wantsJson()) {
            // Validasi input
            $rules = [
                'id_sertifikasi' => 'required|integer|exists:m_sertifikasi,id_sertifikasi', // Validasi sertifikasi
                'id_periode' => 'required|integer|exists:m_periode,id_periode', // Validasi periode
                'tanggal_mulai' => 'required|date', // Validasi tanggal mulai
                'tanggal_selesai' => 'required|date', // Validasi tanggal selesai
                'tanggal_kadaluarsa' => 'required|date',
                'lokasi' => 'required|string|max:50', // Validasi lokasi
                'biaya' => 'required|integer', // Validasi biaya
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

            // Setelah validasi berhasil, simpan data ke database
            $sertifikasi = detailsertifikasi::create([
                'id_sertifikasi' => $request->id_sertifikasi,
                'id_periode' => $request->id_periode,
                'id_user' => auth()->id(),
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
                'lokasi' => $request->lokasi,
                'biaya' => $request->biaya,
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

                    // Menyimpan file ke storage public/buktiSertifikasi
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

    // //////////////////////////////////////////////////////////////////////////////////////////

    // CREATE PELATIHAN BARU

    public function create_new()
    {
        $jenisPelatihan = jenispelatihansertifikasimodel::all();
        $vendorSertifikasi = vendorsertifikasimodel::all();
        $periode = periodemodel::all(); // Tetap diambil untuk kebutuhan lain

        return view('dosen.pendataansertifikasi.create_new', compact('jenisPelatihan', 'vendorSertifikasi', 'periode'));
    }

    public function store_new(Request $request)
    {
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

        // Validasi input
        $rules = [
            'nama_sertifikasi' => 'required|string|max:100',
            'id_vendor_sertifikasi' => 'required|integer|exists:m_vendor_sertifikasi,id_vendor_sertifikasi',
            'level_sertifikasi' => 'required',
            'id_jenis_pelatihan_sertifikasi' => 'required|exists:m_jenis_pelatihan_sertifikasi,id_jenis_pelatihan_sertifikasi',
            'id_periode' => 'required|exists:m_periode,id_periode', // Validasi periode
            'tanggal_mulai' => 'required|date', // Validasi tanggal mulai
            'tanggal_selesai' => 'required|date', // Validasi tanggal selesai
            'tanggal_kadaluarsa' => 'required|date',
            'lokasi' => 'required|string|max:50', // Validasi lokasi
            'biaya' => 'required|integer', // Validasi biaya
            'no_sertifikasi' => 'required|string|max:20', // Validasi nomor sertifikasi
            'bukti_sertifikasi' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240', // Validasi bukti sertifikasi (maks 10MB)
            // 'id_mk' => 'required|array', // Validasi array id_mk
            // 'id_mk.*' => 'exists:m_mata_kuliah,id_mk',
            // 'id_bd' => 'required|array', // Validasi array id_bd
            // 'id_bd.*' => 'exists|m_bidang_minat,id_bd'

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false, // response status, false: error/gagal, true: berhasil
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors(), // pesan error validasi
            ]);
        }

        try {
            // Gunakan DB transaction untuk memastikan atomicity
            DB::beginTransaction();

            // Menyimpan data pelatihan
            $sertifikasi = sertifikasimodel::create([
                'id_jenis_pelatihan_sertifikasi' => $request->id_jenis_pelatihan_sertifikasi,
                'id_vendor_sertifikasi' => $request->id_vendor_sertifikasi,
                'nama_sertifikasi' => $request->nama_sertifikasi,
                'level_sertifikasi' => $request->level_sertifikasi,
            ]);

            // Mendapatkan id_pelatihan
            $idSertifikasiBaru = $sertifikasi->id_sertifikasi;

            // Menyimpan data detail pelatihan
            $detailSertifikasi = detailsertifikasi::create([
                'id_sertifikasi' => $idSertifikasiBaru,
                'id_periode' => $request->id_periode,
                'id_user' => auth()->id(),
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'tanggal_kadaluarsa' => $request->tanggal_kadaluarsa,
                'lokasi' => $request->lokasi,
                'biaya' => $request->biaya,
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

                    // Menyimpan file ke storage public/buktiSertifikasi
                    $request->bukti_sertifikasi->move(public_path('buktiSertifikasi'), $fileName);

                    // Update user dengan nama file avatar baru
                    $detailSertifikasi->bukti_sertifikasi = $fileName;
                    $detailSertifikasi->save(); // Simpan perubahan ke database

                }
            }

            // Menyimpan data ke tabel tagmkpelatihanmodel jika session 'id_mk' ada
            foreach ($request->id_mk as $id_mk) {
                tagmksertifikasimodel::create([
                    'id_sertifikasi' => $idSertifikasiBaru,
                    'id_mk' => $id_mk,
                ]);
            }

            foreach ($request->id_bd as $id_bd) {
                tagbdsertifikasimodel::create([
                    'id_sertifikasi' => $idSertifikasiBaru,
                    'id_bd' => $id_bd,
                ]);
            }

            // Commit transaction jika semua berhasil
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Data pelatihan dan detail berhasil disimpan.',
                'id_pelatihan' => $idSertifikasiBaru,
            ]);

        } catch (\Exception $e) {
            // Rollback jika ada error
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage(),
            ]);
        }

        // Mengembalikan respon jika bukan AJAX atau JSON
        return redirect('/');
    }

    // /////////////////////////////////////////////////////////////////////////////////////////////////////////

    // CREATE TAG MK

    public function createmk()
    {
        $mk = matakuliahmodel::all();

        return view('dosen.pendataansertifikasi.create_mk', ['mk' => $mk]);
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

        return view('dosen.pendataansertifikasi.create_bd', ['bd' => $bd]);
    }

    public function store_bd(Request $request)
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

    /// //////////////////////////////////////////////////////////////////////////////////////////////

    // EDIT DATA
    public function edit(string $id)
    {

        // Ambil data pelatihan
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

        return view('dosen.pendataansertifikasi.edit', compact('mataKuliah', 'bidangMinat', 'sertifikasi', 'jenisPelatihan', 'vendorSertifikasi', 'periode'));

    }

    public function update(Request $request, $id)
    {

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

        // Validasi input
        $rules = [
            'nama_sertifikasi' => 'required|string|max:100',
            'id_vendor_sertifikasi' => 'required|integer|exists:m_vendor_sertifikasi,id_vendor_sertifikasi',
            'level_sertifikasi' => 'required',
            'id_jenis_pelatihan_sertifikasi' => 'required|exists:m_jenis_pelatihan_sertifikasi,id_jenis_pelatihan_sertifikasi',
            'id_periode' => 'required|exists:m_periode,id_periode', // Validasi periode
            'tanggal_mulai' => 'required|date', // Validasi tanggal mulai
            'tanggal_selesai' => 'required|date', // Validasi tanggal selesai
            'tanggal_kadaluarsa' => 'required|date',
            'lokasi' => 'required|string|max:50', // Validasi lokasi
            'biaya' => 'required|integer', // Validasi biaya
            'no_sertifikasi' => 'required|string|max:20', // Validasi nomor sertifikasi
            'bukti_sertifikasi' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240', // Validasi bukti sertifikasi (maks 10MB)
            // 'id_mk' => 'required|array', // Validasi array id_mk
            // 'id_mk.*' => 'exists:m_mata_kuliah,id_mk',
            // 'id_bd' => 'required|array', // Validasi array id_bd
            // 'id_bd.*' => 'exists|m_bidang_minat,id_bd'

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false, // response status, false: error/gagal, true: berhasil
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors(), // pesan error validasi
            ]);
        }

        // Ambil data pelatihan
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

        if ($sertifikasi) {

            $dataMaster = sertifikasimodel::find($sertifikasi->id_sertifikasi); // Temukan data berdasarkan ID
            if ($dataMaster) {
                $dataMaster->update([ // Perbarui data
                    'id_jenis_pelatihan_sertifikasi' => $request->id_jenis_pelatihan_sertifikasi,
                    'id_vendor_sertifikasi' => $request->id_vendor_sertifikasi,
                    'nama_sertifikasi' => $request->nama_sertifikasi,
                    'level_sertifikasi' => $request->level_sertifikasi,
                ]);
            }

            $dataDetail = detailsertifikasi::find($id); // Temukan data berdasarkan ID
            if ($dataDetail) {
                $dataDetail->update([ // Perbarui data
                    'id_sertifikasi' => $sertifikasi->id_sertifikasi,
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

                // Menangani file bukti sertifikasi jika ada
                if ($request->hasFile('bukti_sertifikasi')) {

                    if ($request->hasFile('bukti_sertifikasi')) {
                        // Mengambil ID pengguna yang sedang login
                        $userId = Auth::user()->id_user;

                        // Menghitung jumlah bukti sertifikasi yang sudah diupload oleh pengguna tersebut
                        $buktiCount = detailsertifikasi::where('id_user', $userId)->count();

                        // Menentukan nama file
                        $fileName = 'bukti_' . $userId . '_' . ($buktiCount + 1) . '.' . $request->bukti_sertifikasi->getClientOriginalExtension();

                        // Menyimpan file ke storage public/buktiSertifikasi
                        $request->bukti_sertifikasi->move(public_path('buktiSertifikasi'), $fileName);

                        // Update user dengan nama file avatar baru
                        $dataDetail->bukti_sertifikasi = $fileName;
                        $dataDetail->save(); // Simpan perubahan ke database
                    }
                }
            }
        }

        // Proses update untuk id_mk jika ada di session
        if (session()->has('id_mk')) {
            // Hapus data lama terkait id_mk di tagmksertifikasimodel
            tagmksertifikasimodel::where('id_sertifikasi', $sertifikasi->id_sertifikasi)->delete();

            // Menyimpan data baru ke tabel tagmksertifikasimodel
            foreach ($request->id_mk as $id_mk) {
                tagmksertifikasimodel::create([
                    'id_sertifikasi' => $sertifikasi->id_sertifikasi,
                    'id_mk' => $id_mk,
                ]);
            }
        }

        // Proses update untuk id_bd (selalu update)
        if ($request->has('id_bd')) {
            // Hapus data lama terkait id_bd di tagbdsertifikasimodel
            tagbdsertifikasimodel::where('id_sertifikasi', $sertifikasi->id_sertifikasi)->delete();

            // Menyimpan data baru ke tabel tagbdsertifikasimodel
            foreach ($request->id_bd as $id_bd) {
                tagbdsertifikasimodel::create([
                    'id_sertifikasi' => $sertifikasi->id_sertifikasi,
                    'id_bd' => $id_bd,
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diupdate',
        ]);

        return redirect('/');

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

        return view('dosen.pendataansertifikasi.edit_mk', compact('mataKuliah', 'mk', 'id_detail'));

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

        return view('dosen.pendataansertifikasi.edit_bd', compact('bidangMinat', 'bd', 'id_detail'));

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

    public function show(string $id)
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

        return view('dosen.pendataansertifikasi.show', compact('mataKuliah', 'bidangMinat', 'sertifikasi'));
    }

    ////////////////////////////////////////////////////////////////////////////////

    // delete

    public function confirm(string $id)
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

        return view('dosen.pendataansertifikasi.delete', compact('mataKuliah', 'bidangMinat', 'sertifikasi'));

    }

    public function delete(Request $request, $id)
    {

        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $sertifikasi = detailsertifikasi::find($id);
            if ($sertifikasi) {
                $sertifikasi->delete();
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

////////////////////////////////////////////////////////////////////////

///EXPORTTT PDF EXCEL
    public function export_excel()
    {

        $userId = Auth::user()->id_user;

        //ambil data yang akan di export
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
            ->where('detail.id_user', '=', $userId)
            ->orderBy('detail.id_detail_sertifikasi')
            ->get();

        //load library
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Periode');
        $sheet->setCellValue('C1', 'Nama Sertifikasi');
        $sheet->setCellValue('D1', 'Nama Vendor');
        $sheet->setCellValue('E1', 'Level');
        $sheet->setCellValue('F1', 'Jenis Sertifikasi');
        $sheet->setCellValue('G1', 'No Sertifikat');

        $sheet->getStyle('A1:G1')->getFont()->setBold(true); //bold header

        $no = 1;
        $baris = 2;
        foreach ($sertifikasi as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->nama_periode);
            $sheet->setCellValue('C' . $baris, $value->nama_sertifikasi);
            $sheet->setCellValue('D' . $baris, $value->nama_vendor_sertifikasi);
            $sheet->setCellValue('E' . $baris, $value->level_sertifikasi);
            $sheet->setCellValue('F' . $baris, $value->nama_jenis_sertifikasi);
            $sheet->setCellValue('G' . $baris, $value->no_sertifikasi);
            $baris++;
            $no++;

        }

        foreach (range('A', 'G') as $columID) {
            $sheet->getColumnDimension($columID)->setAutoSize(true); //set auto size kolom
        }

        $sheet->setTitle('Data Riwayat Sertifikasi');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Riwayat Sertifikasi' . date('Y-m-d H:i:s') . '.xlsx';
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
        $userId = Auth::user()->id_user;

        //ambil data yang akan di export
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
            ->where('detail.id_user', '=', $userId)
            ->orderBy('detail.id_detail_sertifikasi')
            ->get();

        $identitas = akunusermodel::join(
            'm_identitas_diri as d',
            'd.id_identitas', '=', 'm_akun_user.id_identitas'
        )
            ->where(
                'm_akun_user.id_user', '=', $userId
            )->first();

        //use Barruvdh\DomPDF\Facade\\Pdf
        $pdf = Pdf::loadView('dosen.pendataansertifikasi.export_pdf', ['sertifikasi' => $sertifikasi, 'identitas' => $identitas]);
        $pdf->setPaper('a4', 'potrait');
        $pdf->setOption("isRemoteEnabled", false);
        $pdf->render();

        return $pdf->download('Data Riwayat Sertifikasi ' . date('Y-m-d H:i:s') . '.pdf');
    }

}
