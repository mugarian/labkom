<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\User;
use App\Models\Bahan;
use App\Models\Dosen;
use App\Models\Staff;
use App\Models\Kegiatan;
use App\Models\Mahasiswa;
use App\Models\Pemakaian;
use App\Models\Penggunaan;
use App\Models\BarangHabis;
use App\Models\BarangPakai;
use App\Models\Laboratorium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::find(auth()->user()->id);
        $dosen = Dosen::all();
        $mahasiswa = Mahasiswa::all();
        $staff = Staff::all();
        $alat = Alat::all();
        $bahan = Bahan::all();
        $laboratorium = Laboratorium::all();
        $barangpakai = BarangPakai::all();
        $baranghabis = BarangHabis::all();

        if ($user->role == 'admin') {
            $kegiatan = Kegiatan::all()->count();
            $ksetuju = Kegiatan::where('status', 'disetujui')->count();
            $kverif = Kegiatan::where('status', 'diverifikasi')->count();
            $ktolak = Kegiatan::where('status', 'ditolak')->count();
            $ktunggu = Kegiatan::where('status', 'menunggu')->count();

            $pemakaian = Pemakaian::all()->count();
            $pkmulai = Pemakaian::where('status', 'mulai')->count();
            $pkselesai = Pemakaian::where('status', 'selesai')->count();

            $penggunaan = Penggunaan::all()->count();
            $pgsetuju = Penggunaan::where('status', 'disetujui')->count();
            $pgtolak = Penggunaan::where('status', 'ditolak')->count();
            $pgtunggu = Penggunaan::where('status', 'menunggu')->count();
        } elseif ($user->role == 'dosen') {
            $dosen = Dosen::where('user_id', $user->id)->first();
            if ($dosen->kepalalab == 'true') {
                $laboratorium = Laboratorium::where('user_id', $user->id)->first();

                $kegiatan = Kegiatan::where('user_id', $user->id)->orWhere('dospem_id', $dosen->id)->orWhere('laboratorium_id', $laboratorium->id)->count();
                $ksetuju = Kegiatan::where('user_id', $user->id)->where('status', 'disetujui')->orWhere('dospem_id', $dosen->id)->where('status', 'disetujui')->orWhere('laboratorium_id', $laboratorium->id)->where('status', 'disetujui')->count();
                $kverif = Kegiatan::where('user_id', $user->id)->where('status', 'diverifikasi')->orWhere('dospem_id', $dosen->id)->where('status', 'diverifikasi')->orWhere('laboratorium_id', $laboratorium->id)->where('status', 'diverifikasi')->count();
                $ktolak = Kegiatan::where('user_id', $user->id)->where('status', 'ditolak')->orWhere('dospem_id', $dosen->id)->where('status', 'ditolak')->orWhere('laboratorium_id', $laboratorium->id)->where('status', 'ditolak')->count();
                $ktunggu = Kegiatan::where('user_id', $user->id)->where('status', 'menunggu')->orWhere('dospem_id', $dosen->id)->where('status', 'menunggu')->orWhere('laboratorium_id', $laboratorium->id)->where('status', 'menunggu')->count();

                $pemakaian = DB::table('pemakaians')
                    ->join('kegiatans', 'pemakaians.kegiatan_id', '=', 'kegiatans.id')
                    ->join('users', 'pemakaians.user_id', '=', 'users.id')
                    ->join('barang_pakais', 'pemakaians.barangpakai_id', '=', 'barang_pakais.id')
                    ->join('laboratorium', 'barang_pakais.laboratorium_id', '=', 'laboratorium.id')
                    ->where('laboratorium.id', '=', $laboratorium->id)
                    ->count();
                $pkmulai = DB::table('pemakaians')
                    ->join('kegiatans', 'pemakaians.kegiatan_id', '=', 'kegiatans.id')
                    ->join('users', 'pemakaians.user_id', '=', 'users.id')
                    ->join('barang_pakais', 'pemakaians.barangpakai_id', '=', 'barang_pakais.id')
                    ->join('laboratorium', 'barang_pakais.laboratorium_id', '=', 'laboratorium.id')
                    ->where('laboratorium.id', '=', $laboratorium->id)
                    ->where('pemakaians.status', 'mulai')
                    ->count();
                $pkselesai = DB::table('pemakaians')
                    ->join('kegiatans', 'pemakaians.kegiatan_id', '=', 'kegiatans.id')
                    ->join('users', 'pemakaians.user_id', '=', 'users.id')
                    ->join('barang_pakais', 'pemakaians.barangpakai_id', '=', 'barang_pakais.id')
                    ->join('laboratorium', 'barang_pakais.laboratorium_id', '=', 'laboratorium.id')
                    ->where('laboratorium.id', '=', $laboratorium->id)
                    ->where('pemakaians.status', 'selesai')
                    ->count();

                // $penggunaan = Penggunaan::where('user_id', $user->id)->count();
                // $pgsetuju = Penggunaan::where('user_id', $user->id)->where('status', 'disetujui')->count();
                // $pgtolak = Penggunaan::where('user_id', $user->id)->where('status', 'ditolak')->count();
                // $pgtunggu = Penggunaan::where('user_id', $user->id)->where('status', 'menunggu')->count();
                $penggunaan = DB::table('penggunaans')
                    ->join('kegiatans', 'penggunaans.kegiatan_id', '=', 'kegiatans.id')
                    ->join('users', 'penggunaans.user_id', '=', 'users.id')
                    ->join('barang_habis', 'penggunaans.baranghabis_id', '=', 'barang_habis.id')
                    ->join('laboratorium', 'barang_habis.laboratorium_id', '=', 'laboratorium.id')
                    ->where('laboratorium.id', '=', $laboratorium->id)
                    ->count();
                $pgsetuju = DB::table('penggunaans')
                    ->join('kegiatans', 'penggunaans.kegiatan_id', '=', 'kegiatans.id')
                    ->join('users', 'penggunaans.user_id', '=', 'users.id')
                    ->join('barang_habis', 'penggunaans.baranghabis_id', '=', 'barang_habis.id')
                    ->join('laboratorium', 'barang_habis.laboratorium_id', '=', 'laboratorium.id')
                    ->where('laboratorium.id', '=', $laboratorium->id)
                    ->where('penggunaans.status', 'disetujui')
                    ->count();
                $pgtolak = DB::table('penggunaans')
                    ->join('kegiatans', 'penggunaans.kegiatan_id', '=', 'kegiatans.id')
                    ->join('users', 'penggunaans.user_id', '=', 'users.id')
                    ->join('barang_habis', 'penggunaans.baranghabis_id', '=', 'barang_habis.id')
                    ->join('laboratorium', 'barang_habis.laboratorium_id', '=', 'laboratorium.id')
                    ->where('laboratorium.id', '=', $laboratorium->id)
                    ->where('penggunaans.status', 'ditolak')
                    ->count();
                $pgtunggu = DB::table('penggunaans')
                    ->join('kegiatans', 'penggunaans.kegiatan_id', '=', 'kegiatans.id')
                    ->join('users', 'penggunaans.user_id', '=', 'users.id')
                    ->join('barang_habis', 'penggunaans.baranghabis_id', '=', 'barang_habis.id')
                    ->join('laboratorium', 'barang_habis.laboratorium_id', '=', 'laboratorium.id')
                    ->where('laboratorium.id', '=', $laboratorium->id)
                    ->where('penggunaans.status', 'menunggu')
                    ->count();
            } elseif ($dosen->jabatan == 'dosen pengampu') {
                $kegiatan = Kegiatan::where('user_id', $user->id)->orWhere('dospem_id', $dosen->id)->count();
                $ksetuju = Kegiatan::where('user_id', $user->id)->where('status', 'disetujui')->orWhere('dospem_id', $dosen->id)->where('status', 'disetujui')->count();
                $kverif = Kegiatan::where('user_id', $user->id)->where('status', 'diverifikasi')->orWhere('dospem_id', $dosen->id)->where('status', 'diverifikasi')->count();
                $ktolak = Kegiatan::where('user_id', $user->id)->where('status', 'ditolak')->orWhere('dospem_id', $dosen->id)->where('status', 'ditolak')->count();
                $ktunggu = Kegiatan::where('user_id', $user->id)->where('status', 'menunggu')->orWhere('dospem_id', $dosen->id)->where('status', 'menunggu')->count();

                $pemakaian = Pemakaian::where('user_id', $user->id)->count();
                $pkmulai = Pemakaian::where('user_id', $user->id)->where('status', 'mulai')->count();
                $pkselesai = Pemakaian::where('user_id', $user->id)->where('status', 'selesai')->count();

                $penggunaan = Penggunaan::where('user_id', $user->id)->count();
                $pgsetuju = Penggunaan::where('user_id', $user->id)->where('status', 'disetujui')->count();
                $pgtolak = Penggunaan::where('user_id', $user->id)->where('status', 'ditolak')->count();
                $pgtunggu = Penggunaan::where('user_id', $user->id)->where('status', 'menunggu')->count();
            } else {
                $kegiatan = Kegiatan::all()->count();
                $ksetuju = Kegiatan::where('status', 'disetujui')->count();
                $kverif = Kegiatan::where('status', 'diverifikasi')->count();
                $ktolak = Kegiatan::where('status', 'ditolak')->count();
                $ktunggu = Kegiatan::where('status', 'menunggu')->count();

                $pemakaian = Pemakaian::all()->count();
                $pkmulai = Pemakaian::where('status', 'mulai')->count();
                $pkselesai = Pemakaian::where('status', 'selesai')->count();

                $penggunaan = Penggunaan::all()->count();
                $pgsetuju = Penggunaan::where('status', 'disetujui')->count();
                $pgtolak = Penggunaan::where('status', 'ditolak')->count();
                $pgtunggu = Penggunaan::where('status', 'menunggu')->count();
            }
        } else {
            $kegiatan = Kegiatan::where('user_id', $user->id)->count();
            $ksetuju = Kegiatan::where('user_id', $user->id)->where('status', 'disetujui')->count();
            $kverif = Kegiatan::where('user_id', $user->id)->where('status', 'diverifikasi')->count();
            $ktolak = Kegiatan::where('user_id', $user->id)->where('status', 'ditolak')->count();
            $ktunggu = Kegiatan::where('user_id', $user->id)->where('status', 'menunggu')->count();

            $pemakaian = Pemakaian::where('user_id', $user->id)->count();
            $pkmulai = Pemakaian::where('user_id', $user->id)->where('status', 'mulai')->count();
            $pkselesai = Pemakaian::where('user_id', $user->id)->where('status', 'selesai')->count();

            $penggunaan = Penggunaan::where('user_id', $user->id)->count();
            $pgsetuju = Penggunaan::where('user_id', $user->id)->where('status', 'disetujui')->count();
            $pgtolak = Penggunaan::where('user_id', $user->id)->where('status', 'ditolak')->count();
            $pgtunggu = Penggunaan::where('user_id', $user->id)->where('status', 'menunggu')->count();
        }
        return view('v_dashboard', [
            'title' => 'Sistem Pengelolaan Barang & Ruangan',
            'dosen' => $dosen,
            'mahasiswa' => $mahasiswa,
            'staff' => $staff,
            'alat' => $alat,
            'bahan' => $bahan,
            'laboratorium' => $laboratorium,
            'baranghabis' => $baranghabis,
            'barangpakai' => $barangpakai,
            'kegiatan' => $kegiatan,
            'ksetuju' => $ksetuju,
            'ktolak' => $ktolak,
            'kverif' => $kverif,
            'ktunggu' => $ktunggu,
            'pemakaian' => $pemakaian,
            'pkmulai' => $pkmulai,
            'pkselesai' => $pkselesai,
            'penggunaan' => $penggunaan,
            'pgsetuju' => $pgsetuju,
            'pgtolak' => $pgtolak,
            'pgtunggu' => $pgtunggu,
        ]);
    }
}
