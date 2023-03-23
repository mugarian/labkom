<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BahanController;
use App\Http\Controllers\BarangHabisController;
use App\Http\Controllers\BarangPakaiController;
use App\Http\Controllers\loginController;
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
Route::post('/logout', [loginController::class, 'logout']);

Route::get('/dashboard', function () {
    return view('v_dashboard', [
        'title' => 'Sistem Pengelolaan Barang & Ruangan'
    ]);
})->name('home')->middleware('auth');

Route::get('/profil', [UserController::class, 'profil']);
Route::resource('/akun', UserController::class);

Route::get('/scan', function () {
    return view('v_scanqr.index', [
        'title' => 'Scan QR',
    ]);
});

Route::resource('/alat', AlatController::class);
Route::resource('/bahan', BahanController::class);
Route::resource('/laboratorium', LaboratoriumController::class);
Route::get('/barangpakai/create/{id}', [BarangPakaiController::class, 'create']);
Route::resource('/barangpakai', BarangPakaiController::class);
Route::get('/baranghabis/create/{id}', [BarangHabisController::class, 'create']);
Route::resource('/baranghabis', BarangHabisController::class);
