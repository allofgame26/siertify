<?php

// web.php

use App\Http\Controllers\BidangMinatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\datapenggunaSuperadminController;
use App\Http\Controllers\JenispenggunaSuperadminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\JenisPelatihanSertifikasiController;
use App\Http\Controllers\periodeadmincontroller;
use App\Http\Controllers\MatkulController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\VendorPelatihanController;
use App\Http\Controllers\VendorSertifikasiController;
use App\Http\Controllers\pelatihansertifikasicontroller;
use App\Http\Controllers\akunpenggunacontroller;
use App\Http\Controllers\NotifikasiController;
use App\Models\jenispenggunamodel;
use App\Http\Controllers\PendataanPelatihanController;
use App\Http\Controllers\PendataanSertifikasiController;
use App\Http\Controllers\PengajuanPelatihanPimpinanController;
use App\Http\Controllers\PengajuanSertifikasiPimpinanController;
use App\Http\Controllers\sertifikasicontroller;
use App\Http\Controllers\pelatihancontroller;
use App\Http\Controllers\detailsertifikasicontroller;
use App\Http\Controllers\detailpelatihancontroller;
use App\Models\detailsertifikasi;
use App\Http\Controllers\PenugasanPelatihanController;
use App\Http\Controllers\PenugasanSertifikasiController;
use App\Http\Controllers\StatistikController;

Route::pattern('id','[0-9]+');

Route::get('/login', [AuthController::class, 'login']);
Route::post('/postlogin', [AuthController::class, 'postlogin']);
Route::post('/logout', [AuthController::class, 'logout']);


Route::get('/', [WelcomeController::class, 'landingpage']);


// dashboard
Route::get('/dashboard', [DashboardController::class, 'index']);

// profil
Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
Route::get('/profil/{id}/edit', [ProfilController::class, 'edit']);
Route::put('/profil/{id}/update', [ProfilController::class, 'update']);
Route::get('/profil/createmk', [ProfilController::class, 'createmk']);
Route::put('/profil/{id}/prosesmk', [ProfilController::class, 'storemk']);
Route::get('/profil/{id}/bd', [ProfilController::class, 'createbd']);
Route::put('/profil/{id}/prosesbd', [ProfilController::class, 'storebd']);
Route::get('/profil/{id}/mk', [ProfilController::class, 'matakuliah']);

    
// jenis pelatihan dan sertifikasi admin
Route::get('/jenis', [JenisPelatihanSertifikasiController::class, 'index']);  // menampilkan halaman jenis
Route::post('/jenis/list', [JenisPelatihanSertifikasiController::class, 'list'] );    //menampilkan data jenis dalam bentuk json datatables
Route::get('/jenis/create_ajax', [JenisPelatihanSertifikasiController::class, 'create_ajax']); //Menampilkan halaman form tambah jenis Ajax
Route::post('/jenis/ajax', [JenisPelatihanSertifikasiController::class, 'store_ajax']); // Menyimpan data jenis baru Ajax 
Route::get('/jenis/{id}/edit_ajax', [JenisPelatihanSertifikasiController::class,'edit_ajax']); //menampilkan halaman form edit jenis ajax
Route::put('/jenis/{id}/update_ajax', [JenisPelatihanSertifikasiController::class,'update_ajax']);   //menyimpan halaman form edit jenis ajax
Route::get('/jenis/{id}/delete_ajax', [JenisPelatihanSertifikasiController::class, 'confirm_ajax']); //tampil form confirm delete jenis ajax
Route::delete('/jenis/{id}/delete_ajax', [JenisPelatihanSertifikasiController::class, 'delete_ajax']);  //hapus data jenis
Route::get('/jenis/import', [JenisPelatihanSertifikasiController::class, 'import']); //ajax form upolad
Route::post('/jenis/import_ajax', [JenisPelatihanSertifikasiController::class, 'import_ajax']); //ajax import exvel)
Route::get('/jenis/export_excel', [JenisPelatihanSertifikasiController::class, 'export_excel']);  //export excel
Route::get('/jenis/export_pdf', [JenisPelatihanSertifikasiController::class, 'export_pdf']); //export pdf

// data pengguna super admin
Route::get('/datapengguna', [datapenggunaSuperadminController::class, 'index']);
Route::POST('/datapengguna/list', [datapenggunaSuperadminController::class, 'list']);
Route::get('/datapengguna/create', [datapenggunaSuperadminController::class, 'create']);
Route::post('/datapengguna/proses', [datapenggunaSuperadminController::class, 'store']);
Route::get('/datapengguna/{id}/show', [datapenggunaSuperadminController::class, 'show']);       //menampilkan detai user
Route::get('/datapengguna/{id}/edit', [datapenggunaSuperadminController::class,'edit']);
Route::put('/datapengguna/{id}/update', [datapenggunaSuperadminController::class,'update']);
Route::get('/datapengguna/{id}/confirm', [datapenggunaSuperadminController::class,'confirm']);
Route::delete('/datapengguna/{id}/delete', [datapenggunaSuperadminController::class, 'delete']);
Route::get('/datapengguna/import' , [datapenggunaSuperadminController::class , 'import']);
Route::post('/datapengguna/import_proses' , [datapenggunaSuperadminController::class, 'import_proses']);
Route::get('/datapengguna/export_excel' , [datapenggunaSuperadminController::class, 'export_excel']);
Route::get('/datapengguna/export_pdf' , [datapenggunaSuperadminController::class, 'export_pdf']);

// jenis pengguna super admin

Route::get('/jenispengguna', [JenispenggunaSuperadminController::class, 'index']);
Route::POST('/jenispengguna/list', [JenispenggunaSuperadminController::class, 'list']);
Route::get('/jenispengguna/create', [JenispenggunaSuperadminController::class, 'create']);
Route::post('/jenispengguna/proses', [JenispenggunaSuperadminController::class, 'store']);
Route::get('/jenispengguna/{id}/edit', [JenispenggunaSuperadminController::class,'edit']);
Route::put('/jenispengguna/{id}/update', [JenispenggunaSuperadminController::class,'update']);
Route::get('/jenispengguna/{id}/show', [JenispenggunaSuperadminController::class, 'show']);
Route::get('/jenispengguna/{id}/confirm', [JenispenggunaSuperadminController::class,'confirm']);
Route::delete('/jenispengguna/{id}/delete', [JenispenggunaSuperadminController::class, 'delete']);
Route::get('/jenispengguna/import' , [JenispenggunaSuperadminController::class , 'import']);
Route::post('/jenispengguna/import_proses' , [JenispenggunaSuperadminController::class, 'import_proses']);
Route::get('/jenispengguna/export_excel' , [JenispenggunaSuperadminController::class, 'export_excel']);
Route::get('/jenispengguna/export_pdf' , [JenispenggunaSuperadminController::class, 'export_pdf']);

// Data Akun super admin

Route::get('/akunpengguna', [akunpenggunacontroller::class, 'index']);
Route::POST('/akunpengguna/list', [akunpenggunacontroller::class, 'list']);
Route::get('/akunpengguna/create', [akunpenggunacontroller::class, 'create']);
Route::post('/akunpengguna/proses', [akunpenggunacontroller::class, 'store']);
Route::get('/akunpengguna/{id}/edit', [akunpenggunacontroller::class,'edit']);
Route::put('/akunpengguna/{id}/update', [akunpenggunacontroller::class,'update']);
Route::get('/akunpengguna/{id}/show', [akunpenggunacontroller::class, 'show']);
Route::get('/akunpengguna/{id}/confirm', [akunpenggunacontroller::class,'confirm']);
Route::delete('/akunpengguna/{id}/delete', [akunpenggunacontroller::class, 'delete']);
Route::get('/akunpengguna/import' , [akunpenggunacontroller::class , 'import']);
Route::post('/akunpengguna/import_proses' , [akunpenggunacontroller::class, 'import_proses']);
Route::get('/akunpengguna/export_excel' , [akunpenggunacontroller::class, 'export_excel']);
Route::get('/akunpengguna/export_pdf' , [akunpenggunacontroller::class, 'export_pdf']);

//vendor pelatihan
Route::get('/vendor/pelatihan', [VendorPelatihanController::class, 'index']);  // menampilkan halaman vendor/pelatihan
Route::post('/vendor/pelatihan/list', [VendorPelatihanController::class, 'list'] );    //menampilkan data vendor/pelatihan dalam bentuk json datatables
Route::get('/vendor/pelatihan/create_ajax', [VendorPelatihanController::class, 'create_ajax']); //Menampilkan halaman form tambah vendor/pelatihan Ajax
Route::post('/vendor/pelatihan/ajax', [VendorPelatihanController::class, 'store_ajax']); // Menyimpan data vendor/pelatihan baru Ajax 
Route::get('/vendor/pelatihan/{id}/show', [VendorPelatihanController::class, 'show']);       //menampilkan detai user
Route::get('/vendor/pelatihan/{id}/edit_ajax', [VendorPelatihanController::class,'edit_ajax']); //menampilkan halaman form edit vendor/pelatihan ajax
Route::put('/vendor/pelatihan/{id}/update_ajax', [VendorPelatihanController::class,'update_ajax']);   //menyimpan halaman form edit vendor/pelatihan ajax
Route::get('/vendor/pelatihan/{id}/delete_ajax', [VendorPelatihanController::class, 'confirm_ajax']); //tampil form confirm delete vendor/pelatihan ajax
Route::delete('/vendor/pelatihan/{id}/delete_ajax', [VendorPelatihanController::class, 'delete_ajax']);  //hapus data vendor/pelatihan
Route::get('/vendor/pelatihan/import', [VendorPelatihanController::class, 'import']); //ajax form upolad
Route::post('/vendor/pelatihan/import_ajax', [VendorPelatihanController::class, 'import_ajax']); //ajax import exvel)
Route::get('/vendor/pelatihan/export_excel', [VendorPelatihanController::class, 'export_excel']);  //export excel
Route::get('/vendor/pelatihan/export_pdf', [VendorPelatihanController::class, 'export_pdf']); //export pdf

// vendor sertifikasi
Route::get('/vendor/sertifikasi', [VendorSertifikasiController::class, 'index']);  // menampilkan halaman vendor/sertifikasi
Route::post('/vendor/sertifikasi/list', [VendorSertifikasiController::class, 'list'] );    //menampilkan data vendor/sertifikasi dalam bentuk json datatables
Route::get('/vendor/sertifikasi/create_ajax', [VendorSertifikasiController::class, 'create_ajax']); //Menampilkan halaman form tambah vendor/sertifikasi Ajax
Route::post('/vendor/sertifikasi/ajax', [VendorSertifikasiController::class, 'store_ajax']); // Menyimpan data vendor/sertifikasi baru Ajax 
Route::get('/vendor/sertifikasi/{id}/show', [VendorSertifikasiController::class, 'show']);       //menampilkan detai user
Route::get('/vendor/sertifikasi/{id}/edit_ajax', [VendorSertifikasiController::class,'edit_ajax']); //menampilkan halaman form edit vendor/sertifikasi ajax
Route::put('/vendor/sertifikasi/{id}/update_ajax', [VendorSertifikasiController::class,'update_ajax']);   //menyimpan halaman form edit vendor/sertifikasi ajax
Route::get('/vendor/sertifikasi/{id}/delete_ajax', [VendorSertifikasiController::class, 'confirm_ajax']); //tampil form confirm delete vendor/sertifikasi ajax
Route::delete('/vendor/sertifikasi/{id}/delete_ajax', [VendorSertifikasiController::class, 'delete_ajax']);  //hapus data vendor/sertifikasi
Route::get('/vendor/sertifikasi/import', [VendorSertifikasiController::class, 'import']); //ajax form upolad
Route::post('/vendor/sertifikasi/import_ajax', [VendorSertifikasiController::class, 'import_ajax']); //ajax import exvel)
Route::get('/vendor/sertifikasi/export_excel', [VendorSertifikasiController::class, 'export_excel']);  //export excel
Route::get('/vendor/sertifikasi/export_pdf', [VendorSertifikasiController::class, 'export_pdf']); //export pdf

// Periode Admin

Route::get('/periode', [periodeadmincontroller::class, 'index']);
Route::POST('/periode/list', [periodeadmincontroller::class, 'list']);
Route::get('/periode/create', [periodeadmincontroller::class, 'create']);
Route::post('/periode/proses', [periodeadmincontroller::class, 'store']);
Route::get('/periode/{id}/edit', [periodeadmincontroller::class,'edit']);
Route::put('/periode/{id}/update', [periodeadmincontroller::class,'update']);
Route::get('/periode/{id}/show', [periodeadmincontroller::class,'show']);
Route::get('/periode/{id}/confirm', [periodeadmincontroller::class,'confirm']);
Route::delete('/periode/{id}/delete', [periodeadmincontroller::class, 'delete']);
Route::get('/periode/import' , [periodeadmincontroller::class , 'import']);
Route::post('/periode/import_proses' , [periodeadmincontroller::class, 'import_proses']);
Route::get('/periode/export_excel' , [periodeadmincontroller::class, 'export_excel']);
Route::get('/periode/export_pdf' , [periodeadmincontroller::class, 'export_pdf']);


// bidang minat
Route::get('/minat', [BidangMinatController::class, 'index']);  // menampilkan halaman minat
Route::post('/minat/list', [BidangMinatController::class, 'list'] );    //menampilkan data minat dalam bentuk json datatables
Route::get('/minat/create_ajax', [BidangMinatController::class, 'create_ajax']); //Menampilkan halaman form tambah minat Ajax
Route::post('/minat/ajax', [BidangMinatController::class, 'store_ajax']); // Menyimpan data minat baru Ajax 
Route::get('/minat/{id}/edit_ajax', [BidangMinatController::class,'edit_ajax']); //menampilkan halaman form edit minat ajax
Route::put('/minat/{id}/update_ajax', [BidangMinatController::class,'update_ajax']);   //menyimpan halaman form edit minat ajax
Route::get('/minat/{id}/delete_ajax', [BidangMinatController::class, 'confirm_ajax']); //tampil form confirm delete minat ajax
Route::delete('/minat/{id}/delete_ajax', [BidangMinatController::class, 'delete_ajax']);  //hapus data minat
Route::get('/minat/import', [BidangMinatController::class, 'import']); //ajax form upolad
Route::post('/minat/import_ajax', [BidangMinatController::class, 'import_ajax']); //ajax import exvel)
Route::get('/minat/export_excel', [BidangMinatController::class, 'export_excel']);  //export excel
Route::get('/minat/export_pdf', [BidangMinatController::class, 'export_pdf']); //export pdf


// matkul
Route::get('/matkul', [MatkulController::class, 'index']);  // menampilkan halaman matkul
Route::post('/matkul/list', [MatkulController::class, 'list'] );    //menampilkan data matkul dalam bentuk json datatables
Route::get('/matkul/create_ajax', [MatkulController::class, 'create_ajax']); //Menampilkan halaman form tambah matkul Ajax
Route::post('/matkul/ajax', [MatkulController::class, 'store_ajax']); // Menyimpan data matkul baru Ajax 
Route::get('/matkul/{id}/show', [MatkulController::class, 'show']);       //menampilkan detai user
Route::get('/matkul/{id}/edit_ajax', [MatkulController::class,'edit_ajax']); //menampilkan halaman form edit matkul ajax
Route::put('/matkul/{id}/update_ajax', [MatkulController::class,'update_ajax']);   //menyimpan halaman form edit matkul ajax
Route::get('/matkul/{id}/delete_ajax', [MatkulController::class, 'confirm_ajax']); //tampil form confirm delete matkul ajax
Route::delete('/matkul/{id}/delete_ajax', [MatkulController::class, 'delete_ajax']);  //hapus data matkul
Route::get('/matkul/import', [MatkulController::class, 'import']); //ajax form upolad
Route::post('/matkul/import_ajax', [MatkulController::class, 'import_ajax']); //ajax import exvel)
Route::get('/matkul/export_excel', [MatkulController::class, 'export_excel']);  //export excel
Route::get('/matkul/export_pdf', [MatkulController::class, 'export_pdf']); //export pdf

// pendataan pelatihan dosen
Route::get('/pendataan/pelatihan', [PendataanPelatihanController::class, 'index']);  // menampilkan halaman pendataan
Route::post('/pendataan/pelatihan/list', [PendataanPelatihanController::class, 'list'] );    //menampilkan data pendataan dalam bentuk json datatables
Route::get('/pendataan/pelatihan/create', [PendataanPelatihanController::class, 'create']); //Menampilkan halaman form tambah pendataan Ajax
Route::post('/pendataan/pelatihan/ajax', [PendataanPelatihanController::class, 'store']); // Menyimpan data pendataan baru Ajax 
Route::get('/pendataan/pelatihan/create_new', [PendataanPelatihanController::class, 'create_new'])->name('create_new'); //Menampilkan halaman form tambah pendataan Ajax
Route::post('/pendataan/pelatihan/new', [PendataanPelatihanController::class, 'store_new']); // Menyimpan data pendataan baru Ajax 
Route::get('/pendataan/pelatihan/{id}/createmk', [PendataanPelatihanController::class, 'createmk'])->name('pendataan.pelatihan.createmk');;
Route::post('/pendataan/pelatihan/storemk', [PendataanPelatihanController::class, 'store_mk']);
Route::get('/pendataan/pelatihan/{id}/createbd', [PendataanPelatihanController::class, 'createbd']);
Route::post('/pendataan/pelatihan/storebd', [PendataanPelatihanController::class, 'store_bd']);
Route::get('/pendataan/pelatihan/{id}/show', [PendataanPelatihanController::class, 'show']);       //menampilkan detai user
Route::get('/pendataan/pelatihan/{id}/edit', [PendataanPelatihanController::class,'edit']); //menampilkan halaman form edit pendataan ajax
Route::put('/pendataan/pelatihan/{id}/update', [PendataanPelatihanController::class,'update']);   //menyimpan halaman form edit pendataan ajax
Route::get('/pendataan/pelatihan/{id}/editmk', [PendataanPelatihanController::class, 'edit_mk'])->name('pendataan.pelatihan.createmk');;
Route::put('/pendataan/pelatihan/updatemk', [PendataanPelatihanController::class, 'update_mk']);
Route::get('/pendataan/pelatihan/{id}/editbd', [PendataanPelatihanController::class, 'edit_bd']);
Route::put('/pendataan/pelatihan/updatebd', [PendataanPelatihanController::class, 'update_bd']);
Route::get('/pendataan/pelatihan/{id}/delete', [PendataanPelatihanController::class, 'confirm']); //tampil form confirm delete pendataan ajax
Route::delete('/pendataan/pelatihan/{id}/delete', [PendataanPelatihanController::class, 'delete']);  //hapus data pendataan
Route::get('/pendataan/pelatihan/export_excel', [PendataanPelatihanController::class, 'export_excel']);  //export excel
Route::get('/pendataan/pelatihan/export_pdf', [PendataanPelatihanController::class, 'export_pdf']); //export pdf

// pendataan sertifikasi
Route::get('/pendataan/sertifikasi', [PendataanSertifikasiController::class, 'index']);  // menampilkan halaman pendataan
Route::post('/pendataan/sertifikasi/list', [PendataanSertifikasiController::class, 'list'] );    //menampilkan data pendataan dalam bentuk json datatables
Route::get('/pendataan/sertifikasi/create', [PendataanSertifikasiController::class, 'create']); //Menampilkan halaman form tambah pendataan Ajax
Route::post('/pendataan/sertifikasi/ajax', [PendataanSertifikasiController::class, 'store']); // Menyimpan data pendataan baru Ajax 
Route::get('/pendataan/sertifikasi/create_new', [PendataanSertifikasiController::class, 'create_new'])->name('create_new'); //Menampilkan halaman form tambah pendataan Ajax
Route::post('/pendataan/sertifikasi/new', [PendataanSertifikasiController::class, 'store_new']); // Menyimpan data pendataan baru Ajax 
Route::get('/pendataan/sertifikasi/{id}/createmk', [PendataanSertifikasiController::class, 'createmk'])->name('pendataan.sertifikasi.createmk');;
Route::post('/pendataan/sertifikasi/storemk', [PendataanSertifikasiController::class, 'store_mk']);
Route::get('/pendataan/sertifikasi/{id}/createbd', [PendataanSertifikasiController::class, 'createbd']);
Route::post('/pendataan/sertifikasi/storebd', [PendataanSertifikasiController::class, 'store_bd']);
Route::get('/pendataan/sertifikasi/{id}/show', [PendataanSertifikasiController::class, 'show']);       //menampilkan detai user
Route::get('/pendataan/sertifikasi/{id}/edit', [PendataanSertifikasiController::class,'edit']); //menampilkan halaman form edit pendataan ajax
Route::put('/pendataan/sertifikasi/{id}/update', [PendataanSertifikasiController::class,'update']);   //menyimpan halaman form edit pendataan ajax
Route::get('/pendataan/sertifikasi/{id}/editmk', [PendataanSertifikasiController::class, 'edit_mk'])->name('pendataan.sertifikasi.createmk');;
Route::put('/pendataan/sertifikasi/updatemk', [PendataanSertifikasiController::class, 'update_mk']);
Route::get('/pendataan/sertifikasi/{id}/editbd', [PendataanSertifikasiController::class, 'edit_bd']);
Route::put('/pendataan/sertifikasi/updatebd', [PendataanSertifikasiController::class, 'update_bd']);
Route::get('/pendataan/sertifikasi/{id}/delete', [PendataanSertifikasiController::class, 'confirm']); //tampil form confirm delete pendataan ajax
Route::delete('/pendataan/sertifikasi/{id}/delete', [PendataanSertifikasiController::class, 'delete']);  //hapus data pendataan
Route::get('/pendataan/sertifikasi/export_excel', [PendataanSertifikasiController::class, 'export_excel']);  //export excel
Route::get('/pendataan/sertifikasi/export_pdf', [PendataanSertifikasiController::class, 'export_pdf']); //export pdf

// master sertifikasi
Route::get('/mastersertifikasi',[sertifikasicontroller::class, 'index']);
Route::POST('/mastersertifikasi/list',[sertifikasicontroller::class, 'list']);
Route::get('/mastersertifikasi/{id}/show',[sertifikasicontroller::class, 'show']);
Route::get('/mastersertifikasi/create',[sertifikasicontroller::class, 'create']);
Route::post('/mastersertifikasi/proses',[sertifikasicontroller::class, 'store']);
Route::get('/mastersertifikasi/{id}/edit',[sertifikasicontroller::class, 'edit']);
Route::put('/mastersertifikasi/{id}/update',[sertifikasicontroller::class, 'update']);
Route::get('/mastersertifikasi/{id}/confirm',[sertifikasicontroller::class, 'confirm']);
Route::delete('/mastersertifikasi/{id}/delete',[sertifikasicontroller::class, 'delete']);
Route::get('/mastersertifikasi/import',[sertifikasicontroller::class, 'import']);
Route::post('/mastersertifikasi/import_proses',[sertifikasicontroller::class, 'import_proses']);

// master pelatihan
Route::get('/masterpelatihan',[pelatihancontroller::class, 'index']);
Route::POST('/masterpelatihan/list',[pelatihancontroller::class, 'list']);
Route::get('/masterpelatihan/{id}/show',[pelatihancontroller::class, 'show']);
Route::get('/masterpelatihan/create',[pelatihancontroller::class, 'create']);
Route::post('/masterpelatihan/proses',[pelatihancontroller::class, 'store']);
Route::get('/masterpelatihan/{id}/edit',[pelatihancontroller::class, 'edit']);
Route::put('/masterpelatihan/{id}/update',[pelatihancontroller::class, 'update']);
Route::get('/masterpelatihan/{id}/confirm',[pelatihancontroller::class, 'confirm']);
Route::delete('/masterpelatihan/{id}/delete',[pelatihancontroller::class, 'delete']);
Route::get('/masterpelatihan/import',[pelatihancontroller::class, 'import']);
Route::post('/masterpelatihan/import_proses',[pelatihancontroller::class, 'import_proses']);

Route::get('/detailsertifikasi',[detailsertifikasicontroller::class,'index']);
Route::post('/detailsertifikasi/list',[detailsertifikasicontroller::class,'list']);
Route::get('/detailsertifikasi/create',[detailsertifikasicontroller::class,'create']);
Route::post('/detailsertifikasi/proses',[detailsertifikasicontroller::class,'store']);
Route::get('/detailsertifikasi/{id}/createmk', [detailsertifikasicontroller::class, 'createmk'])->name('pendataan.sertifikasi.createmk');;
Route::post('/detailsertifikasi/storemk', [detailsertifikasicontroller::class, 'store_mk']);
Route::get('/detailsertifikasi/{id}/createbd', [detailsertifikasicontroller::class, 'createbd']);
Route::post('/detailsertifikasi/storebd', [detailsertifikasicontroller::class, 'store_bd']);
Route::get('/detailsertifikasi/{id}/show',[detailsertifikasicontroller::class, 'show']);
Route::post('/detailsertifikasi/{id}/showpeserta',[detailpelatihancontroller::class, 'showpeserta']);
Route::get('/detailsertifikasi/{id}/confirm',[detailsertifikasicontroller::class, 'confirm']);
Route::delete('/detailsertifikasi/{id}/delete',[detailsertifikasicontroller::class, 'delete']);
Route::get('/detailsertifikasi/{id}/edit', [detailsertifikasicontroller::class,'edit']); //menampilkan halaman form edit pendataan ajax
Route::put('/detailsertifikasi/{id}/update', [detailsertifikasicontroller::class,'update']);   //menyimpan halaman form edit pendataan ajax
Route::get('/detailsertifikasi/{id}/editmk', [detailsertifikasicontroller::class, 'edit_mk']);
Route::put('/detailsertifikasi/updatemk', [detailsertifikasicontroller::class, 'update_mk']);
Route::get('/detailsertifikasi/{id}/editbd', [detailsertifikasicontroller::class, 'edit_bd']);
Route::put('/detailsertifikasi/updatebd', [detailsertifikasicontroller::class, 'update_bd']);
Route::get('/detailsertifikasi/export_excel', [detailsertifikasicontroller::class, 'excel']);
Route::get('/detailsertifikasi/export_pdf', [detailsertifikasicontroller::class, 'pdf']);

Route::get('/detailpelatihan',[detailpelatihancontroller::class,'index']);
Route::post('/detailpelatihan/list',[detailpelatihancontroller::class,'list']);
Route::get('/detailpelatihan/create',[detailpelatihancontroller::class,'create']);
Route::post('/detailpelatihan/proses',[detailpelatihancontroller::class,'store']);
Route::get('/detailpelatihan/{id}/createmk', [detailpelatihancontroller::class, 'createmk'])->name('pendataan.sertifikasi.createmk');;
Route::post('/detailpelatihan/storemk', [detailpelatihancontroller::class, 'store_mk']);
Route::get('/detailpelatihan/{id}/createbd', [detailpelatihancontroller::class, 'createbd']);
Route::post('/detailpelatihan/storebd', [detailpelatihancontroller::class, 'store_bd']);
Route::get('/detailpelatihan/{id}/show',[detailpelatihancontroller::class, 'show']);
Route::post('/detailpelatihan/{id}/showpeserta',[detailpelatihancontroller::class, 'showpeserta']);
Route::get('/detailpelatihan/{id}/confirm',[detailpelatihancontroller::class, 'confirm']);
Route::delete('/detailpelatihan/{id}/delete',[detailpelatihancontroller::class, 'delete']);
Route::get('/detailpelatihan/{id}/edit', [detailpelatihancontroller::class,'edit']); //menampilkan halaman form edit pendataan ajax
Route::put('/detailpelatihan/{id}/update', [detailpelatihancontroller::class,'update']);   //menyimpan halaman form edit pendataan ajax
Route::get('/detailpelatihan/{id}/editmk', [detailpelatihancontroller::class, 'edit_mk']);
Route::put('/detailpelatihan/updatemk', [detailpelatihancontroller::class, 'update_mk']);
Route::get('/detailpelatihan/{id}/editbd', [detailpelatihancontroller::class, 'edit_bd']);
Route::put('/detailpelatihan/updatebd', [detailpelatihancontroller::class, 'update_bd']);
Route::get('/detailpelatihan/export_excel', [detailpelatihancontroller::class, 'excel']);
Route::get('/detailpelatihan/export_pdf', [detailpelatihancontroller::class, 'pdf']);


// Route::get('/pelatihansertifikasi',[pelatihansertifikasicontroller::class, 'index']);

//Begin AdminLte
Route::get('/pengajuan', [PengajuanPelatihanPimpinanController::class, 'index']);

// jenis pelatihan dan sertifikasi
Route::get('/pengajuan', [PengajuanPelatihanPimpinanController::class, 'index']);  // menampilkan halaman jenis
Route::post('/pengajuan/list', [PengajuanPelatihanPimpinanController::class, 'list'] );    //menampilkan data jenis dalam bentuk json datatables
Route::get('/pengajuan/pelatihan/{id}/show', [PengajuanPelatihanPimpinanController::class, 'show']);
Route::post('/pengajuan/pelatihan/{id}/showpeserta',[PengajuanPelatihanPimpinanController::class, 'showpeserta']);
Route::get('/pengajuan/sertifikasi/{id}/show', [PengajuanSertifikasiPimpinanController::class, 'show']);
Route::post('/pengajuan/sertifikasi/{id}/showpeserta',[PengajuanSertifikasiPimpinanController::class, 'showpeserta']);
Route::put('/pengajuan/pelatihan/{id}/update', [PengajuanPelatihanPimpinanController::class, 'update']);
Route::put('/pengajuan/sertifikasi/{id}/update', [PengajuanSertifikasiPimpinanController::class, 'update']);
Route::get('/pengajuan/export_excel', [PengajuanPelatihanPimpinanController::class, 'export_excel']);  //export excel
Route::get('/pengajuan/export_pdf', [PengajuanPelatihanPimpinanController::class, 'export_pdf']); //export pdf


// jenis pelatihan dan sertifikasi
Route::get('/sertifikasi', [PengajuanSertifikasiPimpinanController::class, 'index']);  // menampilkan halaman jenis
Route::post('/sertifikasi/list', [PengajuanSertifikasiPimpinanController::class, 'list'] );    //menampilkan data jenis dalam bentuk json datatables
Route::post('/sertifikasi/ajax', [PengajuanSertifikasiPimpinanController::class, 'store_ajax']); // Menyimpan data jenis baru Ajax 
Route::get('/sertifikasi/{id}/edit_ajax', [PengajuanSertifikasiPimpinanController::class,'edit_ajax']); //menampilkan halaman form edit jenis ajax
Route::put('/sertifkasi/{id}/update_ajax', [PengajuanSertifikasiPimpinanController::class,'update_ajax']);   //menyimpan halaman form edit jenis ajax
Route::get('/sertifikasi/export_excel', [PengajuanSertifikasiPimpinanController::class, 'export_excel']);  //export excel
Route::get('/sertifikasi/export_pdf', [PengajuanSertifikasiPimpinanController::class, 'export_pdf']); //export pdf
Route::get('/{id}/show_ajax', [PengajuanSertifikasiPimpinanController::class, 'show_ajax']); //show_ajax


// route penugasan
Route::get('/penugasan/pelatihan', [PenugasanPelatihanController::class, 'index']);  // menampilkan halaman penugasan
Route::post('/penugasan/pelatihan/list', [PenugasanPelatihanController::class, 'list'] );    //menampilkan data penugasan dalam bentuk json datatables
Route::get('/penugasan/pelatihan/{id}/show', [PenugasanPelatihanController::class, 'show']); 
Route::get('/penugasan/pelatihan/{id}/surat_tugas', [PenugasanPelatihanController::class, 'surat_tugas']); //export pdf
Route::get('/penugasan/pelatihan/{id}/create', [PenugasanPelatihanController::class, 'create']); //add to riwayat aka pendataan
Route::post('/penugasan/pelatihan/{id}/store', [PenugasanPelatihanController::class, 'store']);
Route::get('/penugasan/pelatihan/export_excel', [PenugasanPelatihanController::class, 'export_excel']);  //export excel
Route::get('/penugasan/pelatihan/export_pdf', [PenugasanPelatihanController::class, 'export_pdf']); //export pdf

Route::get('/penugasan/sertifikasi', [PenugasanSertifikasiController::class, 'index']);  // menampilkan halaman penugasan
Route::post('/penugasan/sertifikasi/list', [PenugasanSertifikasiController::class, 'list'] );    //menampilkan data penugasan dalam bentuk json datatables
Route::get('/penugasan/sertifikasi/{id}/show', [PenugasanSertifikasiController::class, 'show']); 
Route::get('/penugasan/sertifikasi/{id}/surat_tugas', [PenugasanSertifikasiController::class, 'surat_tugas']); //export pdf
Route::get('/penugasan/sertifikasi/{id}/create', [PenugasanSertifikasiController::class, 'create']); //add to riwayat aka pendataan
Route::post('/penugasan/sertifikasi/{id}/store', [PenugasanSertifikasiController::class, 'store']);
Route::get('/penugasan/sertifikasi/export_excel', [PenugasanSertifikasiController::class, 'export_excel']);  //export excel
Route::get('/penugasan/sertifikasi/export_pdf', [PenugasanSertifikasiController::class, 'export_pdf']); //export pdf

// statistik
Route::get('/statistik', [StatistikController::class, 'index']);
Route::post('/statistik/list', [StatistikController::class, 'list']);
Route::get('/statistik/pelatihan/{id}/detail/{id_periode}', [StatistikController::class, 'show']);
Route::post('/statistik/pelatihan/{id}/list/{id_periode}', [StatistikController::class, 'showList']);
Route::get('/statistik/pelatihan/{id}/detailpelatihan', [StatistikController::class, 'detailPelatihan']);
Route::post('/statistik/sertifikasi/{id}/list/{id_periode}', [StatistikController::class, 'showList2']);
Route::get('/statistik/sertifikasi/{id}/detailsertifikasi', [StatistikController::class, 'detailSertifikasi']);
Route::get('/statistik/export_excel', [StatistikController::class, 'export_excel']);  //export excel
Route::get('/statistik/export_pdf', [StatistikController::class, 'export_pdf']); //export pdf

// notifikasi
Route::get('/notifikasi/{id}/', [NotifikasiController::class, 'index']);
Route::post('/notifikasi/{id}/list', [NotifikasiController::class, 'list']);
Route::get('/notifikasi/pelatihan/{id}/detail', [NotifikasiController::class, 'detailPelatihan']);
Route::get('/notifikasi/sertifikasi/{id}/detail', [NotifikasiController::class, 'detailSertifikasi']);

