<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\akunpenggunacontroller;

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
Route::get('/',[WelcomeController::class, 'index']);

// Akun Pengguna

Route::get('/akunpengguna', [akunpenggunacontroller::class, 'index']);
Route::POST('/akunpengguna/list', [akunpenggunacontroller::class, 'list']);

Route::get('/akunpengguna/create', [akunpenggunacontroller::class, 'create']);
Route::post('/akunpengguna/proses', [akunpenggunacontroller::class, 'store']);

Route::get('/akunpengguna/{id}/edit', [akunpenggunacontroller::class,'edit']);
Route::put('/akunpengguna/{id}/update', [akunpenggunacontroller::class,'update']);

Route::get('/akunpengguna/{id}/confirm', [akunpenggunacontroller::class,'confirm']);
Route::delete('/akunpengguna/{id}/delete', [akunpenggunacontroller::class, 'delete']);

Route::get('/akunpengguna/import' , [akunpenggunacontroller::class , 'import']);
Route::post('/akunpengguna/import_proses' , [akunpenggunacontroller::class, 'import_proses']);

Route::get('/akunpengguna/export_excel' , [akunpenggunacontroller::class, 'export_excel']);
Route::get('/akunpengguna/export_pdf' , [akunpenggunacontroller::class, 'export_pdf']);