<?php

use App\Http\Controllers\C_User;
use App\Http\Controllers\C_Kelas;
use App\Http\Controllers\C_login;
use App\Http\Controllers\C_Barang;
use App\Http\Controllers\C_KodeQR;
use App\Http\Controllers\C_Ruangan;
use App\Http\Controllers\C_Peminjaman;
use App\Http\Controllers\C_Pemakaian;
use App\Http\Controllers\C_ScanQR;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function() {
    return view('v_login');
});

Route::get('/dashboard', function() {
    return view('v_dashboard');
});

Route::post('/', [C_login::class, 'login']);
Route::post('/logout', [C_login::class, 'logout']);

Route::resource('/akun', C_User::class);
Route::get('/profil', [C_User::class, 'profil']);

Route::resource('/barang', C_Barang::class);
Route::resource('/ruangan', C_Ruangan::class);

Route::resource('/kodeqr', C_KodeQR::class);
Route::get('/kodeqr/{slug}/cetak', [C_kodeQR::class, 'cetak']);

Route::resource('/kelas', C_Kelas::class);

Route::resource('/peminjaman', C_Peminjaman::class);
Route::get('/peminjaman/{slug}/verifikasi', [C_Peminjaman::class, 'verifikasi']);
Route::post('/peminjaman/{slug}/konfirmasi', [C_Peminjaman::class, 'konfirmasi']);
Route::get('/peminjaman/{slug}/kembalikan', [C_Peminjaman::class, 'kembalikan']);
Route::post('/peminjaman/{slug}/kondisi', [C_Peminjaman::class, 'kondisi']);
Route::get('/peminjaman/{slug}/cetak', [C_Peminjaman::class, 'cetak']);

Route::resource('/pemakaian', C_Pemakaian::class);
Route::get('/pemakaian/{slug}/verifikasi', [C_Pemakaian::class, 'verifikasi']);
Route::get('/pemakaian/{slug}/konfirmasi', [C_Pemakaian::class, 'konfirmasi']);
Route::get('/pemakaian/{slug}/selesai', [C_Pemakaian::class, 'selesai']);
Route::post('/pemakaian/{slug}/kondisi', [C_Pemakaian::class, 'kondisi']);
Route::get('/pemakaian/{slug}/cetak', [C_Pemakaian::class, 'cetak']);

Route::resource('/pelaporan', C_Pelaporan::class);
Route::get('/pelaporan/{slug}/verifikasi', [C_Pelaporan::class, 'verifikasi']);
Route::post('/pelaporan/{slug}/konfirmasi', [C_Pelaporan::class, 'konfirmasi']);
Route::get('/pelaporan/{slug}/cetak', [C_Pelaporan::class, 'cetak']);

Route::get('/scan/{kode}', [C_ScanQR::class, 'scan']);
Route::post('/scan/lapor', [C_ScanQR::class, 'lapor']);
Route::get('/scan/{kode}/pelaporan', [C_ScanQR::class, 'pelaporan']);
Route::post('/scan/{kode}/melaporkan', [C_ScanQR::class, 'melaporkan']);
Route::get('/scan/{kode}/peminjaman', [C_ScanQR::class, 'peminjaman']);
Route::post('/scan/{kode}/meminjamkan', [C_ScanQR::class, 'meminjamkan']);
Route::get('/scan/{kode}/pemakaian', [C_ScanQR::class, 'pemakaian']);
Route::post('/scan/{kode}/memakai', [C_ScanQR::class, 'memakai']);
