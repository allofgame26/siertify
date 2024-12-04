<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PengajuanPelatihanPimpinanController;
use App\Http\Controllers\PengajuanSertifikasiPimpinanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Begin AdminLte
Route::get('/pengajuan', [PengajuanPelatihanPimpinanController::class, 'index']);
Route::get('/', [WelcomeController::class, 'index']);

// jenis pelatihan dan sertifikasi
Route::get('/pengajuan', [PengajuanPelatihanPimpinanController::class, 'index']);  // menampilkan halaman jenis
Route::post('/pengajuan/list', [PengajuanPelatihanPimpinanController::class, 'list'] );    //menampilkan data jenis dalam bentuk json datatables
Route::post('/pengajuan/ajax', [PengajuanPelatihanPimpinanController::class, 'store_ajax']); // Menyimpan data jenis baru Ajax 
Route::get('/pengajuan/{id}/edit_ajax', [PengajuanPelatihanPimpinanController::class,'edit_ajax']); //menampilkan halaman form edit jenis ajax
Route::put('/pengajuan/{id}/update_ajax', [PengajuanPelatihanPimpinanController::class,'update_ajax']);   //menyimpan halaman form edit jenis ajax
Route::get('/pengajuan/export_excel', [PengajuanPelatihanPimpinanController::class, 'export_excel']);  //export excel
Route::get('/pengajuan/export_pdf', [PengajuanPelatihanPimpinanController::class, 'export_pdf']); //export pdf
Route::get('/{id}/show_ajax', [PengajuanPelatihanPimpinanController::class, 'show_ajax']); //show_ajax

// jenis pelatihan dan sertifikasi
Route::get('/sertifikasi', [PengajuanSertifikasiPimpinanController::class, 'index']);  // menampilkan halaman jenis
Route::post('/sertifikasi/list', [PengajuanSertifikasiPimpinanController::class, 'list'] );    //menampilkan data jenis dalam bentuk json datatables
Route::post('/sertifikasi/ajax', [PengajuanSertifikasiPimpinanController::class, 'store_ajax']); // Menyimpan data jenis baru Ajax 
Route::get('/sertifikasi/{id}/edit_ajax', [PengajuanSertifikasiPimpinanController::class,'edit_ajax']); //menampilkan halaman form edit jenis ajax
Route::put('/sertifkasi/{id}/update_ajax', [PengajuanSertifikasiPimpinanController::class,'update_ajax']);   //menyimpan halaman form edit jenis ajax
Route::get('/sertifikasi/export_excel', [PengajuanSertifikasiPimpinanController::class, 'export_excel']);  //export excel
Route::get('/sertifikasi/export_pdf', [PengajuanSertifikasiPimpinanController::class, 'export_pdf']); //export pdf
Route::get('/{id}/show_ajax', [PengajuanSertifikasiPimpinanController::class, 'show_ajax']); //show_ajax
