<?php

namespace App\Http\Controllers;

use App\Models\akunusermodel;
use App\Models\bidangminatmodel;
use App\Models\detailbddosen;
use App\Models\detailmkdosen;
use App\Models\identitasmodel;
use App\Models\matakuliahmodel;
use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProfilController extends Controller
{
    public function index()
    {

        $id = session('id_user');

        $breadcrumb = (object) [
            'title' => 'Profil Pengguna',
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
            ['breadcrumb' => $breadcrumb,
                'page' => $page,
                'activeMenu' => $activeMenu,
                'user' => $user,
                'bidangminat' => $bidangminat,
                'matakuliah' => $matakuliah,
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

    public function createbd(string $id)
    {

        $bidangMinat = DB::table('m_detailbddosen')
        ->join ('m_bidang_minat as bd', 'bd.id_bd', '=', 'm_detailbddosen.id_bd')
        ->where ('m_detailbddosen.id_user', '=', $id)
        ->pluck('bd.nama_bd')
        ->toArray();

        $bd = bidangminatmodel::all();

        $user = Auth::id();

        return view('profil.bd', compact('bidangMinat', 'bd', 'user'));
    }

    public function storebd(Request $request, $id)
    {
        // Cek keberadaan id_user terlebih dahulu di tabel m_akun_user
        $userExists = DB::table('m_akun_user')->where('id_user', $id)->exists();
        if (!$userExists) {
            return response()->json([
                'status' => false,
                'message' => 'User tidak ditemukan, pastikan id_user valid.',
            ], 400);
        }
    
        // Menangani pencarian bidang minat jika ada input nama_bd
        if ($search = $request->input('nama_bd')) {
            $tags = matakuliahmodel::where('nama_bd', 'LIKE', "%$search%")->pluck('id_bd');
            return response()->json($tags); // Mengembalikan hasil dalam format JSON
        }
    
        // Mengecek apakah request berupa AJAX
        if ($request->ajax() || $request->wantsJson()) {
    
            $selectedBd = $request->input('id_bd');
    
            // Validasi jika tidak ada bidang minat dipilih
            if (empty($selectedBd)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada bidang minat yang dipilih.',
                ]);
            }
    
            // Menghapus data lama sebelum menyimpan data baru
            detailbddosen::where('id_user', $id)->delete();
    
            try {
                // Menyimpan data baru ke tabel detailbddosen
                foreach ($selectedBd as $id_bd) {
                    detailbddosen::create([
                        'id_user' => $id,
                        'id_bd'   => $id_bd,
                    ]);
                }
    
                return response()->json([
                    'status' => true,
                    'message' => 'Data bidang minat berhasil diperbarui.',
                ]);
            } catch (\Exception $e) {
                // Tangani kesalahan query
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan saat memperbarui data.',
                    'error'   => $e->getMessage(),
                ], 500);
            }
        }
    
        // Redirect jika bukan request AJAX
        return redirect('/');
    }
    

    public function matakuliah(string $id)
    {

        $mataKuliah = DB::table('m_detailmkdosen')
        ->join ('m_mata_kuliah as mk', 'mk.id_mk', '=', 'm_detailmkdosen.id_mk')
        ->where ('m_detailmkdosen.id_user', '=', $id)
        ->pluck('mk.nama_mk')
        ->toArray();

        $mk = matakuliahmodel::all();

        $user = Auth::id();

        return view('profil.mk', compact('mataKuliah', 'mk', 'user'));
    }

    public function storemk(Request $request, $id)
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

        // Mengecek apakah request berupa AJAX
        if ($request->ajax() || $request->wantsJson()) {
    
            $selectedMk = $request->input('id_mk');
    
            // Validasi jika tidak ada bidang minat dipilih
            if (empty($selectedMk)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada bidang minat yang dipilih.',
                ]);
            }
    
            // Menghapus data lama sebelum menyimpan data baru
            detailmkdosen::where('id_user', $id)->delete();
    
            try {
                // Menyimpan data baru ke tabel detailmkdosen
                foreach ($selectedMk as $id_mk) {
                    detailmkdosen::create([
                        'id_user' => $id,
                        'id_mk'   => $id_mk,
                    ]);
                }
    
                return response()->json([
                    'status' => true,
                    'message' => 'Data bidang minat berhasil diperbarui.',
                ]);
            } catch (\Exception $e) {
                // Tangani kesalahan query
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan saat memperbarui data.',
                    'error'   => $e->getMessage(),
                ], 500);
            }
        }
    
        // Redirect jika bukan request AJAX
        return redirect('/');
    }

    public function update(Request $request, $id)
    {
        $user_id = Auth::id();

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
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Ambil data user dengan relasi ke tabel identitas
        $user = akunusermodel::join(
            'm_identitas_diri as d',
            'd.id_identitas', '=', 'm_akun_user.id_identitas'
        )->where(
            'm_akun_user.id_user', '=', $user_id
        )->select(
            'd.*',
            'm_akun_user.*'
        )
            ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Data pengguna tidak ditemukan.');
        }

        // update identitas diri user
        $dataIdentitas = identitasmodel::find($user->id_identitas);
        if ($dataIdentitas) {

            $dataIdentitas->update([
                'nama_lengkap' => $request->nama_lengkap,
                'NIP' => $request->NIP,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'no_telp' => $request->no_telp,
            ]);

            if ($request->hasFile('foto_profil')) {

                $fileName = 'profile_' . $user->id_identitas . '.' . $request->foto_profil->getClientOriginalExtension();

                // Hapus foto lama jika ada
                $oldFile = public_path('img/' . $fileName);
                if (Storage::disk('public')->exists($oldFile)) {
                    Storage::disk('public')->delete($oldFile);
                }

                $request->foto_profil->move(public_path('img'), $fileName);

                $dataIdentitas->foto_profil = $fileName;
                $dataIdentitas->save();
            }
        }

        // uodate data akun user

        // Jika password tidak diisi, hapus dari request agar tidak di-update
        if (!$request->filled('password')) {
            $request->request->remove('password');
        }

        $dataAkun = akunusermodel::find($user_id);
        $dataAkun->update([
            'username' => $request->username,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $dataAkun['password'] = bcrypt($request->password);
        }

        if ($request->ajax()) {
            return response()->json([
                'status' => true,
                'message' => 'Profil berhasil diperbarui.',
            ]);
        }

        return redirect('/');
    }

}
