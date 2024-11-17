<?php

// web.php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\JenisPelatihanSertifikasiController;
use App\Http\Controllers\VendorPelatihanController;
use App\Http\Controllers\VendorSertifikasiController;

// Route::get('/', [WelcomeController::class, 'index']);
Route::get('/', [WelcomeController::class, 'index']);

// jenis pelatihan dan sertifikasi
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
