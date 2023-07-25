<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\User;
use App\Models\Bahan;
use App\Models\BahanJurusan;
use App\Models\BahanPraktikum;
use App\Models\BarangPakai;
use App\Models\Dosen;
use App\Models\Staff;
use App\Models\Kegiatan;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\Pemakaian;
use App\Models\Penggunaan;
use App\Models\Laboratorium;
use App\Models\PeminjamanAlat;
use App\Models\PeminjamanBahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::find(auth()->user()->id);
        $dosen = Dosen::all();
        $mahasiswa = Mahasiswa::all();
        $alat = Alat::all();
        $barangpakai = BarangPakai::all();
        $bahanpraktikum = BahanPraktikum::all();
        $bahanjurusan = BahanJurusan::all();
        $laboratorium = Laboratorium::all();
        $kelas = Kelas::all();

        $lab = '';

        if ($user->role == 'admin') {
            $role = 'admin';

            $pelaksanaan = Kegiatan::where('jenis', 'pelaksanaan')->orderBy('updated_at', 'desc')->limit(5)->get();

            $permohonan = Kegiatan::where('jenis', 'permohonan')->orderBy('updated_at', 'desc')->limit(5)->get();

            $palat = PeminjamanAlat::orderBy('updated_at', 'desc')->limit(5)->get();

            $pbahan = PeminjamanBahan::orderBy('updated_at', 'desc')->limit(5)->get();

            $pemakaian = Pemakaian::orderBy('updated_at', 'desc')->limit(5)->get();
            $penggunaan = Penggunaan::orderBy('updated_at', 'desc')->limit(5)->get();
        } elseif ($user->role == 'dosen') {
            $dosen = Dosen::where('user_id', $user->id)->first();
            $role = 'dosen';
            if ($dosen->kepalalab == 'true') {
                $role = 'kalab';
                $laboratorium = Laboratorium::where('user_id', $user->id)->first();
                $lab = $laboratorium->nama;
                $pelaksanaan = Kegiatan::where('user_id', $user->id)->where('jenis', 'pelaksanaan')->orWhere('dospem_id', $dosen->id)->orWhere('laboratorium_id', $laboratorium->id)->orderBy('updated_at', 'desc')->limit(5)->get();

                $permohonan = Kegiatan::where('user_id', $user->id)->where('jenis', 'permohonan')->orWhere('dospem_id', $dosen->id)->orWhere('laboratorium_id', $laboratorium->id)->orderBy('updated_at', 'desc')->limit(5)->get();

                $palat = DB::table('peminjaman_alats')
                    ->join('barang_pakais', 'peminjaman_alats.barangpakai_id', '=', 'barang_pakais.id')
                    ->join('users', 'peminjaman_alats.user_id', '=', 'users.id')
                    ->join('laboratorium', 'barang_pakais.laboratorium_id', '=', 'laboratorium.id')
                    ->where('peminjaman_alats.user_id', '=', $user->id)
                    ->orWhere('laboratorium.id', '=', $laboratorium->id)
                    ->select('users.nama as namauser', 'peminjaman_alats.updated_at as updated_at', 'barang_pakais.nama as namabarang', 'peminjaman_alats.status as status', 'peminjaman_alats.id as id', 'barang_pakais.foto as foto', 'peminjaman_alats.deskripsi as deskripsi')
                    ->orderBy('peminjaman_alats.updated_at', 'desc')
                    ->limit(5)
                    ->get();

                $pbahan = DB::table('peminjaman_bahans')
                    ->join('bahan_jurusans', 'peminjaman_bahans.bahanjurusan_id', '=', 'bahan_jurusans.id')
                    ->join('users', 'peminjaman_bahans.user_id', '=', 'users.id')
                    ->join('laboratorium', 'bahan_jurusans.laboratorium_id', '=', 'laboratorium.id')
                    ->where('peminjaman_bahans.user_id', '=', $user->id)
                    ->orWhere('laboratorium.id', '=', $laboratorium->id)
                    ->select('users.nama as namauser', 'peminjaman_bahans.updated_at as updated_at', 'bahan_jurusans.nama as namabarang', 'peminjaman_bahans.status as status', 'peminjaman_bahans.id as id', 'bahan_jurusans.foto as foto', 'peminjaman_bahans.deskripsi as deskripsi')
                    ->orderBy('peminjaman_bahans.updated_at', 'desc')
                    ->limit(5)
                    ->get();

                $pemakaian = DB::table('pemakaians')
                    ->join('kegiatans', 'pemakaians.kegiatan_id', '=', 'kegiatans.id')
                    ->join('users', 'pemakaians.user_id', '=', 'users.id')
                    ->join('barang_pakais', 'pemakaians.barangpakai_id', '=', 'barang_pakais.id')
                    ->join('laboratorium', 'barang_pakais.laboratorium_id', '=', 'laboratorium.id')
                    ->where('laboratorium.id', '=', $laboratorium->id)
                    ->select('users.nama as namauser', 'pemakaians.created_at as created_at', 'barang_pakais.nama as namabarang', 'kegiatans.nama as namakegiatan', 'pemakaians.status as status', 'pemakaians.id as id', 'barang_pakais.foto as foto')
                    ->orderBy('pemakaians.updated_at', 'desc')
                    ->limit(5)
                    ->get();

                $penggunaan = DB::table('penggunaans')
                    ->join('kegiatans', 'penggunaans.kegiatan_id', '=', 'kegiatans.id')
                    ->join('users', 'penggunaans.user_id', '=', 'users.id')
                    ->join('bahan_praktikums', 'penggunaans.bahanpraktikum_id', '=', 'bahan_praktikums.id')
                    ->join('laboratorium', 'bahan_praktikums.laboratorium_id', '=', 'laboratorium.id')
                    ->where('laboratorium.id', '=', $laboratorium->id)
                    ->select('users.nama as namauser', 'penggunaans.created_at as created_at', 'bahan_praktikums.nama as namabahan', 'kegiatans.nama as namakegiatan', 'penggunaans.id as id', 'bahan_praktikums.foto as foto')
                    ->orderBy('penggunaans.updated_at', 'desc')
                    ->limit(5)
                    ->get();
            } elseif ($dosen->jabatan == 'dosen pengampu') {
                $role = 'dosen';
                $pelaksanaan = Kegiatan::where('jenis', 'pelaksanaan')->where('user_id', $user->id)->orWhere('dospem_id', $dosen->id)->orderBy('updated_at', 'desc')->limit(5)->get();

                $permohonan = Kegiatan::where('jenis', 'permohonan')->where('user_id', $user->id)->orWhere('dospem_id', $dosen->id)->orderBy('updated_at', 'desc')->limit(5)->get();

                $palat = DB::table('peminjaman_alats')
                    ->join('barang_pakais', 'peminjaman_alats.barangpakai_id', '=', 'barang_pakais.id')
                    ->join('users', 'peminjaman_alats.user_id', '=', 'users.id')
                    ->join('laboratorium', 'barang_pakais.laboratorium_id', '=', 'laboratorium.id')
                    ->where('peminjaman_alats.user_id', '=', $user->id)
                    ->select('users.nama as namauser', 'peminjaman_alats.updated_at as updated_at', 'barang_pakais.nama as namabarang', 'peminjaman_alats.status as status', 'peminjaman_alats.id as id', 'barang_pakais.foto as foto', 'peminjaman_alats.deskripsi as deskripsi')
                    ->orderBy('peminjaman_alats.updated_at', 'desc')
                    ->limit(5)
                    ->get();

                $pbahan = DB::table('peminjaman_bahans')
                    ->join('bahan_jurusans', 'peminjaman_bahans.bahanjurusan_id', '=', 'bahan_jurusans.id')
                    ->join('users', 'peminjaman_bahans.user_id', '=', 'users.id')
                    ->join('laboratorium', 'bahan_jurusans.laboratorium_id', '=', 'laboratorium.id')
                    ->where('peminjaman_bahans.user_id', '=', $user->id)
                    ->select('users.nama as namauser', 'peminjaman_bahans.updated_at as updated_at', 'bahan_jurusans.nama as namabarang', 'peminjaman_bahans.status as status', 'peminjaman_bahans.id as id', 'bahan_jurusans.foto as foto', 'peminjaman_bahans.deskripsi as deskripsi')
                    ->orderBy('peminjaman_bahans.updated_at', 'desc')
                    ->limit(5)
                    ->get();

                $pemakaian = Pemakaian::where('user_id', $user->id)->orderBy('updated_at', 'desc')->limit(5)->get();

                $penggunaan = Penggunaan::where('user_id', $user->id)->orderBy('updated_at', 'desc')->limit(5)->get();
            } else {
                // ADMIN DAN KAJUR
                $role = 'admin';

                $pelaksanaan = Kegiatan::where('jenis', 'pelaksanaan')->orderBy('updated_at', 'desc')->limit(5)->get();

                $permohonan = Kegiatan::where('jenis', 'permohonan')->orderBy('updated_at', 'desc')->limit(5)->get();

                $palat = PeminjamanAlat::orderBy('updated_at', 'desc')->limit(5)->get();

                $pbahan = PeminjamanBahan::orderBy('updated_at', 'desc')->limit(5)->get();

                $pemakaian = Pemakaian::orderBy('updated_at', 'desc')->limit(5)->get();
                $penggunaan = Penggunaan::orderBy('updated_at', 'desc')->limit(5)->get();
            }
        } else {
            $role = 'mahasiswa';
            $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
            $pelaksanaan = Kegiatan::where('jenis', 'pelaksanaan')->where('kelas_id', $mahasiswa->kelas_id)->orderBy('updated_at', 'desc')->limit(5)->get();

            $permohonan = Kegiatan::where('jenis', 'permohonan')->orWhere('user_id', $user->id)->orderBy('updated_at', 'desc')->limit(5)->get();

            $palat = PeminjamanAlat::where('user_id', $user->id)->orderBy('updated_at', 'desc')->limit(5)->get();

            $pbahan = PeminjamanBahan::where('user_id', $user->id)->orderBy('updated_at', 'desc')->limit(5)->get();

            $pemakaian = Pemakaian::where('user_id', $user->id)->orderBy('updated_at', 'desc')->limit(5)->get();
            $penggunaan = Penggunaan::where('user_id', $user->id)->orderBy('updated_at', 'desc')->limit(5)->get();;
        }

        // return dd($pemakaian[0]->barangpakai->foto);

        // return dd($palat);
        return view('v_dashboard', [
            'title' => 'Sistem Informasi Manajemen Administrasi Laboratorium Komputer',
            'dosen' => $dosen,
            'mahasiswa' => $mahasiswa,
            'alat' => $alat,
            'barangpakai' => $barangpakai,
            'bahanpraktikum' => $bahanpraktikum,
            'bahanjurusan' => $bahanjurusan,
            'laboratorium' => $laboratorium,
            'kelas' => $kelas,
            'palat' => $palat,
            'pbahan' => $pbahan,
            'pelaksanaans' => $pelaksanaan,
            'permohonans' => $permohonan,
            'pemakaian' => $pemakaian,
            'penggunaan' => $penggunaan,
            'role' => $role,
            'lab' => $lab
        ]);
    }
}
