<?php

namespace App\Http\Controllers;

use App\Models\BahanJurusan;
use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Laboratorium;
use Illuminate\Http\Request;
use App\Models\PeminjamanBahan;
use Illuminate\Support\Facades\DB;

class PeminjamanBahanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(auth()->user()->id);
        if ($user->role == 'admin') {
            $peminjamanbahan = peminjamanbahan::orderBy('tgl_pinjam', 'desc')->get();
            $kalab = false;
        } elseif ($user->role == 'dosen') {
            $dosen = Dosen::where('user_id', $user->id)->first();
            if ($dosen->kepalalab == 'true') {
                $laboratorium = Laboratorium::where('user_id', $user->id)->first();
                $kalab = true;

                // todo join peminjamanbahan == bahanjurusan == laboratorium

                // SELECT peminjamanbahans.id as id, barang_habis.nama as namabarang, laboratorium.nama as namalab, kegiatans.nama as namakegiatan, users.nama as namauser, peminjamanbahans.tanggal as tanggal, peminjamanbahans.status as status
                // FROM peminjamanbahans
                // INNER JOIN kegiatans ON peminjamanbahans.kegiatan_id = kegiatans.id
                // INNER JOIN users ON peminjamanbahans.user_id = users.id
                // INNER JOIN barang_habis ON peminjamanbahans.alat_id = barang_habis.id
                // INNER JOIN laboratorium ON barang_habis.laboratorium_id = laboratorium.id
                // WHERE laboratorium.id = '00335b1f-420c-4610-bc8e-7069bb05ed47';

                $peminjamanbahan = DB::table('peminjaman_bahans')
                    ->join('users', 'peminjaman_bahans.user_id', '=', 'users.id')
                    ->join('bahan_jurusans', 'peminjaman_bahans.bahanjurusan_id', '=', 'bahan_jurusans.id')
                    ->join('bahan_praktikums', 'bahan_jurusans.bahanpraktikum_id', '=', 'bahan_praktikums.id')
                    ->join('laboratorium', 'bahan_jurusans.laboratorium_id', '=', 'laboratorium.id')
                    ->where('laboratorium.id', '=', $laboratorium->id)
                    ->select('peminjaman_bahans.*', 'laboratorium.nama as namalab', 'bahan_praktikums.nama as namabahanjurusan', 'users.nama as namauser', 'users.id as iduser')
                    ->orderBy('tgl_pinjam', 'desc')
                    ->get();

                // todo pemakaian->bahanjurusan->laboratorium->user->id == auth()->user()->id
            } else {
                $peminjamanbahan = peminjamanbahan::where('user_id', $user->id)->orderBy('tgl_pinjam', 'desc')->get();
                $kalab = false;
            }
        } else {
            $peminjamanbahan = peminjamanbahan::where('user_id', $user->id)->orderBy('tgl_pinjam', 'desc')->get();
            $kalab = false;
        }

        $terakhir = peminjamanbahan::where('status', 'menunggu')->where('user_id', auth()->user()->id)->orderBy('tgl_pinjam', 'desc')->first();
        if ($terakhir) {
            if ($terakhir->status != 'menunggu') {
                $selesai = 1;
            } else {
                $selesai = 0;
            }
        } else {
            $selesai = 1;
        }

        return view('v_peminjamanbahan.index', [
            'title' => 'Data Peminjaman Bahan',
            'peminjamanbahans' => $peminjamanbahan,
            'kalab' => $kalab,
            'selesai' => $selesai,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = auth()->user();
        if ($user->role == 'dosen') {
            $jurusan = Dosen::where('user_id', $user->id)->first()->jurusan;
        } elseif ($user->role == 'mahasiswa') {
            $jurusan = Mahasiswa::where('user_id', $user->id)->first()->jurusan;
        }

        if ($jurusan == 'mi') {
            $jenis = 'dalam';
        } else {
            $jenis = 'luar';
        }

        return view('v_peminjamanbahan.create', [
            'title' => 'Tambah Data peminjaman bahan',
            'jenis' => $jenis
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
            'bahanjurusan_id' => 'required',
            'deskripsi' => 'required',
            'jenis' => 'required',
        ]);

        $bahanjurusan = BahanJurusan::where('kode', $validatedData['bahanjurusan_id'])->first();
        $peminjamanBahanTerakhir = PeminjamanBahan::where('bahanjurusan_id', $bahanjurusan->id)->where('status', 'disetujui')->orderBy('tgl_pinjam', 'desc')->first();

        if ($bahanjurusan) {
            if ($peminjamanBahanTerakhir) {
                return redirect('/peminjamanalat')->with('fail', 'Bahan Jurusan sedang dipinjam');
            }

            $validatedData['bahanjurusan_id'] = $bahanjurusan->id;
            $validatedData['tgl_pinjam'] = date("Y-m-d H:i:s");

            if ($bahanjurusan->laboratorium->user->id == auth()->user()->id) {
                $validatedData['status'] = 'disetujui';
            }

            PeminjamanBahan::create($validatedData);
            return redirect('/peminjamanbahan')->with('success', 'Tambah data Peminjaman bahan jurusan berhasil');
        } else {
            return redirect('/peminjamanbahan')->with('fail', 'Kode bahan jurusan tidak ditemukan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PeminjamanBahan  $peminjamanBahan
     * @return \Illuminate\Http\Response
     */
    public function show(PeminjamanBahan $peminjamanbahan)
    {
        return view('v_peminjamanbahan.show', [
            'title' => 'peminjaman ' . $peminjamanbahan->bahanjurusan->bahanpraktikum->nama,
            'peminjamanbahan' => $peminjamanbahan,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PeminjamanBahan  $peminjamanBahan
     * @return \Illuminate\Http\Response
     */
    public function edit(PeminjamanBahan $peminjamanBahan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PeminjamanBahan  $peminjamanBahan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PeminjamanBahan $peminjamanbahan)
    {
        $peminjamanbahan->update([
            'status' => $request->status,
            'tgl_kembali' => $request->tgl_kembali ?? null,
            'updated_at' => Date('Y-m-d H:i:s'),
        ]);

        return redirect('/peminjamanbahan')->with('success', 'Data peminjaman bahan telah ' . $request->status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PeminjamanBahan  $peminjamanBahan
     * @return \Illuminate\Http\Response
     */
    public function destroy(PeminjamanBahan $peminjamanBahan)
    {
        //
    }

    public function ditolak($id)
    {
        $peminjamanbahan = peminjamanbahan::find($id);
        // return dd($peminjamanbahan->bahanjurusan->kode);
        return view('v_peminjamanbahan.ditolak', [
            'title' => 'Peminjaman Alat Ditolak',
            'peminjamanbahan' => $peminjamanbahan,
        ]);
    }

    public function updateDitolak(Request $request, $id)
    {
        $peminjamanbahan = peminjamanbahan::find($id);
        $rules = [
            'keterangan' => 'required',
            'status' => 'required',
        ];

        $validatedData = $request->validate($rules);
        $validatedData['status'] = 'ditolak';
        peminjamanbahan::where('id', $peminjamanbahan->id)->update($validatedData);

        return redirect('/peminjamanbahan')->with('success', 'Data Peminjaman Bahan berhasil ditolak');
    }

    public function pinjam($id)
    {
        $bahanjurusan = bahanjurusan::find($id);
        $user = auth()->user();
        if ($user->role == 'dosen') {
            $jurusan = Dosen::where('user_id', $user->id)->first()->jurusan;
        } elseif ($user->role == 'mahasiswa') {
            $jurusan = Mahasiswa::where('user_id', $user->id)->first()->jurusan;
        }

        if ($jurusan == 'mi') {
            $jenis = 'dalam';
        } else {
            $jenis = 'luar';
        }
        return view('v_peminjamanbahan.pinjam', [
            'title' => 'Tambah Data Peminjaman Bahan',
            'bahanjurusan' => $bahanjurusan,
            'jenis' => $jenis
        ]);
    }
}
