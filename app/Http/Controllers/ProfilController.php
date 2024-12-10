<?php

namespace App\Http\Controllers;

use App\Models\akunusermodel;
use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\bidangminatmodel;
use App\Models\detailbddosen;
use App\Models\detailmkdosen;
use App\Models\matakuliahmodel;
use App\Models\identitasmodel;

class ProfilController extends Controller
{
    public function index()
    {

        $id = session('id_user');

        $breadcrumb = (object) [
            'title' => 'Profl Pengguna',
            'list' => ['Home', 'Profil'],
        ];

        $page = (object) [
            'title' => 'Profil ',
        ];

        $activeMenu = 'profil';

        $id = Auth::user()->id_user;

        $user = akunusermodel::with(['identitas', 'jenis_pengguna', 'periode'])->find($id);

        $bidangminat = detailbddosen::with(['bidangminat'])->find($id);

        $matakuliah = detailmkdosen::with(['matakuliah'])->find($id);

        return view('profil.index',
            [   'breadcrumb' => $breadcrumb,
                'page' => $page,
                'activeMenu' => $activeMenu,
                'user' => $user,
                'bidangminat' => $bidangminat,
                'matakuliah' => $matakuliah
            ]);

    }

    public function edit(string $id)
    {

        $user = akunusermodel::with(['matakuliah', 'bidangminat'])->find($id);
        $mataKuliah = matakuliahmodel::all(); // Ambil semua data mata kuliah
        $bidangMinat = bidangminatmodel::all(); // Ambil semua data
        $userMataKuliah = $user->matakuliah->pluck('id')->toArray(); // Ambil ID mata kuliah yang dimiliki user


        return view('profil.edit', ['user' => $user, 'userMataKuliah' => $userMataKuliah, 'mataKuliah' => $mataKuliah, 'bidangMinat' => $bidangMinat]);
    }

    public function createbd(string $id) {

        // $id = Auth::user()->id_user;
        $idselected = $id;

        $akun = akunusermodel::select('id_user','username')->get();

        $bd = bidangminatmodel::all();


        return view('profil.bd', ['akun' => $akun, 'bd' => $bd, 'idselected' => $idselected]);
    }

    public function storebd(Request $request,$id){
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_user' => 'required|integer', // Validasi ID Identitas (harus ada di tabel 'identitas')
                'id_bd' => 'required|integer', // Validasi ID Jenis Pengguna
            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors() // pesan error validasi
                ]);
            }
            $detailbd = detailbddosen::create([
                'id_user' => $request->id_user,
                'id_bd' => $id,
            ]);

            if($detailbd){
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
        return redirect('/profil');
    }

    public function matakuliah(string $id) {


        $idselected = $id;

        $akun = akunusermodel::select('id_user','username')->get();

        $mk = matakuliahmodel::all();


        return view('profil.mk', ['akun' => $akun, 'mk' => $mk, 'idselected' => $idselected]);
    }

    public function storemk(Request $request,$id){
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'id_user' => 'required|integer', // Validasi ID Identitas (harus ada di tabel 'identitas')
                'id_mk' => 'required|integer', // Validasi ID Jenis Pengguna
            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors() // pesan error validasi
                ]);
            }
            $detailmk = detailmkdosen::create([
                'id_user' => $id,
                'id_mk' => $request->id_mk,
            ]);

            if($detailmk){
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
        return redirect('/profil');
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'nama_lengkap' => 'required|string|min:10|max:100',
            'NIP' => 'required|string|min:10|max:20',
            'tempat_lahir' => 'required|string|min:5|max:10',
            'tanggal_lahir' => 'required|date|before:today',
            'jenis_kelamin' => 'required|string|in:laki,perempuan',
            'alamat' => 'required|string|min:10|max:100',
            'no_telp' => 'required|string|min:10|max:15',
            'email' => 'required|string|min:10|max:50',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'username' => 'required|max:20',
            'password' => 'nullable|min:5|max:20',
            'bidang_minat_ids' => 'required|array',
            'bidang_minat_ids.*' => 'integer|exists:m_mata_kuliah,id_mk', // Pastikan setiap ID valid
            'mata_kuliah_ids' => 'required|array',
            'mata_kuliah_ids.*' => 'integer|exists:m_bidang_minat,id_bd', // Validasi mata kuliah
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Ambil data user dengan relasi ke tabel identitas
        $user = akunusermodel::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'Data pengguna tidak ditemukan.');
        }


        DB::beginTransaction(); // Gunakan transaksi untuk konsistensi data

        if ($request->hasFile('foto_profil')) {

            $fileName = 'profile_' . $user->id_identitas . '.' . $request->foto_profil->getClientOriginalExtension();

            // Hapus foto lama jika ada
            $oldFile = public_path('img/' . $fileName);
            if (Storage::disk('public')->exists($oldFile)) {
                Storage::disk('public')->delete($oldFile);
            }

            $request->foto_profil->move(public_path('img'), $fileName);

        } else {
            // Gunakan foto yang ada di database jika tidak ada file baru
            $fileName = $check->foto_profil ?? 'profil-pic.png'; // Gunakan default hanya jika tidak ada foto sebelumnya
        }

        // Update data di tabel m_identitas
        $dataIdentitas = [
            'nama_lengkap' => $request->nama_lengkap,
            'NIP' => $request->NIP,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'foto_profil' => $fileName
        ];

        $user->identitas->update($dataIdentitas);


        // Jika password tidak diisi, hapus dari request agar tidak di-update
        if (!$request->filled('password')) {
            $request->request->remove('password');
        }

        // Update data di tabel akun_user
        $dataAkun = [
            'username' => $request->username,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $dataAkun['password'] = bcrypt($request->password);
        }

        $user->update($dataAkun);

        if (Auth::user()->kode_jenis_pengguna === 'DSN') {

            // Proses khusus untuk dosen
            DB::table('detail_bddosen')->where('id_user', $id)->delete();
            DB::table('detail_mkdosen')->where('id_user', $id)->delete();

            $detailbd = detailbddosen::find($id);
            $detailmk = detailbddosen::find($id);

        
            foreach ($request->bidang_minat_ids as $bidang) {
                if ($detailbd) {
                    // Jika data dengan $id ditemukan, lakukan update
                    $detailbd->update([
                        'id_user' => $id,
                        'id_bd' => $bidang,
                    ]);
                } else {
                    // Jika data dengan $id tidak ditemukan, buat data baru
                    detailbddosen::create([
                        'id_user' => $id,
                        'id_bd' => $bidang,
                    ]);
                }
            }
        
            foreach ($request->mata_kuliah_ids as $mk) {
                if ($detailmk) {
                    // Jika data dengan $id ditemukan, lakukan update
                    $detailmk->update([
                        'id_user' => $id,
                        'id_bd' => $mk,
                    ]);
                } else {
                    // Jika data dengan $id tidak ditemukan, buat data baru
                    detailmkdosen::create([
                        'id_user' => $id,
                        'id_bd' => $mk,
                    ]);
                }
            }
        }
        

        return redirect()->route('profil.index')->with('success', 'Profil berhasil diperbarui.');
    }

    // public function confirmmk(string $id){
    //     $detailmk = detailmkdosen::find($id);
    //     return view('superadmin.data.delete', ['detailmk' => $detailmk, 'activemenu' => $activeMenu]);
    // }

    // public function confirmbd(string $id){
    //     $detailbd = detailmkdosen::find($id);
    //     return view('superadmin.data.delete', ['detailbd' => $detailbd, 'activemenu' => $activeMenu]);
    // }

}
