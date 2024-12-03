<?php

namespace App\Http\Controllers;

use App\Models\akunusermodel;
use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\bidangminatmodel;
use App\Models\detailbddosen;
use App\Models\detailmkdosen;
use App\Models\matakuliahmodel;

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

        $user = akunusermodel::with(['identitas', 'jenis_pengguna', 'periode', 'bidangminat', 'matakuliah'])->find($id);


        return view('profil.index',
            ['breadcrumb' => $breadcrumb,
                'page' => $page,
                'activeMenu' => $activeMenu,
                'user' => $user]);

    }

    public function edit(string $id)
    {

        $user = akunusermodel::with(['matakuliah', 'bidangminat'])->find($id);
        $mataKuliah = matakuliahmodel::all(); // Ambil semua data mata kuliah
        $userMataKuliah = $user->matakuliah->pluck('id')->toArray(); // Ambil ID mata kuliah yang dimiliki user

        return view('profil.edit', ['user' => $user, 'userMataKuliah' => $userMataKuliah, 'mataKuliah' => $mataKuliah]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'nama_lengkap' => 'required|string|min:10|max:100',
            'NIP' => 'required|string|min:10|max:20|unique:m_identitas,NIP,' . $id . ',id_identitas',
            'tempat_lahir' => 'required|string|min:5|max:10',
            'tanggal_lahir' => 'required|date|before:today',
            'jenis_kelamin' => 'required|string|in:laki,perempuan',
            'alamat' => 'required|string|min:10|max:100',
            'no_telp' => 'required|string|min:10|max:15',
            'email' => 'required|string|min:10|max:50',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'username' => 'required|max:20|unique:m_identitas_diri,username' . $id . ',id_user',
            'password' => 'nullable|min:5|max:20',
            'id_bidang_minat' => 'required|array|min:1',
            'id_bidang_minat.*' => 'integer|exists:m_bidang_minat,id', // Pastikan setiap ID valid
            'id_mata_kuliah' => 'required|array|min:1',
            'id_mata_kuliah.*' => 'integer|exists:m_mata_kuliah,id', // Validasi mata kuliah
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
            DB::table('detail_bidang_minat')->where('id_user', $id)->delete();
            DB::table('detail_mata_kuliah')->where('id_user', $id)->delete();
        
            foreach ($request->id_bidang_minat as $bidang) {
                detailbddosen::find($id)->update([
                    'id_user' => $id,
                    'id_bidang_minat' => $bidang,
                ]);
            }
        
            foreach ($request->id_mata_kuliah as $mk) {
                detailmkdosen::find($id)->update([
                    'id_user' => $id,
                    'id_mata_kuliah' => $mk,
                ]);
            }
        }
        

        return redirect()->route('profil.index')->with('success', 'Profil berhasil diperbarui.');
    }

}
