<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Pemakaian;
use App\Models\BarangPakai;
use App\Models\Laboratorium;
use Illuminate\Http\Request;
use App\Models\PeminjamanAlat;
use Illuminate\Support\Facades\DB;

class PeminjamanAlatController extends Controller
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
            $peminjamanalat = peminjamanalat::orderBy('tgl_pinjam', 'desc')->get();
            $kalab = false;
        } elseif ($user->role == 'dosen') {
            $dosen = Dosen::where('user_id', $user->id)->first();
            if ($dosen->kepalalab == 'true') {
                $laboratorium = Laboratorium::where('user_id', $user->id)->first();
                $kalab = true;

                // todo join peminjamanalat == alat == laboratorium

                // SELECT peminjamanalats.id as id, barang_habis.nama as namabarang, laboratorium.nama as namalab, kegiatans.nama as namakegiatan, users.nama as namauser, peminjamanalats.tanggal as tanggal, peminjamanalats.status as status
                // FROM peminjamanalats
                // INNER JOIN kegiatans ON peminjamanalats.kegiatan_id = kegiatans.id
                // INNER JOIN users ON peminjamanalats.user_id = users.id
                // INNER JOIN barang_habis ON peminjamanalats.alat_id = barang_habis.id
                // INNER JOIN laboratorium ON barang_habis.laboratorium_id = laboratorium.id
                // WHERE laboratorium.id = '00335b1f-420c-4610-bc8e-7069bb05ed47';

                $peminjamanalat = DB::table('peminjaman_alats')
                    ->join('users', 'peminjaman_alats.user_id', '=', 'users.id')
                    ->join('barang_pakais', 'peminjaman_alats.barangpakai_id', '=', 'barang_pakais.id')
                    ->join('laboratorium', 'barang_pakais.laboratorium_id', '=', 'laboratorium.id')
                    ->where('laboratorium.id', '=', $laboratorium->id)
                    ->select('peminjaman_alats.*', 'laboratorium.nama as namalab', 'barang_pakais.nama as namabarangpakai', 'users.nama as namauser', 'users.id as iduser')
                    ->orderBy('tgl_pinjam', 'desc')
                    ->get();

                // todo pemakaian->barangpakai->laboratorium->user->id == auth()->user()->id
            } else {
                $peminjamanalat = peminjamanalat::where('user_id', $user->id)->orderBy('tgl_pinjam', 'desc')->get();
                $kalab = false;
            }
        } else {
            $peminjamanalat = peminjamanalat::where('user_id', $user->id)->orderBy('tgl_pinjam', 'desc')->get();
            $kalab = false;
        }

        $terakhir = peminjamanalat::where('status', 'menunggu')->where('user_id', auth()->user()->id)->orderBy('tgl_pinjam', 'desc')->first();
        if ($terakhir) {
            if ($terakhir->status != 'menunggu') {
                $selesai = 1;
            } else {
                $selesai = 0;
            }
        } else {
            $selesai = 1;
        }

        return view('v_peminjamanalat.index', [
            'title' => 'Data Peminjaman Alat',
            'peminjamanalats' => $peminjamanalat,
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

        return view('v_peminjamanalat.create', [
            'title' => 'Tambah Data peminjaman Alat',
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
            'barangpakai_id' => 'required',
            'deskripsi' => 'required',
            'jenis' => 'required',
        ]);

        $barangpakai = BarangPakai::where('kode', $validatedData['barangpakai_id'])->first();
        $pemakaianTerakhir = Pemakaian::where('barangpakai_id', $barangpakai->id)->where('status', 'mulai')->orderBy('mulai', 'desc')->first();
        $peminjamanAlatTerakhir = PeminjamanAlat::where('barangpakai_id', $barangpakai->id)->where('status', 'disetujui')->orderBy('tgl_pinjam', 'desc')->first();

        if ($barangpakai) {
            if ($pemakaianTerakhir) {
                return redirect('/peminjamanalat')->with('fail', 'Barang Pakai Alat sedang dipakai');
            }
            if ($peminjamanAlatTerakhir) {
                return redirect('/peminjamanalat')->with('fail', 'Barang Pakai Alat sedang dipinjam');
            }

            $validatedData['barangpakai_id'] = $barangpakai->id;
            $validatedData['tgl_pinjam'] = date("Y-m-d H:i:s");

            if ($barangpakai->laboratorium->user->id == auth()->user()->id) {
                $validatedData['status'] = 'disetujui';
            }

            PeminjamanAlat::create($validatedData);
            return redirect('/peminjamanalat')->with('success', 'Tambah data Peminjaman Alat berhasil');
        } else {
            return redirect('/peminjamanalat')->with('fail', 'Kode alat tidak ditemukan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PeminjamanAlat  $peminjamanAlat
     * @return \Illuminate\Http\Response
     */
    public function show(PeminjamanAlat $peminjamanalat)
    {
        return view('v_peminjamanalat.show', [
            'title' => 'peminjaman ' . $peminjamanalat->barangpakai->nama,
            'peminjamanalat' => $peminjamanalat,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PeminjamanAlat  $peminjamanAlat
     * @return \Illuminate\Http\Response
     */
    public function edit(PeminjamanAlat $peminjamanAlat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PeminjamanAlat  $peminjamanAlat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PeminjamanAlat $peminjamanalat)
    {
        $peminjamanalat->update([
            'status' => $request->status,
            'tgl_kembali' => $request->tgl_kembali ?? null,
            'updated_at' => Date('Y-m-d H:i:s'),
        ]);

        return redirect('/peminjamanalat')->with('success', 'Data peminjaman alat telah ' . $request->status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PeminjamanAlat  $peminjamanAlat
     * @return \Illuminate\Http\Response
     */
    public function destroy(PeminjamanAlat $peminjamanAlat)
    {
        //
    }

    public function ditolak($id)
    {
        $peminjamanalat = peminjamanalat::find($id);
        return view('v_peminjamanalat.ditolak', [
            'title' => 'Peminjaman Alat Ditolak',
            'peminjamanalat' => $peminjamanalat,
        ]);
    }

    public function updateDitolak(Request $request, $id)
    {
        $peminjamanalat = peminjamanalat::find($id);
        $rules = [
            'keterangan' => 'required',
            'status' => 'required',
        ];

        $validatedData = $request->validate($rules);
        $validatedData['status'] = 'ditolak';
        peminjamanalat::where('id', $peminjamanalat->id)->update($validatedData);

        return redirect('/peminjamanalat')->with('success', 'Data Peminjaman Alat berhasil ditolak');
    }

    public function pinjam($id)
    {
        $barangpakai = barangpakai::find($id);
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
        return view('v_peminjamanalat.pinjam', [
            'title' => 'Tambah Data Peminjaman Alat',
            'barangpakai' => $barangpakai,
            'jenis' => $jenis
        ]);
    }
}
