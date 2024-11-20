<?php

// web.php

use App\Http\Controllers\datapenggunaSuperadminController;
use App\Http\Controllers\JenispenggunaSuperadminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\JenisPelatihanSertifikasiController;
use App\Http\Controllers\VendorPelatihanController;
use App\Http\Controllers\VendorSertifikasiController;
use App\Models\jenispenggunamodel;

// Route::get('/', [WelcomeController::class, 'index']);
Route::get('/', [WelcomeController::class, 'index']);

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
Route::post('/datapengguna/proses', [datapenggunaSuperadminController::class, 'store'])->name('datapengguna.store');

Route::get('/datapengguna/{id}/edit', [datapenggunaSuperadminController::class,'edit']);
Route::put('/datapengguna/{id}/update', [datapenggunaSuperadminController::class,'update']);

Route::get('/datapengguna/{id}/confirm', [datapenggunaSuperadminController::class,'confirm']);
Route::delete('/datapengguna/{id}/delete', [datapenggunaSuperadminController::class, 'delete']);

// Jenis Pengguna

Route::get('/jenispengguna', [JenispenggunaSuperadminController::class, 'index']);
Route::POST('/jenispengguna/list', [JenispenggunaSuperadminController::class, 'list']);

Route::get('/jenispengguna/create', [JenispenggunaSuperadminController::class, 'create']);
Route::post('/jenispengguna/proses', [JenispenggunaSuperadminController::class, 'store']);

Route::get('/jenispengguna/{id}/edit', [JenispenggunaSuperadminController::class,'edit']);
Route::put('/jenispengguna/{id}/update', [JenispenggunaSuperadminController::class,'update']);

Route::get('/jenispengguna/{id}/confirm', [JenispenggunaSuperadminController::class,'confirm']);
Route::delete('/jenispengguna/{id}/delete', [JenispenggunaSuperadminController::class, 'delete']);

Route::get('/jenispengguna/import' , [JenispenggunaSuperadminController::class , 'import']);
Route::post('/jenispengguna/import_proses' , [JenispenggunaSuperadminController::class, 'import_proses']);

Route::get('/jenispengguna/export_excel' , [JenispenggunaSuperadminController::class, 'export_excel']);
Route::get('/jenispengguna/export_pdf' , [JenispenggunaSuperadminController::class, 'export_pdf']);

Route::get('/datapengguna/import' , [datapenggunaSuperadminController::class , 'import']);
Route::post('/datapengguna/import_proses' , [datapenggunaSuperadminController::class, 'import_proses']);

Route::get('/datapengguna/export_excel' , [datapenggunaSuperadminController::class, 'export_excel']);
Route::get('/datapengguna/export_pdf' , [datapenggunaSuperadminController::class, 'export_pdf']);

// jenis pengguna super admin

Route::get('/datapengguna', [JenispenggunaSuperadminController::class, 'index']);
Route::POST('/datapengguna/list', [JenispenggunaSuperadminController::class, 'list']);

Route::get('/datapengguna/create', [JenispenggunaSuperadminController::class, 'create']);
Route::post('/datapengguna/proses', [JenispenggunaSuperadminController::class, 'store'])->name('datapengguna.store');

Route::get('/datapengguna/{id}/edit', [JenispenggunaSuperadminController::class,'edit']);
Route::put('/datapengguna/{id}/update', [JenispenggunaSuperadminController::class,'update']);

Route::get('/datapengguna/{id}/confirm', [JenispenggunaSuperadminController::class,'confirm']);
Route::delete('/datapengguna/{id}/delete', [JenispenggunaSuperadminController::class, 'delete']);

Route::get('/datapengguna/import' , [JenispenggunaSuperadminController::class , 'import']);
Route::post('/datapengguna/import_proses' , [JenispenggunaSuperadminController::class, 'import_proses']);

Route::get('/datapengguna/export_excel' , [JenispenggunaSuperadminController::class, 'export_excel']);
Route::get('/datapengguna/export_pdf' , [JenispenggunaSuperadminController::class, 'export_pdf']);

Route::get('/jenispenguna', [JenispenggunaSuperadminController::class, 'index']);
Route::POST('/jenispenguna/list', [JenispenggunaSuperadminController::class, 'list']);

Route::get('/jenispenguna/create', [JenispenggunaSuperadminController::class, 'create']);
Route::post('/jenispenguna/proses', [JenispenggunaSuperadminController::class, 'store']);

Route::get('/jenispenguna/{id}/edit', [JenispenggunaSuperadminController::class,'edit']);
Route::put('/jenispenguna/{id}/update', [JenispenggunaSuperadminController::class,'update']);

Route::get('/jenispenguna/{id}/confirm', [JenispenggunaSuperadminController::class,'confirm']);
Route::delete('/jenispenguna/{id}/delete', [JenispenggunaSuperadminController::class, 'delete']);

Route::get('/jenispenguna/import' , [JenispenggunaSuperadminController::class , 'import']);
Route::post('/jenispenguna/import_proses' , [JenispenggunaSuperadminController::class, 'import_proses']);

Route::get('/jenispenguna/export_excel' , [JenispenggunaSuperadminController::class, 'export_excel']);
Route::get('/jenispenguna/export_pdf' , [JenispenggunaSuperadminController::class, 'export_pdf']);

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