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