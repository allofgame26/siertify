<?php

namespace App\Http\Controllers;

use App\Models\akunusermodel;
use App\Models\bidangminatmodel;
use App\Models\detailpelatihan;
use App\Models\jenispelatihansertifikasimodel;
use App\Models\matakuliahmodel;
use App\Models\pelatihanmodel;
use App\Models\periodemodel;
use App\Models\tagbdpelatihanmodel;
use App\Models\tagmkpelatihanmodel;
use App\Models\vendorpelatihanmodel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Yajra\DataTables\Facades\DataTables;

class PendataanPelatihanController extends Controller
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
            'title' => 'Pendataan Riwayat Pelatihan',
        ];

        $pelatihan = pelatihanmodel::all();
        $jenisPelatihan = jenispelatihansertifikasimodel::all();
        $vendorPelatihan = vendorpelatihanmodel::all();
        $detail = detailpelatihan::all();
        $periode = periodemodel::all();

        return view('dosen.pendataanpelatihan.index', [
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

    // MENAMPILKAN DATATABLES DI INDEX
    public function list(Request $request)
    {
        $user_id = Auth::user()->id_user; // Ambil ID user yang login

        $pelatihan = pelatihanmodel::join(
            'm_vendor_pelatihan as vendor',
            'm_pelatihan.id_vendor_pelatihan', '=', 'vendor.id_vendor_pelatihan'
        )->join(
            'm_jenis_pelatihan_sertifikasi as j',
            'j.id_jenis_pelatihan_sertifikasi', '=', 'm_pelatihan.id_jenis_pelatihan_sertifikasi'
        )
            ->join(
                't_detailpelatihan as detail', 'm_pelatihan.id_pelatihan', '=', 'detail.id_pelatihan'
            )->join(
            'm_periode as periode', 'periode.id_periode', '=', 'detail.id_periode' // Perbaiki join untuk periode
        )->select(
            'm_pelatihan.id_pelatihan',
            'm_pelatihan.nama_pelatihan',
            'vendor.nama_vendor_pelatihan',
            'm_pelatihan.level_pelatihan',
            'j.nama_jenis_sertifikasi',
            'periode.nama_periode',
            'detail.tanggal_mulai',
            'detail.id_detail_pelatihan' // Ambil nama periode
        )->where(
            'detail.id_user', '=', $user_id
        );

        // Apply filter berdasarkan id_periode jika ada
        if ($request->id_periode_pelatihan) {
            $pelatihan->where('detail.id_periode', $request->id_periode_pelatihan);
        }

        // Ambil data setelah semua filter diterapkan
        $pelatihan = $pelatihan->get();

        return DataTables::of($pelatihan)
            ->addIndexColumn()
            ->addColumn('aksi', function ($pendataan) {
                $btn = '<button onclick="modalAction(\'' . url('/pendataan/pelatihan/' . $pendataan->id_detail_pelatihan . '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/pendataan/pelatihan/' . $pendataan->id_detail_pelatihan . '/edit') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/pendataan/pelatihan/' . $pendataan->id_detail_pelatihan . '/delete') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';

                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);

    }

    // CREATE DARI DROPDOWN ADMIN
    public function create()
    {
        // Mengambil data pelatihan lengkap dengan join ke tabel terkait
        $pelatihan = pelatihanmodel::join(
            'm_jenis_pelatihan_sertifikasi as jenis',
            'm_pelatihan.id_jenis_pelatihan_sertifikasi', '=', 'jenis.id_jenis_pelatihan_sertifikasi'
        )
            ->join(
                'm_vendor_pelatihan as vendor',
                'm_pelatihan.id_vendor_pelatihan', '=', 'vendor.id_vendor_pelatihan'
            )
            ->select(
                'm_pelatihan.id_pelatihan',
                'm_pelatihan.nama_pelatihan',
                'jenis.nama_jenis_sertifikasi',
                'vendor.nama_vendor_pelatihan',
                'm_pelatihan.level_pelatihan'
            )
            ->get();

        $periode = periodemodel::all(); // Tetap diambil untuk kebutuhan lain

        return view('dosen.pendataanpelatihan.create', compact('pelatihan', 'periode'));
    }

    public function store(Request $request)
    {

        if ($request->ajax() || $request->wantsJson()) {
            // Validasi input
            $rules = [
                'id_pelatihan' => 'required|integer|exists:m_pelatihan,id_pelatihan', // Validasi pelatihan
                'id_periode' => 'required|integer|exists:m_periode,id_periode', // Validasi periode
                'tanggal_mulai' => 'required|date', // Validasi tanggal mulai
                'tanggal_selesai' => 'required|date', // Validasi tanggal selesai
                'lokasi' => 'required|string|max:50', // Validasi lokasi
                'biaya' => 'required|integer', // Validasi biaya
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

            // Setelah validasi berhasil, simpan data ke database
            $pelatihan = detailpelatihan::create([
                'id_pelatihan' => $request->id_pelatihan,
                'id_periode' => $request->id_periode,
                'id_user' => auth()->id(),
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'lokasi' => $request->lokasi,
                'biaya' => $request->biaya,
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

    // //////////////////////////////////////////////////////////////////////////////////////////

    // CREATE PELATIHAN BARU

    public function create_new()
    {
        $jenisPelatihan = jenispelatihansertifikasimodel::all();
        $vendorPelatihan = vendorpelatihanmodel::all();
        $periode = periodemodel::all(); // Tetap diambil untuk kebutuhan lain

        return view('dosen.pendataanpelatihan.create_new', compact('jenisPelatihan', 'vendorPelatihan', 'periode'));
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
            'nama_pelatihan' => 'required|string|max:100',
            'id_vendor_pelatihan' => 'required|integer|exists:m_vendor_pelatihan,id_vendor_pelatihan',
            'level_pelatihan' => 'required',
            'id_jenis_pelatihan_sertifikasi' => 'required|exists:m_jenis_pelatihan_sertifikasi,id_jenis_pelatihan_sertifikasi',
            'id_periode' => 'required|exists:m_periode,id_periode', // Validasi periode
            'tanggal_mulai' => 'required|date', // Validasi tanggal mulai
            'tanggal_selesai' => 'required|date', // Validasi tanggal selesai
            'lokasi' => 'required|string|max:50', // Validasi lokasi
            'biaya' => 'required|integer', // Validasi biaya
            'no_pelatihan' => 'required|string|max:20', // Validasi nomor pelatihan
            'bukti_pelatihan' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240', // Validasi bukti pelatihan (maks 10MB)
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
            $pelatihan = pelatihanmodel::create([
                'id_jenis_pelatihan_sertifikasi' => $request->id_jenis_pelatihan_sertifikasi,
                'id_vendor_pelatihan' => $request->id_vendor_pelatihan,
                'nama_pelatihan' => $request->nama_pelatihan,
                'level_pelatihan' => $request->level_pelatihan,
            ]);

            // Mendapatkan id_pelatihan
            $idPelatihanBaru = $pelatihan->id_pelatihan;

            // Menyimpan data detail pelatihan
            $detailPelatihan = detailpelatihan::create([
                'id_pelatihan' => $idPelatihanBaru,
                'id_periode' => $request->id_periode,
                'id_user' => auth()->id(),
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_selesai' => $request->tanggal_selesai,
                'lokasi' => $request->lokasi,
                'biaya' => $request->biaya,
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
                    $detailPelatihan->bukti_pelatihan = $fileName;
                    $detailPelatihan->save(); // Simpan perubahan ke database

                }
            }

            // Menyimpan data ke tabel tagmkpelatihanmodel jika session 'id_mk' ada
            foreach ($request->id_mk as $id_mk) {
                tagmkpelatihanmodel::create([
                    'id_pelatihan' => $idPelatihanBaru,
                    'id_mk' => $id_mk,
                ]);
            }

            foreach ($request->id_bd as $id_bd) {
                tagbdpelatihanmodel::create([
                    'id_pelatihan' => $idPelatihanBaru,
                    'id_bd' => $id_bd,
                ]);
            }

            // Commit transaction jika semua berhasil
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Data pelatihan dan detail berhasil disimpan.',
                'id_pelatihan' => $idPelatihanBaru,
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

        return view('dosen.pendataanpelatihan.create_mk', ['mk' => $mk]);
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

        return view('dosen.pendataanpelatihan.create_bd', ['bd' => $bd]);
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

        return view('dosen.pendataanpelatihan.edit', compact('mataKuliah', 'bidangMinat', 'pelatihan', 'jenisPelatihan', 'vendorPelatihan', 'periode'));

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
            'nama_pelatihan' => 'required|string|max:100',
            'id_vendor_pelatihan' => 'required|integer|exists:m_vendor_pelatihan,id_vendor_pelatihan',
            'level_pelatihan' => 'required',
            'id_jenis_pelatihan_sertifikasi' => 'required|exists:m_jenis_pelatihan_sertifikasi,id_jenis_pelatihan_sertifikasi',
            'id_periode' => 'required|exists:m_periode,id_periode', // Validasi periode
            'tanggal_mulai' => 'required|date', // Validasi tanggal mulai
            'tanggal_selesai' => 'required|date', // Validasi tanggal selesai
            'lokasi' => 'required|string|max:50', // Validasi lokasi
            'biaya' => 'required|integer', // Validasi biaya
            'no_pelatihan' => 'required|string|max:20', // Validasi nomor pelatihan
            'bukti_pelatihan' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240', // Validasi bukti pelatihan (maks 10MB)
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

        if ($pelatihan) {

            $dataMaster = pelatihanmodel::find($pelatihan->id_pelatihan); // Temukan data berdasarkan ID
            if ($dataMaster) {
                $dataMaster->update([ // Perbarui data
                    'id_jenis_pelatihan_sertifikasi' => $request->id_jenis_pelatihan_sertifikasi,
                    'id_vendor_pelatihan' => $request->id_vendor_pelatihan,
                    'nama_pelatihan' => $request->nama_pelatihan,
                    'level_pelatihan' => $request->level_pelatihan,
                ]);
            }

            $dataDetail = detailpelatihan::find($id); // Temukan data berdasarkan ID
            if ($dataDetail) {
                $dataDetail->update([ // Perbarui data
                    'id_pelatihan' => $pelatihan->id_pelatihan,
                    'id_periode' => $request->id_periode,
                    'id_user' => auth()->id(),
                    'tanggal_mulai' => $request->tanggal_mulai,
                    'tanggal_selesai' => $request->tanggal_selesai,
                    'lokasi' => $request->lokasi,
                    'biaya' => $request->biaya,
                    'no_pelatihan' => $request->no_pelatihan,
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
                        $dataDetail->bukti_pelatihan = $fileName;
                        $dataDetail->save(); // Simpan perubahan ke database
                    }
                }
            }
        }

        // Proses update untuk id_mk jika ada di session
        if (session()->has('id_mk')) {
            // Hapus data lama terkait id_mk di tagmkpelatihanmodel
            tagmkpelatihanmodel::where('id_pelatihan', $pelatihan->id_pelatihan)->delete();

            // Menyimpan data baru ke tabel tagmkpelatihanmodel
            foreach ($request->id_mk as $id_mk) {
                tagmkpelatihanmodel::create([
                    'id_pelatihan' => $pelatihan->id_pelatihan,
                    'id_mk' => $id_mk,
                ]);
            }
        }

        // Proses update untuk id_bd (selalu update)
        if ($request->has('id_bd')) {
            // Hapus data lama terkait id_bd di tagbdpelatihanmodel
            tagbdpelatihanmodel::where('id_pelatihan', $pelatihan->id_pelatihan)->delete();

            // Menyimpan data baru ke tabel tagbdpelatihanmodel
            foreach ($request->id_bd as $id_bd) {
                tagbdpelatihanmodel::create([
                    'id_pelatihan' => $pelatihan->id_pelatihan,
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

        return view('dosen.pendataanpelatihan.edit_mk', compact('mataKuliah', 'mk', 'id_detail'));

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

        return view('dosen.pendataanpelatihan.edit_bd', compact('bidangMinat', 'bd', 'id_detail'));

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

        return view('dosen.pendataanpelatihan.show', compact('mataKuliah', 'bidangMinat', 'pelatihan'));
    }

    ////////////////////////////////////////////////////////////////////////////////

    // delete

    public function confirm(string $id)
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

        return view('dosen.pendataanpelatihan.delete', compact('mataKuliah', 'bidangMinat', 'pelatihan'));

    }

    public function delete(Request $request, $id)
    {

        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $pelatihan = detailpelatihan::find($id);
            if ($pelatihan) {
                $pelatihan->delete();
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
            ->where('detail.id_user', '=', $userId)
            ->orderBy('detail.id_detail_pelatihan')
            ->get();

        //load library
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Periode');
        $sheet->setCellValue('C1', 'Nama Pelatihan');
        $sheet->setCellValue('D1', 'Nama Vendor');
        $sheet->setCellValue('E1', 'Level');
        $sheet->setCellValue('F1', 'Jenis Pelatihan');
        $sheet->setCellValue('G1', 'No Sertifikat');

        $sheet->getStyle('A1:G1')->getFont()->setBold(true); //bold header

        $no = 1;
        $baris = 2;
        foreach ($pelatihan as $key => $value) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $value->nama_periode);
            $sheet->setCellValue('C' . $baris, $value->nama_pelatihan);
            $sheet->setCellValue('D' . $baris, $value->nama_vendor_pelatihan);
            $sheet->setCellValue('E' . $baris, $value->level_pelatihan);
            $sheet->setCellValue('F' . $baris, $value->nama_jenis_sertifikasi);
            $sheet->setCellValue('G' . $baris, $value->no_pelatihan);
            $baris++;
            $no++;

        }

        foreach (range('A', 'G') as $columID) {
            $sheet->getColumnDimension($columID)->setAutoSize(true); //set auto size kolom
        }

        $sheet->setTitle('Data Riwayat Pelatihan');
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Riwayat Pelatihan' . date('Y-m-d H:i:s') . '.xlsx';
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
            ->where('detail.id_user', '=', $userId)
            ->orderBy('detail.id_detail_pelatihan')
            ->get();

        $identitas = akunusermodel::join(
            'm_identitas_diri as d',
            'd.id_identitas', '=', 'm_akun_user.id_identitas'
        )
            ->where(
                'm_akun_user.id_user', '=', $userId
            )->first();

        //use Barruvdh\DomPDF\Facade\\Pdf
        $pdf = Pdf::loadView('dosen.pendataanpelatihan.export_pdf', ['pelatihan' => $pelatihan, 'identitas' => $identitas]);
        $pdf->setPaper('a4', 'potrait');
        $pdf->setOption("isRemoteEnabled", false);
        $pdf->render();

        return $pdf->download('Data Riwayat Pelatihan ' . date('Y-m-d H:i:s') . '.pdf');
    }

}
