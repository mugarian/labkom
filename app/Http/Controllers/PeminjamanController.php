<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\User;
use App\Models\Dosen;
use App\Models\Staff;
use App\Models\Mahasiswa;
use App\Models\Pemakaian;
use App\Models\Peminjaman;
use App\Models\Laboratorium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
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
            $peminjaman = Peminjaman::orderBy('tgl_pinjam', 'desc')->get();
            $kalab = false;
        } elseif ($user->role == 'dosen') {
            $dosen = Dosen::where('user_id', $user->id)->first();
            if ($dosen->kepalalab == 'true') {
                $laboratorium = Laboratorium::where('user_id', $user->id)->first();
                $kalab = true;

                // todo join Peminjaman == alat == laboratorium

                // SELECT Peminjamans.id as id, barang_habis.nama as namabarang, laboratorium.nama as namalab, kegiatans.nama as namakegiatan, users.nama as namauser, Peminjamans.tanggal as tanggal, Peminjamans.status as status
                // FROM Peminjamans
                // INNER JOIN kegiatans ON Peminjamans.kegiatan_id = kegiatans.id
                // INNER JOIN users ON Peminjamans.user_id = users.id
                // INNER JOIN barang_habis ON Peminjamans.alat_id = barang_habis.id
                // INNER JOIN laboratorium ON barang_habis.laboratorium_id = laboratorium.id
                // WHERE laboratorium.id = '00335b1f-420c-4610-bc8e-7069bb05ed47';

                $peminjaman = DB::table('peminjamans')
                    ->join('users', 'peminjamans.user_id', '=', 'users.id')
                    ->join('barang_pakais', 'peminjamans.barangpakai_id', '=', 'barang_pakais.id')
                    ->join('laboratorium', 'barang_pakais.laboratorium_id', '=', 'laboratorium.id')
                    ->where('laboratorium.id', '=', $laboratorium->id)
                    ->select('peminjamans.*', 'laboratorium.nama as namalab', 'barang_pakais.nama as namabarangpakai', 'users.nama as namauser', 'users.id as iduser')
                    ->orderBy('tgl_pinjam', 'desc')
                    ->get();

                // todo pemakaian->barangpakai->laboratorium->user->id == auth()->user()->id
            } else {
                $peminjaman = Peminjaman::where('user_id', $user->id)->orderBy('tgl_pinjam', 'desc')->get();
                $kalab = false;
            }
        } else {
            $peminjaman = Peminjaman::where('user_id', $user->id)->orderBy('tgl_pinjam', 'desc')->get();
            $kalab = false;
        }

        $terakhir = Peminjaman::where('status', 'menunggu')->where('user_id', auth()->user()->id)->orderBy('tgl_pinjam', 'desc')->first();
        if ($terakhir) {
            if ($terakhir->status != 'menunggu') {
                $selesai = 1;
            } else {
                $selesai = 0;
            }
        } else {
            $selesai = 1;
        }

        return view('v_peminjaman.index', [
            'title' => 'Data peminjaman',
            'peminjamans' => $peminjaman,
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

        return view('v_peminjaman.create', [
            'title' => 'Tambah Data peminjaman',
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
            'alat_id' => 'required',
            'deskripsi' => 'required',
            'jenis' => 'required',
        ]);

        $alat = Alat::where('kode', $validatedData['alat_id'])->first();
        $pemakaianTerakhir = Pemakaian::where('alat_id', $alat->id)->where('status', 'mulai')->orderBy('mulai', 'desc')->first();
        $peminjamanTerakhir = Peminjaman::where('alat_id', $alat->id)->where('status', 'disetujui')->orderBy('tgl_pinjam', 'desc')->first();

        if ($alat) {
            if ($pemakaianTerakhir) {
                return redirect('/peminjaman')->with('fail', 'Alat sedang dipakai');
            }
            if ($peminjamanTerakhir) {
                return redirect('/peminjaman')->with('fail', 'Alat sedang dipinjam');
            }

            $validatedData['alat_id'] = $alat->id;
            $validatedData['tgl_pinjam'] = date("Y-m-d H:i:s");

            if ($alat->laboratorium->user->id == auth()->user()->id) {
                $validatedData['status'] = 'disetujui';
            }

            Peminjaman::create($validatedData);
            return redirect('/peminjaman')->with('success', 'Tambah data peminjaman berhasil');
        } else {
            return redirect('/peminjaman')->with('fail', 'Kode alat tidak ditemukan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Peminjaman  $peminjaman
     * @return \Illuminate\Http\Response
     */
    public function show(Peminjaman $peminjaman)
    {
        return view('v_peminjaman.show', [
            'title' => 'peminjaman ' . $peminjaman->alat->nama,
            'peminjaman' => $peminjaman,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Peminjaman  $peminjaman
     * @return \Illuminate\Http\Response
     */
    public function edit(Peminjaman $peminjaman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Peminjaman  $peminjaman
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Peminjaman $peminjaman)
    {
        $peminjaman->update([
            'status' => $request->status,
            'tgl_kembali' => $request->tgl_kembali ?? null,
            'updated_at' => Date('Y-m-d H:i:s'),
        ]);

        return redirect('/peminjaman')->with('success', 'Data peminjaman telah ' . $request->status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Peminjaman  $peminjaman
     * @return \Illuminate\Http\Response
     */
    public function destroy(Peminjaman $peminjaman)
    {
        //
    }

    public function ditolak($id)
    {
        $peminjaman = Peminjaman::find($id);
        return view('v_peminjaman.ditolak', [
            'title' => 'peminjaman peminjaman Ditolak',
            'peminjaman' => $peminjaman,
        ]);
    }

    public function updateDitolak(Request $request, $id)
    {
        $peminjaman = Peminjaman::find($id);
        $rules = [
            'keterangan' => 'required',
            'status' => 'required',
        ];

        $validatedData = $request->validate($rules);
        $validatedData['status'] = 'ditolak';
        peminjaman::where('id', $peminjaman->id)->update($validatedData);

        return redirect('/peminjaman')->with('success', 'Data Peminjaman berhasil ditolak');
    }
}
