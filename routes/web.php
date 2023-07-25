<?php

use App\Models\BarangPakai;
use App\Models\BahanPraktikum;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\PrediksiController;
use App\Http\Controllers\AlgoritmaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PemakaianController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PenggunaanController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\BarangHabisController;
use App\Http\Controllers\BarangPakaiController;
use App\Http\Controllers\PelaksanaanController;
use App\Http\Controllers\BahanJurusanController;
use App\Http\Controllers\LaboratoriumController;
use App\Http\Controllers\BahanPraktikumController;
use App\Http\Controllers\PeminjamanAlatController;
use App\Http\Controllers\PeminjamanBahanController;

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
Route::post('/', [LoginController::class, 'login']);
Route::get('/sso/login', [AuthController::class, 'getLogin'])->name('sso.login');
Route::get('/callback', [AuthController::class, 'getCallback'])->name('sso.callback');
Route::get('/sso/connect', [AuthController::class, 'connectUser'])->name('sso.connect');

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
    Route::resource('/barangpakai', BarangPakaiController::class);
    Route::resource('/bahanpraktikum', BahanPraktikumController::class);
    Route::resource('/bahanjurusan', BahanJurusanController::class);
    Route::resource('/laboratorium', LaboratoriumController::class);
    Route::resource('/kelas', KelasController::class);

    Route::resource('pelaksanaan', PelaksanaanController::class);

    Route::resource('training', AlgoritmaController::class);
    Route::get('rule', [AlgoritmaController::class, 'rule']);
    Route::resource('prediksi', PrediksiController::class);

    Route::get('permohonan/{id}/ditolak', [PermohonanController::class, 'ditolak']);
    Route::post('permohonan/{id}/ditolak', [PermohonanController::class, 'updateDitolak']);
    Route::resource('permohonan', PermohonanController::class);

    Route::get('/pemakaian/{id}/kegiatan', [PemakaianController::class, 'kegiatan']);
    Route::get('/pemakaian/{id}/pakai', [PemakaianController::class, 'pakai']);
    Route::resource('pemakaian', PemakaianController::class);

    Route::get('penggunaan/{id}/ditolak', [PenggunaanController::class, 'ditolak']);
    Route::post('penggunaan/{id}/ditolak', [PenggunaanController::class, 'updateDitolak']);
    Route::get('/penggunaan/{id}/guna', [PenggunaanController::class, 'guna']);
    Route::get('/penggunaan/{id}/kegiatan', [PenggunaanController::class, 'kegiatan']);
    Route::resource('penggunaan', PenggunaanController::class);

    Route::get('peminjamanalat/{id}/ditolak', [PeminjamanAlatController::class, 'ditolak']);
    Route::post('peminjamanalat/{id}/ditolak', [PeminjamanAlatController::class, 'updateDitolak']);
    Route::get('peminjamanalat/{id}/pinjam', [PeminjamanAlatController::class, 'pinjam']);
    Route::post('peminjamanalat/{id}/status', [PeminjamanAlatController::class, 'status']);
    Route::resource('peminjamanalat', PeminjamanAlatController::class);

    Route::get('peminjamanbahan/{id}/ditolak', [PeminjamanBahanController::class, 'ditolak']);
    Route::post('peminjamanbahan/{id}/ditolak', [PeminjamanBahanController::class, 'updateDitolak']);
    Route::get('peminjamanbahan/{id}/pinjam', [PeminjamanBahanController::class, 'pinjam']);
    Route::post('peminjamanbahan/{id}/status', [PeminjamanBahanController::class, 'status']);
    Route::resource('peminjamanbahan', PeminjamanBahanController::class);

    Route::get('/scan', [ScanController::class, 'index']);
    Route::post('/scan', [ScanController::class, 'search']);
    Route::get('/scan/{kode}', [ScanController::class, 'scan'])->name('scan');

    Route::get('/barangpakai/create/{id}', [BarangPakaiController::class, 'tambah']);

    Route::post('/import/training', [AlgoritmaController::class, 'import'])->name('importTraining');
    Route::post('/import/prediksi', [PrediksiController::class, 'import'])->name('importPrediksi');
});
