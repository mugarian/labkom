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
    public function index(Request $request)
    {
        if ($request->has(['tgl_pinjam_dari', 'tgl_pinjam_sampai', 'tgl_kembali_dari', 'tgl_kembali_sampai'])) {
            $range_tgl_pinjam = [$request->tgl_pinjam_dari, $request->tgl_pinjam_sampai];
            $range_tgl_kembali = [$request->tgl_kembali_dari, $request->tgl_kembali_sampai];
        } else {
            $tgl_pinjam_min = date('Y-m-d H:i:s', strtotime(PeminjamanAlat::min('tgl_pinjam')));
            $tgl_pinjam_max = date('Y-m-d H:i:s', strtotime(PeminjamanAlat::max('tgl_pinjam')));
            $tgl_kembali_min = date('Y-m-d H:i:s', strtotime(PeminjamanAlat::min('tgl_kembali')));
            $tgl_kembali_mx = date('Y-m-d H:i:s', strtotime(PeminjamanAlat::max('tgl_kembali')));
            $range_tgl_pinjam = [$tgl_pinjam_min, $tgl_pinjam_max];
            $range_tgl_kembali = [$tgl_kembali_min, $tgl_kembali_mx];
        }

        $user = User::find(auth()->user()->id);
        $peminjamanalat = peminjamanalat::orderBy('tgl_pinjam', 'desc')->get();
        if ($user->role == 'admin') {
            if ($peminjamanalat->contains('tgl_kembali', NULL)) {
                $peminjamanalat = peminjamanalat::whereBetween('tgl_pinjam', $range_tgl_pinjam)->orderBy('tgl_pinjam', 'desc')->get();
            } else {
                $peminjamanalat = peminjamanalat::whereBetween('tgl_pinjam', $range_tgl_pinjam)->whereBetween('tgl_kembali', $range_tgl_kembali)->orderBy('tgl_pinjam', 'desc')->get();
            }
            $kalab = false;
        } elseif ($user->role == 'dosen') {
            $dosen = Dosen::where('user_id', $user->id)->first();
            if ($dosen->kepalalab == 'true') {
                $laboratorium = Laboratorium::where('user_id', $user->id)->first();
                $kalab = true;


                // todo join peminjamanalat == alat == laboratorium
                if ($peminjamanalat->contains('tgl_kembali', NULL)) {
                    $peminjamanalat = DB::table('peminjaman_alats')
                        ->join('users', 'peminjaman_alats.user_id', '=', 'users.id')
                        ->join('barang_pakais', 'peminjaman_alats.barangpakai_id', '=', 'barang_pakais.id')
                        ->join('laboratorium', 'barang_pakais.laboratorium_id', '=', 'laboratorium.id')
                        ->where('laboratorium.id', '=', $laboratorium->id)
                        ->whereBetween('peminjaman_alats.tgl_pinjam', $range_tgl_pinjam)
                        ->select('peminjaman_alats.*', 'laboratorium.nama as namalab', 'barang_pakais.nama as namabarangpakai', 'users.nama as namauser', 'users.id as iduser')
                        ->orderBy('tgl_pinjam', 'desc')
                        ->get();
                } else {
                    $peminjamanalat = DB::table('peminjaman_alats')
                        ->join('users', 'peminjaman_alats.user_id', '=', 'users.id')
                        ->join('barang_pakais', 'peminjaman_alats.barangpakai_id', '=', 'barang_pakais.id')
                        ->join('laboratorium', 'barang_pakais.laboratorium_id', '=', 'laboratorium.id')
                        ->where('laboratorium.id', '=', $laboratorium->id)
                        ->whereBetween('peminjaman_alats.tgl_pinjam', $range_tgl_pinjam)
                        ->whereBetween('peminjaman_alats.tgl_kembali', $range_tgl_kembali)
                        ->select('peminjaman_alats.*', 'laboratorium.nama as namalab', 'barang_pakais.nama as namabarangpakai', 'users.nama as namauser', 'users.id as iduser')
                        ->orderBy('tgl_pinjam', 'desc')
                        ->get();
                }

                // todo pemakaian->barangpakai->laboratorium->user->id == auth()->user()->id
            } else {
                if ($peminjamanalat->contains('tgl_kembali', NULL)) {
                    $peminjamanalat = peminjamanalat::where('user_id', $user->id)->whereBetween('tgl_pinjam', $range_tgl_pinjam)->orderBy('tgl_pinjam', 'desc')->get();
                } else {
                    $peminjamanalat = peminjamanalat::where('user_id', $user->id)->whereBetween('tgl_pinjam', $range_tgl_pinjam)->whereBetween('tgl_kembali', $range_tgl_kembali)->orderBy('tgl_pinjam', 'desc')->get();
                }
                $kalab = false;
            }
        } else {
            if ($peminjamanalat->contains('tgl_kembali', NULL)) {
                $peminjamanalat = peminjamanalat::where('user_id', $user->id)->whereBetween('tgl_pinjam', $range_tgl_pinjam)->orderBy('tgl_pinjam', 'desc')->get();
            } else {
                $peminjamanalat = peminjamanalat::where('user_id', $user->id)->whereBetween('tgl_pinjam', $range_tgl_pinjam)->whereBetween('tgl_kembali', $range_tgl_kembali)->orderBy('tgl_pinjam', 'desc')->get();
            }
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

        $current_datetime = date('Y-m-d H:i:s');

        foreach ($peminjamanalat as $pj) {
            if ($current_datetime > $pj->rencana_tgl_kembali && $pj->status == 'menunggu') {
                DB::table('peminjaman_alats')->where('id', $pj->id)->update([
                    'keterangan' => 'Peminjaman Alat Kadaluarsa',
                    'status' => 'ditolak',
                ]);
            } else if ($current_datetime > $pj->rencana_tgl_kembali && $pj->status == 'disetujui') {
                DB::table('peminjaman_alats')->where('id', $pj->id)->update([
                    'keterangan' => 'Pengembalian Alat Telat',
                    'status' => 'telat',
                ]);
            }
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

        $jenis = $jurusan;

        $barangpakai = BarangPakai::all();
        return view('v_peminjamanalat.create', [
            'title' => 'Tambah Data peminjaman Alat',
            'jenis' => $jenis,
            'barangpakai' => $barangpakai
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
            'rencana_tgl_kembali' => 'required',
        ]);

        $kode = explode(' ## ', $request->barangpakai_id);
        $validatedData['barangpakai_id'] = end($kode);

        try {
            $barangpakai = BarangPakai::where('kode', $validatedData['barangpakai_id'])->first();
            $pemakaianTerakhir = Pemakaian::where('barangpakai_id', $barangpakai->id)->where('status', 'mulai')->orderBy('mulai', 'desc')->first();
            $peminjamanAlatTerakhir = PeminjamanAlat::where('barangpakai_id', $barangpakai->id)->where('status', 'disetujui')->orderBy('tgl_pinjam', 'desc')->first();
        } catch (\Throwable $th) {
            return redirect('/peminjamanalat')->with('fail', 'Peminjaman Alat Gagal');
        }


        if ($barangpakai) {
            if ($barangpakai->status == 'rusak') {
                return redirect('/peminjamanalat')->with('fail', 'Barang Pakai Alat sedang rusak');
            }
            if ($pemakaianTerakhir) {
                return redirect('/peminjamanalat')->with('fail', 'Barang Pakai Alat sedang dipakai');
            }
            if ($peminjamanAlatTerakhir) {
                return redirect('/peminjamanalat')->with('fail', 'Barang Pakai Alat sedang dipinjam');
            }

            $validatedData['barangpakai_id'] = $barangpakai->id;
            $validatedData['tgl_pinjam'] = date("Y-m-d H:i:s");

            if ($barangpakai->laboratorium->user->id == auth()->user()->id) {
                BarangPakai::find($barangpakai->id)->update(['status' => 'dipinjam']);
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
    public function edit($id)
    {
        $peminjamanAlat = PeminjamanAlat::find($id);
        return view('v_peminjamanalat.edit', [
            'title' => 'Cek Kondisi Peminjaman Alat',
            'peminjamanalat' => $peminjamanAlat,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PeminjamanAlat  $peminjamanAlat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $peminjamanalat = PeminjamanAlat::find($id);
        $rules = [
            'cpu' => 'nullable',
            'monitor' => 'nullable',
            'keyboard' => 'nullable',
            'mouse' => 'nullable',
            'kondisi' => 'required',
            'upload' => 'required|image|mimes:jpg,jpeg,png|max:8000'
        ];

        $validatedData = $request->validate($rules);

        if ($request->file('upload')) {
            $validatedData['upload'] = $request->file('upload')->store('peminjamanalat-images');
            $validatedData['bukti'] = $validatedData['upload'];
            unset($validatedData['upload']);
        }

        BarangPakai::find($peminjamanalat->barangpakai->id)->update(['status' => 'tersedia']);
        $validatedData['status'] = 'selesai';
        $validatedData['tgl_kembali'] = Date('Y-m-d H:i:s');

        PeminjamanAlat::where('id', $peminjamanalat->id)->update($validatedData);

        return redirect('/peminjamanalat')->with('success', 'Data peminjaman alat berhasil dicek');
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

        $jenis = $jurusan;

        return view('v_peminjamanalat.pinjam', [
            'title' => 'Tambah Data Peminjaman Alat',
            'barangpakai' => $barangpakai,
            'jenis' => $jenis
        ]);
    }

    public function status(Request $request, $id)
    {
        $peminjamanalat = PeminjamanAlat::find($id);
        BarangPakai::find($peminjamanalat->barangpakai->id)->update(['status' => 'dipinjam']);
        $peminjamanalat->update([
            'status' => $request->status,
            'tgl_kembali' => $request->tgl_kembali ?? null,
            'updated_at' => Date('Y-m-d H:i:s'),
        ]);

        return redirect('/peminjamanalat')->with('success', 'Data peminjaman alat telah ' . $request->status);
    }
}
