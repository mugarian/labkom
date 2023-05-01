<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BahanController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PemakaianController;
use App\Http\Controllers\PenggunaanController;
use App\Http\Controllers\BarangHabisController;
use App\Http\Controllers\BarangPakaiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaboratoriumController;

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

Route::get('/', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [loginController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::post('/logout', [loginController::class, 'logout']);
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/profil', [UserController::class, 'profil']);
    Route::resource('/akun', UserController::class);
    Route::middleware('admin')->group(function () {
        Route::resource('/dosen', DosenController::class);
        Route::resource('/mahasiswa', MahasiswaController::class);
        Route::resource('/staff', StaffController::class);
    });

    Route::resource('/alat', AlatController::class);
    Route::resource('/bahan', BahanController::class);
    Route::resource('/laboratorium', LaboratoriumController::class);
    Route::resource('/barangpakai', BarangPakaiController::class);
    Route::resource('/baranghabis', barangHabisController::class);

    // Route::get('/barangpakai/create/{id}', [BarangPakaiController::class, 'tambah'])->middleware('dosen');
    // Route::resource('/barangpakai', BarangPakaiController::class);
    // Route::get('/baranghabis/create/{id}', [BarangHabisController::class, 'create'])->middleware('dosen');
    // Route::resource('/baranghabis', BarangHabisController::class);

    Route::get('/kegiatan/pelaksanaan', [KegiatanController::class, 'pelaksanaan'])->middleware('dosen');
    Route::post('/pelaksanaan', [KegiatanController::class, 'storePelaksanaan']);
    Route::get('/kegiatan/permohonan', [KegiatanController::class, 'permohonan']);
    Route::post('/permohonan', [KegiatanController::class, 'storePermohonan']);
    Route::post('/kegiatan/{id}/status', [KegiatanController::class, 'status'])->middleware('dosen');
    Route::resource('/kegiatan', KegiatanController::class);

    Route::get('/pemakaian/{id}/pakai', [PemakaianController::class, 'pakai']);
    Route::resource('/pemakaian', PemakaianController::class);
    Route::get('/penggunaan/{id}/guna', [PenggunaanController::class, 'guna']);
    Route::post('/penggunaan/{id}/status', [PenggunaanController::class, 'status'])->middleware('dosen');
    Route::resource('/penggunaan', PenggunaanController::class);

    Route::get('/scan', [ScanController::class, 'index']);
    Route::post('/scan', [ScanController::class, 'search']);
    Route::get('/scan/{kode}', [ScanController::class, 'scan'])->name('scan');
});
