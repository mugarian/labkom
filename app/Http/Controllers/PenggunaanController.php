<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Kegiatan;
use App\Models\Mahasiswa;
use App\Models\Penggunaan;
use Illuminate\Support\Str;
use App\Models\BahanJurusan;
use App\Models\Laboratorium;
use Illuminate\Http\Request;
use App\Models\BahanPraktikum;
use Illuminate\Support\Facades\DB;

class PenggunaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has(['tanggaldari', 'tanggalsampai'])) {
            $range_tanggal = [$request->tanggaldari, $request->tanggalsampai];
        } else {
            $tanggaldari = date('Y-m-d H:i:s', strtotime(Penggunaan::min('tanggal')));
            $tanggalsampai = date('Y-m-d H:i:s', strtotime(Penggunaan::max('tanggal')));
            $range_tanggal = [$tanggaldari, $tanggalsampai];
        }

        $user = User::find(auth()->user()->id);
        if ($user->role == 'admin') {
            $penggunaan = Penggunaan::whereBetween('tanggal', $range_tanggal)->orderBy('tanggal', 'desc')->get();
            $kalab = false;
        } elseif ($user->role == 'dosen') {
            $dosen = Dosen::where('user_id', $user->id)->first();
            if ($dosen->kepalalab == 'true') {
                $laboratorium = Laboratorium::where('user_id', $user->id)->first();
                $kalab = true;

                // todo join penggunaan == bahanpraktikum == laboratorium

                // SELECT penggunaans.id as id, barang_habis.nama as namabarang, laboratorium.nama as namalab, kegiatans.nama as namakegiatan, users.nama as namauser, penggunaans.tanggal as tanggal, penggunaans.status as status
                // FROM penggunaans
                // INNER JOIN kegiatans ON penggunaans.kegiatan_id = kegiatans.id
                // INNER JOIN users ON penggunaans.user_id = users.id
                // INNER JOIN barang_habis ON penggunaans.bahan_id = barang_habis.id
                // INNER JOIN laboratorium ON barang_habis.laboratorium_id = laboratorium.id
                // WHERE laboratorium.id = '00335b1f-420c-4610-bc8e-7069bb05ed47';

                $penggunaan = DB::table('penggunaans')
                    ->join('kegiatans', 'penggunaans.kegiatan_id', '=', 'kegiatans.id')
                    ->join('users', 'penggunaans.user_id', '=', 'users.id')
                    ->join('bahan_praktikums', 'penggunaans.bahanpraktikum_id', '=', 'bahan_praktikums.id')
                    ->join('laboratorium', 'bahan_praktikums.laboratorium_id', '=', 'laboratorium.id')
                    ->where('laboratorium.id', '=', $laboratorium->id)
                    ->whereBetween('tanggal', $range_tanggal)
                    ->orWhere('users.id', '=', $user->id)
                    ->select('penggunaans.*', 'kegiatans.nama as namakegiatan', 'laboratorium.nama as namalab', 'bahan_praktikums.nama as namabahanpraktikum', 'users.nama as namauser', 'users.id as iduser')
                    ->orderBy('tanggal', 'desc')
                    ->get();

                // todo pemakaian->barangpakai->laboratorium->user->id == auth()->user()->id
            } else {
                $penggunaan = penggunaan::where('user_id', $user->id)->whereBetween('tanggal', $range_tanggal)->orderBy('tanggal', 'desc')->get();
                $kalab = false;
            }
        } else {
            $penggunaan = penggunaan::where('user_id', $user->id)->whereBetween('tanggal', $range_tanggal)->orderBy('tanggal', 'desc')->get();
            $kalab = false;
        }
        return view('v_penggunaan.index', [
            'title' => 'Data Penggunaan Bahan',
            'penggunaans' => $penggunaan,
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
        $bahanpraktikum = BahanPraktikum::all();
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
        return view('v_penggunaan.create', [
            'title' => 'Tambah Data penggunaan',
            'bahanpraktikum' => $bahanpraktikum,
            'kegiatan' => $kegiatan,
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
            'bahanpraktikum_id' => 'required',
            'kegiatan_id' => 'required',
            'jumlah' => 'required',
            'deskripsi' => 'required'
        ]);

        $kodebp = explode(' ## ', $request->bahanpraktikum_id);
        $validatedData['bahanpraktikum_id'] = end($kodebp);

        $kodekeg = explode(' ## ', $request->kegiatan_id);
        $validatedData['kegiatan_id'] = end($kodekeg);
        try {
            $bahanpraktikum = BahanPraktikum::where('kode', $validatedData['bahanpraktikum_id'])->first();
            $kegiatan = kegiatan::where('kode', $validatedData['kegiatan_id'])->first();
        } catch (\Throwable $th) {
            return redirect('/penggunaan')->with('fail', 'Penggunaan Bahan Praktikum Gagal');
        }

        if ($bahanpraktikum && $kegiatan) {
            if ($bahanpraktikum->laboratorium->id != $kegiatan->laboratorium->id) {
                return redirect('/penggunaan')->with('fail', 'Bahan Praktikum tidak tersedia di kegiatan yang dimaksud');
            }
            if ($bahanpraktikum->status == 'rusak') {
                return redirect('/penggunaan')->with('fail', 'Bahan Praktikum sedang rusak');
            }
            if ($kegiatan->status != 'berlangsung') {
                return redirect('/penggunaan')->with('fail', 'Kegiatan yang dimaksud belum berlangsung atau sudah selesai');
            }
            if ($kegiatan->tipe != 'perkuliahan') {
                return redirect('/penggunaan')->with('fail', 'Bahan Praktikum tidak bisa digunakan selain kegiatan perkuliahan atau praktikum');
            }
            if ($validatedData['jumlah'] > $bahanpraktikum->stok) {
                return redirect('/penggunaan')->with('fail', 'Jumlah Penggunaan melebihi stok bahan praktikum');
            }

            $validatedData['bahanpraktikum_id'] = $bahanpraktikum->id;
            $validatedData['kegiatan_id'] = $kegiatan->id;
            $validatedData['tanggal'] = date("Y-m-d H:i:s");

            $jumlah = $bahanpraktikum->stok - $request->jumlah;
            BahanPraktikum::where('id', $bahanpraktikum->id)->update(['stok' => $jumlah]);

            if ($bahanpraktikum->jenis == 'tidak habis') {
                $bahanjurusan = BahanJurusan::where('bahanpraktikum_id', $bahanpraktikum->id)->first();
                if ($bahanjurusan) {
                    BahanJurusan::where('bahanpraktikum_id', $bahanpraktikum->id)->update([
                        'stok' => $bahanjurusan->stok + $request->jumlah,
                    ]);
                } else {
                    BahanJurusan::create([
                        'laboratorium_id' => $bahanpraktikum->laboratorium_id,
                        'bahanpraktikum_id' => $bahanpraktikum->id,
                        'kode' => Str::random(8),
                        'nama' => $bahanpraktikum->nama,
                        'merk' => $bahanpraktikum->merk,
                        'spesifikasi' => $bahanpraktikum->spesifikasi,
                        'harga' => $bahanpraktikum->harga,
                        'tahun' => $bahanpraktikum->tahun,
                        'foto' => $bahanpraktikum->foto,
                        'stok' => $request->jumlah,
                    ]);
                }
            }

            Penggunaan::create($validatedData);
            return redirect('/penggunaan')->with('success', 'Tambah data penggunaan berhasil');
        } else {
            if (!$bahanpraktikum) {
                return redirect('/penggunaan')->with('fail', 'Kode Bahan Praktikum tidak ditemukan');
            } else {
                return redirect('/penggunaan')->with('fail', 'Kode kegiatan tidak ditemukan');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Penggunaan  $penggunaan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $penggunaan = penggunaan::find($id);
        return view('v_penggunaan.show', [
            'title' => 'penggunaan ' . $penggunaan->bahanpraktikum->nama,
            'penggunaan' => $penggunaan,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penggunaan  $penggunaan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $penggunaan = penggunaan::find($id);
        if (auth()->user()->role == 'admin' || $penggunaan->bahanpraktikum->laboratorium->user->id == auth()->user()->id) {
            return view('v_penggunaan.edit', [
                'title' => 'Edit Data penggunaan',
                'penggunaan' => $penggunaan,
            ]);
        } else {
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penggunaan  $penggunaan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $penggunaan = penggunaan::find($id);
        $bahanpraktikum = BahanPraktikum::find($penggunaan->bahanpraktikum_id);
        $jumlah = $bahanpraktikum->stok - $penggunaan->jumlah;
        if ($penggunaan->jumlah > $bahanpraktikum->stok) {
            return redirect('/penggunaan')->with('fail', 'Stok bahan praktikum tidak mencukupi');
        } else if ($request->status == 'disetujui' && $bahanpraktikum->stok >= $penggunaan->jumlah) {
            $penggunaan->update(['status' => $request->status]);
            BahanPraktikum::where('id', $bahanpraktikum->id)->update(['stok' => $jumlah]);
            if ($bahanpraktikum->jenis == 'tidak habis') {
                $bahanjurusan = BahanJurusan::where('bahanpraktikum_id', $bahanpraktikum->id)->first();
                if ($bahanjurusan) {
                    BahanJurusan::where('bahanpraktikum_id', $bahanpraktikum->id)->update([
                        'stok' => $bahanjurusan->stok + $penggunaan->jumlah,
                    ]);
                } else {
                    BahanJurusan::create([
                        'laboratorium_id' => $bahanpraktikum->laboratorium_id,
                        'bahanpraktikum_id' => $bahanpraktikum->id,
                        'stok' => $penggunaan->jumlah,
                        'kode' => Str::random(8),
                    ]);
                }
            }
        }
        return redirect('/penggunaan')->with('success', 'Data penggunaan telah ' . $request->status);

        return redirect('/penggunaan')->with('success', 'Data penggunaan telah ' . $request->status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Penggunaan  $penggunaan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Penggunaan $penggunaan)
    {
    }

    public function status(Request $request, $id)
    {
        $penggunaan = penggunaan::find($id);
        $bahanpraktikum = BahanPraktikum::find($penggunaan->bahanpraktikum_id);
        $jumlah = $bahanpraktikum->stok - $penggunaan->jumlah;
        if ($penggunaan->jumlah > $bahanpraktikum->stok) {
            return redirect('/penggunaan')->with('fail', 'Stok bahan praktikum tidak mencukupi');
        } else if ($request->status == 'disetujui' && $bahanpraktikum->stok >= $penggunaan->jumlah) {
            $penggunaan->update(['status' => $request->status]);
            BahanPraktikum::where('id', $bahanpraktikum->id)->update(['stok' => $jumlah]);
            if ($bahanpraktikum->jenis == 'tidak habis') {
                $bahanjurusan = BahanJurusan::where('bahanpraktikum_id', $bahanpraktikum->id)->first();
                if ($bahanjurusan) {
                    BahanJurusan::where('bahanpraktikum_id', $bahanpraktikum->id)->update([
                        'stok' => $bahanjurusan->stok + $penggunaan->jumlah,
                    ]);
                } else {
                    BahanJurusan::create([
                        'laboratorium_id' => $bahanpraktikum->laboratorium_id,
                        'bahanpraktikum_id' => $bahanpraktikum->id,
                        'stok' => $penggunaan->jumlah,
                        'kode' => Str::random(8),
                    ]);
                }
            }
        }
        return redirect('/penggunaan')->with('success', 'Data penggunaan telah ' . $request->status);
    }

    public function guna($id)
    {
        $bahanpraktikum = BahanPraktikum::find($id);
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
        return view('v_penggunaan.guna', [
            'title' => 'Tambah Data Penggunaan',
            'bahanpraktikum' => $bahanpraktikum,
            'kegiatan' => $kegiatan
        ]);
    }

    public function ditolak($id)
    {
        $penggunaan = Penggunaan::find($id);
        return view('v_penggunaan.ditolak', [
            'title' => 'penggunaan penggunaan Ditolak',
            'penggunaan' => $penggunaan,
        ]);
    }

    public function updateDitolak(Request $request, $id)
    {
        $penggunaan = Penggunaan::find($id);
        $rules = [
            'keterangan' => 'required',
            'status' => 'required',
        ];

        $validatedData = $request->validate($rules);

        Penggunaan::where('id', $penggunaan->id)->update($validatedData);

        return redirect('/penggunaan')->with('success', 'Data penggunaan berhasil ditolak');
    }

    public function kegiatan($id)
    {
        $kegiatan = Kegiatan::find($id);
        $bahanpraktikum = bahanpraktikum::all();
        return view('v_penggunaan.kegiatan', [
            'title' => 'Tambah Data Pemakaian',
            'kegiatan' => $kegiatan,
            'bahanpraktikum' => $bahanpraktikum
        ]);
    }
}
