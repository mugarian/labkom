<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\User;
use App\Models\Dosen;
use App\Models\Kegiatan;
use App\Models\Mahasiswa;
use App\Models\Pemakaian;
use App\Models\Peminjaman;
use App\Models\BarangPakai;
use App\Models\Pelaksanaan;
use App\Models\Laboratorium;
use Illuminate\Http\Request;
use App\Models\PeminjamanAlat;
use Illuminate\Support\Facades\DB;
use PhpParser\NodeVisitor\FirstFindingVisitor;

class PemakaianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has(['mulaidari', 'mulaisampai', 'selesaidari', 'selesaisampai'])) {
            $range_mulai = [$request->mulaidari, $request->mulaisampai];
            $range_selesai = [$request->selesaidari, $request->selesaisampai];
        } else {
            $mulaimin = date('Y-m-d H:i:s', strtotime(Pemakaian::min('mulai')));
            $mulaimax = date('Y-m-d H:i:s', strtotime(Pemakaian::max('mulai')));
            $selesaimin = date('Y-m-d H:i:s', strtotime(Pemakaian::min('selesai')));
            $selesaimax = date('Y-m-d H:i:s', strtotime(Pemakaian::max('selesai')));
            $range_mulai = [$mulaimin, $mulaimax];
            $range_selesai = [$selesaimin, $selesaimax];
        }

        $user = User::find(auth()->user()->id);
        if ($user->role == 'admin') {
            // ADMIN
            $pemakaian = Pemakaian::orderBy('mulai', 'desc')->get();
            if ($pemakaian->contains('selesai', NULL)) {
                $pemakaian = Pemakaian::whereBetween('mulai', $range_mulai)->orderBy('mulai', 'desc')->get();
            } else {
                $pemakaian = Pemakaian::whereBetween('mulai', $range_mulai)->whereBetween('selesai', $range_selesai)->orderBy('mulai', 'desc')->get();
            }
            $kalab = false;
        } elseif ($user->role == 'dosen') {
            $dosen = Dosen::where('user_id', $user->id)->first();
            if ($dosen->kepalalab == 'true') {
                // KEPALA LAB
                $laboratorium = Laboratorium::where('user_id', $user->id)->first();
                $pemakaian = Pemakaian::orderBy('mulai', 'desc')->get();
                $kalab = true;

                if ($pemakaian->contains('selesai', NULL)) {
                    $pemakaian = DB::table('pemakaians')
                        ->join('kegiatans', 'pemakaians.kegiatan_id', '=', 'kegiatans.id')
                        ->join('users', 'pemakaians.user_id', '=', 'users.id')
                        ->join('barang_pakais', 'pemakaians.barangpakai_id', '=', 'barang_pakais.id')
                        ->join('laboratorium', 'barang_pakais.laboratorium_id', '=', 'laboratorium.id')
                        ->where('laboratorium.id', '=', $laboratorium->id)
                        ->whereBetween('pemakaians.mulai', $range_mulai)
                        ->orWhere('users.id', '=', $user->id)
                        ->select('pemakaians.*', 'kegiatans.nama as namakegiatan', 'laboratorium.nama as namalab', 'barang_pakais.nama as namabarangpakai', 'users.nama as namauser', 'users.id as iduser')
                        ->orderBy('pemakaians.mulai', 'desc')
                        ->get();
                } else {
                    $pemakaian = DB::table('pemakaians')
                        ->join('kegiatans', 'pemakaians.kegiatan_id', '=', 'kegiatans.id')
                        ->join('users', 'pemakaians.user_id', '=', 'users.id')
                        ->join('barang_pakais', 'pemakaians.barangpakai_id', '=', 'barang_pakais.id')
                        ->join('laboratorium', 'barang_pakais.laboratorium_id', '=', 'laboratorium.id')
                        ->where('laboratorium.id', '=', $laboratorium->id)
                        ->whereBetween('pemakaians.mulai', $range_mulai)
                        ->whereBetween('pemakaians.selesai', $range_selesai)
                        ->orWhere('users.id', '=', $user->id)
                        ->select('pemakaians.*', 'kegiatans.nama as namakegiatan', 'laboratorium.nama as namalab', 'barang_pakais.nama as namabarangpakai', 'users.nama as namauser', 'users.id as iduser')
                        ->orderBy('pemakaians.mulai', 'desc')
                        ->get();
                }

                // todo pemakaian->barangpakai->laboratorium->user->id == auth()->user()->id
            } else {
                // DOSEN PENGAMPU
                $pemakaian = Pemakaian::where('user_id', $user->id)->orderBy('mulai', 'desc')->get();
                if ($pemakaian->contains('selesai', NULL)) {
                    $pemakaian = Pemakaian::where('user_id', $user->id)->whereBetween('mulai', $range_mulai)->orderBy('mulai', 'desc')->get();
                } else {
                    $pemakaian = Pemakaian::where('user_id', $user->id)->whereBetween('mulai', $range_mulai)->whereBetween('selesai', $range_selesai)->orderBy('mulai', 'desc')->get();
                }
                $kalab = false;
            }
        } else {
            // MAHASISWA
            $pemakaian = Pemakaian::where('user_id', $user->id)->orderBy('mulai', 'desc')->get();
            if ($pemakaian->contains('selesai', NULL)) {
                $pemakaian = Pemakaian::where('user_id', $user->id)->whereBetween('mulai', $range_mulai)->orderBy('mulai', 'desc')->get();
            } else {
                $pemakaian = Pemakaian::where('user_id', $user->id)->whereBetween('mulai', $range_mulai)->whereBetween('selesai', $range_selesai)->orderBy('mulai', 'desc')->get();
            }
            $kalab = false;
        }

        $terakhir = Pemakaian::where('status', 'mulai')->where('user_id', auth()->user()->id)->orderBy('mulai', 'desc')->first();
        if ($terakhir) {
            if ($terakhir->status == 'selesai') {
                $selesai = 1;
            } else {
                $selesai = 0;
            }
        } else {
            $selesai = 1;
        }

        return view('v_pemakaian.index', [
            'title' => 'Data pemakaian',
            'pemakaians' => $pemakaian,
            'selesai' => $selesai,
            'kalab' => $kalab
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $barangpakai = BarangPakai::all();
        // $kegiatan = Kegiatan::where('status', 'berlangsung')->get();
        $user = User::find(auth()->user()->id);
        if ($user->role == 'dosen') {
            $dosen = Dosen::where('user_id', $user->id)->first();
            if ($dosen->jebatan == 'dosen pengampu') {
                if ($dosen->kepalalab == 'true') {
                    // kepala lab
                    $laboratorium = Laboratorium::where('user_id', $dosen->user->id)->first();
                    $kegiatan = Kegiatan::where('status', 'berlangsung')->where('laboratorium_id', $laboratorium->id)->orWhere('user_id', auth()->user()->id)->orWhere('dospem_id', $dosen->id)->get();
                } else {
                    // dosen pengampu
                    $kegiatan = Kegiatan::where('status', 'berlangsung')->where('user_id', auth()->user()->id)->orWhere('dospem_id', $dosen->id)->get();
                }
            } else {
                // ketua jurusan
                $kegiatan = Kegiatan::where('status', 'berlangsung')->get();
            }
        } elseif ($user->role == 'mahasiswa') {
            // mahasiswa
            $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
            $kegiatan = Kegiatan::where('status', 'berlangsung')->where('user_Id', $user->id)->orWhere('kelas_id', $mahasiswa->kelas_id)->get();
        } else {
            // admin
            $kegiatan = Kegiatan::where('status', 'berlangsung')->get();
        }
        return view('v_pemakaian.create', [
            'title' => 'Tambah Data Pemakaian',
            'barangpakai' => $barangpakai,
            'kegiatan' => $kegiatan
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'barangpakai_id' => 'required',
            'kegiatan_id' => 'required',
        ]);

        $barangpakai = BarangPakai::where('kode', $validatedData['barangpakai_id'])->first();
        $kegiatan = Kegiatan::where('kode', $validatedData['kegiatan_id'])->first();
        $pemakaianTerakhir = Pemakaian::where('barangpakai_id', $barangpakai->id)->where('status', 'mulai')->orderBy('mulai', 'desc')->first();
        $peminjamanTerakhir = PeminjamanAlat::where('barangpakai_id', $barangpakai->id)->where('status', 'disetujui')->orderBy('tgl_pinjam', 'desc')->first();

        if ($barangpakai && $kegiatan) {
            if ($barangpakai->laboratorium->id != $kegiatan->laboratorium->id) {
                return redirect('/pemakaian')->with('fail', 'barangpakai tidak tersedia di kegiatan yang dimaksud');
            }
            if ($barangpakai->status == 'rusak') {
                return redirect('/pemakaian')->with('fail', 'barangpakai sedang rusak');
            }
            if ($pemakaianTerakhir) {
                return redirect('/pemakaian')->with('fail', 'barangpakai sedang dipakai');
            }
            if ($peminjamanTerakhir) {
                return redirect('/pemakaian')->with('fail', 'barangpakai sedang dipinjam');
            }
            if ($kegiatan->status != 'berlangsung') {
                return redirect('/pemakaian')->with('fail', 'Kegiatan yang dimaksud belum berlangsung atau sudah selesai');
            }
            $validatedData['barangpakai_id'] = $barangpakai->id;
            $validatedData['kegiatan_id'] = $kegiatan->id;
            $validatedData['mulai'] = date("Y-m-d H:i:s");
            BarangPakai::find($barangpakai->id)->update(['status' => 'dipakai']);
            Pemakaian::create($validatedData);
            return redirect('/pemakaian')->with('success', 'Tambah data Pemakaian berhasil');
        } else {
            if (!$barangpakai) {
                return redirect('/pemakaian')->with('fail', 'kode barangpakai tidak ditemukan');
            } else {
                return redirect('/pemakaian')->with('fail', 'kode kegiatan tidak ditemukan');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pemakaian  $pemakaian
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pemakaian = pemakaian::find($id);
        return view('v_pemakaian.show', [
            'title' => 'Pemakaian ' . $pemakaian->barangpakai->nama,
            'pemakaian' => $pemakaian,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pemakaian  $pemakaian
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pemakaian = pemakaian::find($id);
        return view('v_pemakaian.edit', [
            'title' => 'Edit Data pemakaian',
            'pemakaian' => $pemakaian,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pemakaian  $pemakaian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pemakaian = pemakaian::find($id);
        $rules = [
            'selesai' => 'required',
            'cpu' => 'nullable',
            'monitor' => 'nullable',
            'keyboard' => 'nullable',
            'mouse' => 'nullable',
            'keterangan' => 'nullable',
        ];

        $validatedData = $request->validate($rules);
        $validatedData['status'] = 'selesai';

        BarangPakai::find($pemakaian->barangpakai->id)->update(['status' => 'tersedia']);
        pemakaian::where('id', $pemakaian->id)->update($validatedData);

        return redirect('/pemakaian')->with('success', 'Data pemakaian berhasil diselesaikan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pemakaian  $pemakaian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pemakaian $pemakaian)
    {
        //
    }

    public function pakai($id)
    {
        $barangpakai = BarangPakai::find($id);
        // $kegiatan = Kegiatan::where('status', 'berlangsung')->get();
        $user = User::find(auth()->user()->id);
        if ($user->role == 'dosen') {
            $dosen = Dosen::where('user_id', $user->id)->first();
            if ($dosen->jebatan == 'dosen pengampu') {
                if ($dosen->kepalalab == 'true') {
                    // kepala lab
                    $laboratorium = Laboratorium::where('user_id', $dosen->user->id)->first();
                    $kegiatan = Kegiatan::where('status', 'berlangsung')->where('laboratorium_id', $laboratorium->id)->orWhere('user_id', auth()->user()->id)->orWhere('dospem_id', $dosen->id)->get();
                } else {
                    // dosen pengampu
                    $kegiatan = Kegiatan::where('status', 'berlangsung')->where('user_id', auth()->user()->id)->orWhere('dospem_id', $dosen->id)->get();
                }
            } else {
                // ketua jurusan
                $kegiatan = Kegiatan::where('status', 'berlangsung')->get();
            }
        } elseif ($user->role == 'mahasiswa') {
            // mahasiswa
            $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
            $kegiatan = Kegiatan::where('status', 'berlangsung')->where('user_Id', $user->id)->orWhere('kelas_id', $mahasiswa->kelas_id)->get();
        } else {
            // admin
            $kegiatan = Kegiatan::where('status', 'berlangsung')->get();
        }
        return view('v_pemakaian.pakai', [
            'title' => 'Tambah Data Pemakaian',
            'barangpakai' => $barangpakai,
            'kegiatan' => $kegiatan
        ]);
    }

    public function kegiatan($id)
    {
        $kegiatan = Kegiatan::find($id);
        $barangpakai = BarangPakai::all();
        return view('v_pemakaian.kegiatan', [
            'title' => 'Tambah Data Pemakaian',
            'kegiatan' => $kegiatan,
            'barangpakai' => $barangpakai
        ]);
    }
}
