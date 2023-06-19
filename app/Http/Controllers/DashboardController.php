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
        $staff = Staff::all();
        $alat = Alat::all();
        $barangpakai = BarangPakai::all();
        $bahanpraktikum = BahanPraktikum::all();
        $bahanjurusan = BahanJurusan::all();
        $laboratorium = Laboratorium::all();
        $kelas = Kelas::all();

        if ($user->role == 'admin') {
            $kegiatan = Kegiatan::all()->count();

            $pelaksanaan = Kegiatan::where('jenis', 'pelaksanaan')->count();
            $plmenunggu = Kegiatan::where('jenis', 'pelaksanaan')->where('status', 'menunggu')->count();
            $pldisetujui = Kegiatan::where('jenis', 'pelaksanaan')->where('status', 'disetujui')->count();
            $plberlangsung = Kegiatan::where('jenis', 'pelaksanaan')->where('status', 'berlangsung')->count();
            $plselesai = Kegiatan::where('jenis', 'pelaksanaan')->where('status', 'selesai')->count();
            $plditolak = Kegiatan::where('jenis', 'pelaksanaan')->where('status', 'ditolak')->count();

            $permohonan = Kegiatan::where('jenis', 'permohonan')->count();
            $prmenunggu = Kegiatan::where('jenis', 'permohonan')->where('status', 'menunggu')->count();
            $prdisetujui = Kegiatan::where('jenis', 'permohonan')->where('status', 'disetujui')->count();
            $prberlangsung = Kegiatan::where('jenis', 'permohonan')->where('status', 'berlangsung')->count();
            $prselesai = Kegiatan::where('jenis', 'permohonan')->where('status', 'selesai')->count();
            $prditolak = Kegiatan::where('jenis', 'permohonan')->where('status', 'ditolak')->count();

            $palat = PeminjamanAlat::all()->count();
            $pamenunggu = PeminjamanAlat::where('status', 'menunggu')->count();
            $padisetujui = PeminjamanAlat::where('status', 'disetujui')->count();
            $paditolak = PeminjamanAlat::where('status', 'ditolak')->count();
            $paselesai = PeminjamanAlat::where('status', 'selesai')->count();

            $pbahan = PeminjamanBahan::all()->count();
            $pbmenunggu = PeminjamanBahan::where('status', 'menunggu')->count();
            $pbdisetujui = PeminjamanBahan::where('status', 'disetujui')->count();
            $pbditolak = PeminjamanBahan::where('status', 'ditolak')->count();
            $pbselesai = PeminjamanBahan::where('status', 'selesai')->count();

            $pemakaian = Pemakaian::all()->count();
            $pkmulai = Pemakaian::where('status', 'mulai')->count();
            $pkselesai = Pemakaian::where('status', 'selesai')->count();

            $penggunaan = Penggunaan::all()->count();
        } elseif ($user->role == 'dosen') {
            $dosen = Dosen::where('user_id', $user->id)->first();
            if ($dosen->kepalalab == 'true') {
                $laboratorium = Laboratorium::where('user_id', $user->id)->first();

                $pelaksanaan = Kegiatan::where('user_id', $user->id)->where('jenis', 'pelaksanaan')->orWhere('dospem_id', $dosen->id)->orWhere('laboratorium_id', $laboratorium->id)->count();
                $plmenunggu = Kegiatan::where('user_id', $user->id)->where('jenis', 'pelaksanaan')->where('status', 'menunggu')->orWhere('dospem_id', $dosen->id)->orWhere('laboratorium_id', $laboratorium->id)->count();
                $pldisetujui = Kegiatan::where('user_id', $user->id)->where('jenis', 'pelaksanaan')->where('status', 'disetujui')->orWhere('dospem_id', $dosen->id)->orWhere('laboratorium_id', $laboratorium->id)->count();
                $plberlangsung = Kegiatan::where('user_id', $user->id)->where('jenis', 'pelaksanaan')->where('status', 'berlangsung')->orWhere('dospem_id', $dosen->id)->orWhere('laboratorium_id', $laboratorium->id)->count();
                $plselesai = Kegiatan::where('user_id', $user->id)->where('jenis', 'pelaksanaan')->where('status', 'selesai')->orWhere('dospem_id', $dosen->id)->orWhere('laboratorium_id', $laboratorium->id)->count();
                $plditolak = Kegiatan::where('user_id', $user->id)->where('jenis', 'pelaksanaan')->where('status', 'ditolak')->orWhere('dospem_id', $dosen->id)->orWhere('laboratorium_id', $laboratorium->id)->count();

                $permohonan = Kegiatan::where('user_id', $user->id)->where('jenis', 'permohonan')->orWhere('dospem_id', $dosen->id)->orWhere('laboratorium_id', $laboratorium->id)->count();
                $prmenunggu = Kegiatan::where('user_id', $user->id)->where('jenis', 'permohonan')->where('status', 'menunggu')->orWhere('dospem_id', $dosen->id)->orWhere('laboratorium_id', $laboratorium->id)->count();
                $prdisetujui = Kegiatan::where('user_id', $user->id)->where('jenis', 'permohonan')->where('status', 'disetujui')->orWhere('dospem_id', $dosen->id)->orWhere('laboratorium_id', $laboratorium->id)->count();
                $prberlangsung = Kegiatan::where('user_id', $user->id)->where('jenis', 'permohonan')->where('status', 'berlangsung')->orWhere('dospem_id', $dosen->id)->orWhere('laboratorium_id', $laboratorium->id)->count();
                $prselesai = Kegiatan::where('user_id', $user->id)->where('jenis', 'permohonan')->where('status', 'selesai')->orWhere('dospem_id', $dosen->id)->orWhere('laboratorium_id', $laboratorium->id)->count();
                $prditolak = Kegiatan::where('user_id', $user->id)->where('jenis', 'permohonan')->where('status', 'ditolak')->orWhere('dospem_id', $dosen->id)->orWhere('laboratorium_id', $laboratorium->id)->count();

                $palat = DB::table('peminjaman_alats')
                    ->join('barang_pakais', 'peminjaman_alats.barangpakai_id', '=', 'barang_pakais.id')
                    ->join('laboratorium', 'barang_pakais.laboratorium_id', '=', 'laboratorium.id')
                    ->where('peminjaman_alats.user_id', '=', $user->id)
                    ->orWhere('laboratorium.id', '=', $laboratorium->id)
                    ->count();

                $pamenunggu = DB::table('peminjaman_alats')
                    ->join('barang_pakais', 'peminjaman_alats.barangpakai_id', '=', 'barang_pakais.id')
                    ->join('laboratorium', 'barang_pakais.laboratorium_id', '=', 'laboratorium.id')
                    ->where('peminjaman_alats.user_id', '=', $user->id)
                    ->where('peminjaman_alats.status', '=', 'menunggu')
                    ->orWhere('laboratorium.id', '=', $laboratorium->id)
                    ->count();

                $padisetujui = DB::table('peminjaman_alats')
                    ->join('barang_pakais', 'peminjaman_alats.barangpakai_id', '=', 'barang_pakais.id')
                    ->join('laboratorium', 'barang_pakais.laboratorium_id', '=', 'laboratorium.id')
                    ->where('peminjaman_alats.user_id', '=', $user->id)
                    ->where('peminjaman_alats.status', '=', 'disetujui')
                    ->orWhere('laboratorium.id', '=', $laboratorium->id)
                    ->count();

                $paditolak = DB::table('peminjaman_alats')
                    ->join('barang_pakais', 'peminjaman_alats.barangpakai_id', '=', 'barang_pakais.id')
                    ->join('laboratorium', 'barang_pakais.laboratorium_id', '=', 'laboratorium.id')
                    ->where('peminjaman_alats.user_id', '=', $user->id)
                    ->where('peminjaman_alats.status', '=', 'ditolak')
                    ->orWhere('laboratorium.id', '=', $laboratorium->id)
                    ->count();

                $paselesai = DB::table('peminjaman_alats')
                    ->join('barang_pakais', 'peminjaman_alats.barangpakai_id', '=', 'barang_pakais.id')
                    ->join('laboratorium', 'barang_pakais.laboratorium_id', '=', 'laboratorium.id')
                    ->where('peminjaman_alats.user_id', '=', $user->id)
                    ->where('peminjaman_alats.status', '=', 'selesai')
                    ->orWhere('laboratorium.id', '=', $laboratorium->id)
                    ->count();

                $pbahan = DB::table('peminjaman_bahans')
                    ->join('bahan_jurusans', 'peminjaman_bahans.bahanjurusan_id', '=', 'bahan_jurusans.id')
                    ->join('laboratorium', 'bahan_jurusans.laboratorium_id', '=', 'laboratorium.id')
                    ->where('peminjaman_bahans.user_id', '=', $user->id)
                    ->orWhere('laboratorium.id', '=', $laboratorium->id)
                    ->count();

                $pbmenunggu = DB::table('peminjaman_bahans')
                    ->join('bahan_jurusans', 'peminjaman_bahans.bahanjurusan_id', '=', 'bahan_jurusans.id')
                    ->join('laboratorium', 'bahan_jurusans.laboratorium_id', '=', 'laboratorium.id')
                    ->where('peminjaman_bahans.user_id', '=', $user->id)
                    ->where('peminjaman_bahans.status', '=', 'menunggu')
                    ->orWhere('laboratorium.id', '=', $laboratorium->id)
                    ->count();

                $pbdisetujui = DB::table('peminjaman_bahans')
                    ->join('bahan_jurusans', 'peminjaman_bahans.bahanjurusan_id', '=', 'bahan_jurusans.id')
                    ->join('laboratorium', 'bahan_jurusans.laboratorium_id', '=', 'laboratorium.id')
                    ->where('peminjaman_bahans.user_id', '=', $user->id)
                    ->where('peminjaman_bahans.status', '=', 'disetujui')
                    ->orWhere('laboratorium.id', '=', $laboratorium->id)
                    ->count();

                $pbditolak = DB::table('peminjaman_bahans')
                    ->join('bahan_jurusans', 'peminjaman_bahans.bahanjurusan_id', '=', 'bahan_jurusans.id')
                    ->join('laboratorium', 'bahan_jurusans.laboratorium_id', '=', 'laboratorium.id')
                    ->where('peminjaman_bahans.user_id', '=', $user->id)
                    ->where('peminjaman_bahans.status', '=', 'ditolak')
                    ->orWhere('laboratorium.id', '=', $laboratorium->id)
                    ->count();

                $pbselesai = DB::table('peminjaman_bahans')
                    ->join('bahan_jurusans', 'peminjaman_bahans.bahanjurusan_id', '=', 'bahan_jurusans.id')
                    ->join('laboratorium', 'bahan_jurusans.laboratorium_id', '=', 'laboratorium.id')
                    ->where('peminjaman_bahans.user_id', '=', $user->id)
                    ->where('peminjaman_bahans.status', '=', 'selesai')
                    ->orWhere('laboratorium.id', '=', $laboratorium->id)
                    ->count();

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

                $penggunaan = DB::table('penggunaans')
                    ->join('kegiatans', 'penggunaans.kegiatan_id', '=', 'kegiatans.id')
                    ->join('users', 'penggunaans.user_id', '=', 'users.id')
                    ->join('bahan_praktikums', 'penggunaans.bahanpraktikum_id', '=', 'bahan_praktikums.id')
                    ->join('laboratorium', 'bahan_praktikums.laboratorium_id', '=', 'laboratorium.id')
                    ->where('laboratorium.id', '=', $laboratorium->id)
                    ->count();
            } elseif ($dosen->jabatan == 'dosen pengampu') {

                $pelaksanaan = Kegiatan::where('jenis', 'pelaksanaan')->where('user_id', $user->id)->orWhere('dospem_id', $dosen->id)->count();
                $plmenunggu = Kegiatan::where('jenis', 'pelaksanaan')->where('status', 'menunggu')->where('user_id', $user->id)->orWhere('dospem_id', $dosen->id)->count();
                $pldisetujui = Kegiatan::where('jenis', 'pelaksanaan')->where('status', 'disetujui')->where('user_id', $user->id)->orWhere('dospem_id', $dosen->id)->count();
                $plberlangsung = Kegiatan::where('jenis', 'pelaksanaan')->where('status', 'berlangsung')->where('user_id', $user->id)->orWhere('dospem_id', $dosen->id)->count();
                $plselesai = Kegiatan::where('jenis', 'pelaksanaan')->where('status', 'selesai')->where('user_id', $user->id)->orWhere('dospem_id', $dosen->id)->count();
                $plditolak = Kegiatan::where('jenis', 'pelaksanaan')->where('status', 'ditolak')->where('user_id', $user->id)->orWhere('dospem_id', $dosen->id)->count();

                $permohonan = Kegiatan::where('jenis', 'permohonan')->where('user_id', $user->id)->orWhere('dospem_id', $dosen->id)->count();
                $prmenunggu = Kegiatan::where('jenis', 'permohonan')->where('status', 'menunggu')->where('user_id', $user->id)->orWhere('dospem_id', $dosen->id)->count();
                $prdisetujui = Kegiatan::where('jenis', 'permohonan')->where('status', 'disetujui')->where('user_id', $user->id)->orWhere('dospem_id', $dosen->id)->count();
                $prberlangsung = Kegiatan::where('jenis', 'permohonan')->where('status', 'berlangsung')->where('user_id', $user->id)->orWhere('dospem_id', $dosen->id)->count();
                $prselesai = Kegiatan::where('jenis', 'permohonan')->where('status', 'selesai')->where('user_id', $user->id)->orWhere('dospem_id', $dosen->id)->count();
                $prditolak = Kegiatan::where('jenis', 'permohonan')->where('status', 'ditolak')->where('user_id', $user->id)->orWhere('dospem_id', $dosen->id)->count();

                $palat = DB::table('peminjaman_alats')
                    ->join('barang_pakais', 'peminjaman_alats.barangpakai_id', '=', 'barang_pakais.id')
                    ->join('laboratorium', 'barang_pakais.laboratorium_id', '=', 'laboratorium.id')
                    ->where('peminjaman_alats.user_id', '=', $user->id)
                    ->count();

                $pamenunggu = DB::table('peminjaman_alats')
                    ->join('barang_pakais', 'peminjaman_alats.barangpakai_id', '=', 'barang_pakais.id')
                    ->join('laboratorium', 'barang_pakais.laboratorium_id', '=', 'laboratorium.id')
                    ->where('peminjaman_alats.user_id', '=', $user->id)
                    ->where('peminjaman_alats.status', '=', 'menunggu')
                    ->count();

                $padisetujui = DB::table('peminjaman_alats')
                    ->join('barang_pakais', 'peminjaman_alats.barangpakai_id', '=', 'barang_pakais.id')
                    ->join('laboratorium', 'barang_pakais.laboratorium_id', '=', 'laboratorium.id')
                    ->where('peminjaman_alats.user_id', '=', $user->id)
                    ->where('peminjaman_alats.status', '=', 'disetujui')
                    ->count();

                $paditolak = DB::table('peminjaman_alats')
                    ->join('barang_pakais', 'peminjaman_alats.barangpakai_id', '=', 'barang_pakais.id')
                    ->join('laboratorium', 'barang_pakais.laboratorium_id', '=', 'laboratorium.id')
                    ->where('peminjaman_alats.user_id', '=', $user->id)
                    ->where('peminjaman_alats.status', '=', 'ditolak')
                    ->count();

                $paselesai = DB::table('peminjaman_alats')
                    ->join('barang_pakais', 'peminjaman_alats.barangpakai_id', '=', 'barang_pakais.id')
                    ->join('laboratorium', 'barang_pakais.laboratorium_id', '=', 'laboratorium.id')
                    ->where('peminjaman_alats.user_id', '=', $user->id)
                    ->where('peminjaman_alats.status', '=', 'selesai')
                    ->count();

                $pbahan = DB::table('peminjaman_bahans')
                    ->join('bahan_jurusans', 'peminjaman_bahans.bahanjurusan_id', '=', 'bahan_jurusans.id')
                    ->join('laboratorium', 'bahan_jurusans.laboratorium_id', '=', 'laboratorium.id')
                    ->where('peminjaman_bahans.user_id', '=', $user->id)
                    ->count();

                $pbmenunggu = DB::table('peminjaman_bahans')
                    ->join('bahan_jurusans', 'peminjaman_bahans.bahanjurusan_id', '=', 'bahan_jurusans.id')
                    ->join('laboratorium', 'bahan_jurusans.laboratorium_id', '=', 'laboratorium.id')
                    ->where('peminjaman_bahans.user_id', '=', $user->id)
                    ->where('peminjaman_bahans.status', '=', 'menunggu')
                    ->count();

                $pbdisetujui = DB::table('peminjaman_bahans')
                    ->join('bahan_jurusans', 'peminjaman_bahans.bahanjurusan_id', '=', 'bahan_jurusans.id')
                    ->join('laboratorium', 'bahan_jurusans.laboratorium_id', '=', 'laboratorium.id')
                    ->where('peminjaman_bahans.user_id', '=', $user->id)
                    ->where('peminjaman_bahans.status', '=', 'disetujui')
                    ->count();

                $pbditolak = DB::table('peminjaman_bahans')
                    ->join('bahan_jurusans', 'peminjaman_bahans.bahanjurusan_id', '=', 'bahan_jurusans.id')
                    ->join('laboratorium', 'bahan_jurusans.laboratorium_id', '=', 'laboratorium.id')
                    ->where('peminjaman_bahans.user_id', '=', $user->id)
                    ->where('peminjaman_bahans.status', '=', 'ditolak')
                    ->count();

                $pbselesai = DB::table('peminjaman_bahans')
                    ->join('bahan_jurusans', 'peminjaman_bahans.bahanjurusan_id', '=', 'bahan_jurusans.id')
                    ->join('laboratorium', 'bahan_jurusans.laboratorium_id', '=', 'laboratorium.id')
                    ->where('peminjaman_bahans.user_id', '=', $user->id)
                    ->where('peminjaman_bahans.status', '=', 'selesai')
                    ->count();

                $pemakaian = Pemakaian::where('user_id', $user->id)->count();
                $pkmulai = Pemakaian::where('user_id', $user->id)->where('status', 'mulai')->count();
                $pkselesai = Pemakaian::where('user_id', $user->id)->where('status', 'selesai')->count();

                $penggunaan = Penggunaan::where('user_id', $user->id)->count();
            } else {

                $pelaksanaan = Kegiatan::where('jenis', 'pelaksanaan')->count();
                $plmenunggu = Kegiatan::where('jenis', 'pelaksanaan')->where('status', 'menunggu')->count();
                $pldisetujui = Kegiatan::where('jenis', 'pelaksanaan')->where('status', 'disetujui')->count();
                $plberlangsung = Kegiatan::where('jenis', 'pelaksanaan')->where('status', 'berlangsung')->count();
                $plselesai = Kegiatan::where('jenis', 'pelaksanaan')->where('status', 'selesai')->count();
                $plditolak = Kegiatan::where('jenis', 'pelaksanaan')->where('status', 'ditolak')->count();

                $permohonan = Kegiatan::where('jenis', 'permohonan')->count();
                $prmenunggu = Kegiatan::where('jenis', 'permohonan')->where('status', 'menunggu')->count();
                $prdisetujui = Kegiatan::where('jenis', 'permohonan')->where('status', 'disetujui')->count();
                $prberlangsung = Kegiatan::where('jenis', 'permohonan')->where('status', 'berlangsung')->count();
                $prselesai = Kegiatan::where('jenis', 'permohonan')->where('status', 'selesai')->count();
                $prditolak = Kegiatan::where('jenis', 'permohonan')->where('status', 'ditolak')->count();

                $palat = PeminjamanAlat::all()->count();
                $pamenunggu = PeminjamanAlat::where('status', 'menunggu')->count();
                $padisetujui = PeminjamanAlat::where('status', 'disetujui')->count();
                $paditolak = PeminjamanAlat::where('status', 'ditolak')->count();
                $paselesai = PeminjamanAlat::where('status', 'selesai')->count();

                $pbahan = PeminjamanBahan::all()->count();
                $pbmenunggu = PeminjamanBahan::where('status', 'menunggu')->count();
                $pbdisetujui = PeminjamanBahan::where('status', 'disetujui')->count();
                $pbditolak = PeminjamanBahan::where('status', 'ditolak')->count();
                $pbselesai = PeminjamanBahan::where('status', 'selesai')->count();

                $pemakaian = Pemakaian::all()->count();
                $pkmulai = Pemakaian::where('status', 'mulai')->count();
                $pkselesai = Pemakaian::where('status', 'selesai')->count();

                $penggunaan = Penggunaan::all()->count();
            }
        } else {

            $pelaksanaan = Kegiatan::where('user_id', $user->id)->where('jenis', 'pelaksanaan')->count();
            $plmenunggu = Kegiatan::where('user_id', $user->id)->where('jenis', 'pelaksanaan')->where('status', 'menunggu')->count();
            $pldisetujui = Kegiatan::where('user_id', $user->id)->where('jenis', 'pelaksanaan')->where('status', 'disetujui')->count();
            $plberlangsung = Kegiatan::where('user_id', $user->id)->where('jenis', 'pelaksanaan')->where('status', 'berlangsung')->count();
            $plselesai = Kegiatan::where('user_id', $user->id)->where('jenis', 'pelaksanaan')->where('status', 'selesai')->count();
            $plditolak = Kegiatan::where('user_id', $user->id)->where('jenis', 'pelaksanaan')->where('status', 'ditolak')->count();

            $permohonan = Kegiatan::where('user_id', $user->id)->where('jenis', 'permohonan')->count();
            $prmenunggu = Kegiatan::where('user_id', $user->id)->where('jenis', 'permohonan')->where('status', 'menunggu')->count();
            $prdisetujui = Kegiatan::where('user_id', $user->id)->where('jenis', 'permohonan')->where('status', 'disetujui')->count();
            $prberlangsung = Kegiatan::where('user_id', $user->id)->where('jenis', 'permohonan')->where('status', 'berlangsung')->count();
            $prselesai = Kegiatan::where('user_id', $user->id)->where('jenis', 'permohonan')->where('status', 'selesai')->count();
            $prditolak = Kegiatan::where('user_id', $user->id)->where('jenis', 'permohonan')->where('status', 'ditolak')->count();

            $palat = PeminjamanAlat::where('user_id', $user->id)->count();
            $pamenunggu = PeminjamanAlat::where('user_id', $user->id)->where('status', 'menunggu')->count();
            $padisetujui = PeminjamanAlat::where('user_id', $user->id)->where('status', 'disetujui')->count();
            $paditolak = PeminjamanAlat::where('user_id', $user->id)->where('status', 'ditolak')->count();
            $paselesai = PeminjamanAlat::where('user_id', $user->id)->where('status', 'selesai')->count();

            $pbahan = PeminjamanBahan::where('user_id', $user->id)->count();
            $pbmenunggu = PeminjamanBahan::where('user_id', $user->id)->where('status', 'menunggu')->count();
            $pbdisetujui = PeminjamanBahan::where('user_id', $user->id)->where('status', 'disetujui')->count();
            $pbditolak = PeminjamanBahan::where('user_id', $user->id)->where('status', 'ditolak')->count();
            $pbselesai = PeminjamanBahan::where('user_id', $user->id)->where('status', 'selesai')->count();

            $pemakaian = Pemakaian::where('user_id', $user->id)->count();
            $pkmulai = Pemakaian::where('user_id', $user->id)->where('status', 'mulai')->count();
            $pkselesai = Pemakaian::where('user_id', $user->id)->where('status', 'selesai')->count();

            $penggunaan = Penggunaan::where('user_id', $user->id)->count();
        }

        // return dd($pldisetujui);
        return view('v_dashboard', [
            'title' => 'Sistem Informasi Manajemen Administrasi Laboratorium Komputer',
            'dosen' => $dosen,
            'mahasiswa' => $mahasiswa,
            'staff' => $staff,
            'alat' => $alat,
            'barangpakai' => $barangpakai,
            'bahanpraktikum' => $bahanpraktikum,
            'bahanjurusan' => $bahanjurusan,
            'laboratorium' => $laboratorium,
            'kelas' => $kelas,
            'palat' => $palat,
            'pamenunggu' => $pamenunggu,
            'padisetujui' => $padisetujui,
            'paditolak' => $paditolak,
            'paselesai' => $paselesai,
            'pbahan' => $pbahan,
            'pbmenunggu' => $pbmenunggu,
            'pbdisetujui' => $pbdisetujui,
            'pbditolak' => $pbditolak,
            'pbselesai' => $pbselesai,
            'pelaksanaan' => $pelaksanaan,
            'plmenunggu' => $plmenunggu,
            'pldisetujui' => $pldisetujui,
            'plberlangsung' => $plberlangsung,
            'plselesai' => $plselesai,
            'plditolak' => $plditolak,
            'permohonan' => $permohonan,
            'prmenunggu' => $prmenunggu,
            'prdisetujui' => $prdisetujui,
            'prberlangsung' => $prberlangsung,
            'prselesai' => $prselesai,
            'prditolak' => $prditolak,
            'pemakaian' => $pemakaian,
            'pkmulai' => $pkmulai,
            'pkselesai' => $pkselesai,
            'penggunaan' => $penggunaan,
        ]);
    }
}
