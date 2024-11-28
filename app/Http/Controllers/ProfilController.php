<?php

namespace App\Http\Controllers;

use App\Models\akunusermodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\support\Facades\Auth;


class ProfilController extends Controller
{
    public function profil_admin()
    {
        $breadcrumb = (object) [
            'title' => 'Profl Pengguna',
            'list' => ['Welcome', 'Profil'],
        ];

        $page = (object) [
            'title' => 'Profil ',
        ];

        $activeMenu = 'profil';

        // $id = Auth::user()->user_id;

        // $user = akunusermodel::with(['identitas', 'jenis_pengguna', 'periode'])->find($id);

        // return view('admin.profil.index',
        // ['breadcrumb' => $breadcrumb,
        // 'page' => $page,
        // 'activeMenu' => $activeMenu,
        // 'user' => $user]);

        return view('admin.profil.index',
            ['breadcrumb' => $breadcrumb,
                'page' => $page,
                'activeMenu' => $activeMenu]);
    }

    public function edit_admin(string $id)
    {

        $user = akunusermodel::find($id);

        return view('admin.profil.edit', ['user' => $user]);
    }

    public function update_admin(Request $request, $id)
{
    $rules = [
        'nama_lengkap' => 'required|string|min:10|max:100',
        'NIP' => 'required|string|min:10|max:20|unique:m_identitas,NIP,'.$id.',id_identitas',
        'tempat_lahir' => 'required|string|min:5|max:10',
        'tanggal_lahir' => 'required|date|before:today',
        'jenis_kelamin' => 'required|string|in:laki,perempuan',
        'alamat' => 'required|string|min:10|max:100',
        'no_telp' => 'required|string|min:10|max:15',
        'email' => 'required|string|min:10|max:50',
        'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ];

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    // Ambil data user dengan relasi ke tabel identitas
    $user = akunusermodel::with('identitas')->find($id);

    if (!$user) {
        return redirect()->back()->with('error', 'Data pengguna tidak ditemukan.');
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
    ];

    if ($request->hasFile('foto_profil')) {

        $fileName = 'profile_' . $user->id_identitas . '.' . $request->foto_profil->getClientOriginalExtension();

        // Check if an existing profile picture exists and delete it
        $oldFile = public_path('img/'. $fileName);
        if (Storage::disk('public')->exists($oldFile)) {
            Storage::disk('public')->delete($oldFile);
        }

        $request->foto_profil->move(public_path('img'), $fileName);

    } else {
        $fileName = 'profil-pic.png'; // default foto_profil
    }

    $user->identitas->update($dataIdentitas);

    // Update data di tabel akun_user
    $dataAkun = [
        'username' => $request->username,
        'email' => $request->email,
    ];

    if ($request->filled('password')) {
        $dataAkun['password'] = bcrypt($request->password);
    }

    $user->update($dataAkun);

    return redirect()->route('admin.profil.index')->with('success', 'Profil berhasil diperbarui.');
}


}
