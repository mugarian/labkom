<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\BahanJurusan;
use App\Models\Laboratorium;
use Illuminate\Http\Request;
use App\Models\PeminjamanBahan;
use Illuminate\Support\Facades\DB;
use App\Notifications\NotifPermohonan;
use Illuminate\Support\Facades\Notification;

class PeminjamanBahanController extends Controller
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
            $tgl_pinjam_min = date('Y-m-d H:i:s', strtotime(PeminjamanBahan::min('tgl_pinjam')));
            $tgl_pinjam_max = date('Y-m-d H:i:s', strtotime(PeminjamanBahan::max('tgl_pinjam')));
            $tgl_kembali_min = date('Y-m-d H:i:s', strtotime(PeminjamanBahan::min('tgl_kembali')));
            $tgl_kembali_mx = date('Y-m-d H:i:s', strtotime(PeminjamanBahan::max('tgl_kembali')));
            $range_tgl_pinjam = [$tgl_pinjam_min, $tgl_pinjam_max];
            $range_tgl_kembali = [$tgl_kembali_min, $tgl_kembali_mx];
        }

        $user = User::find(auth()->user()->id);
        $peminjamanbahan = PeminjamanBahan::orderBy('tgl_pinjam', 'desc')->get();
        if ($user->role == 'admin') {
            if ($peminjamanbahan->contains('tgl_kembali', NULL)) {
                $peminjamanbahan = peminjamanbahan::whereBetween('tgl_pinjam', $range_tgl_pinjam)->orderBy('tgl_pinjam', 'desc')->get();
            } else {
                $peminjamanbahan = peminjamanbahan::whereBetween('tgl_pinjam', $range_tgl_pinjam)->whereBetween('tgl_kembali', $range_tgl_kembali)->orderBy('tgl_pinjam', 'desc')->get();
            }

            $kalab = false;
        } elseif ($user->role == 'dosen') {
            $dosen = Dosen::where('user_id', $user->id)->first();
            if ($dosen->kepalalab == 'true') {
                $laboratorium = Laboratorium::where('user_id', $user->id)->first();
                $kalab = true;

                // todo join peminjamanbahan == bahanjurusan == laboratorium
                if ($peminjamanbahan->contains('tgl_kembali', NULL)) {
                    $peminjamanbahan = DB::table('peminjaman_bahans')
                        ->join('users', 'peminjaman_bahans.user_id', '=', 'users.id')
                        ->join('bahan_jurusans', 'peminjaman_bahans.bahanjurusan_id', '=', 'bahan_jurusans.id')
                        ->join('bahan_praktikums', 'bahan_jurusans.bahanpraktikum_id', '=', 'bahan_praktikums.id')
                        ->join('laboratorium', 'bahan_jurusans.laboratorium_id', '=', 'laboratorium.id')
                        ->where('laboratorium.id', '=', $laboratorium->id)
                        ->whereBetween('peminjaman_bahans.tgl_pinjam', $range_tgl_pinjam)
                        ->select('peminjaman_bahans.*', 'laboratorium.nama as namalab', 'bahan_praktikums.nama as namabahanjurusan', 'users.nama as namauser', 'users.id as iduser')
                        ->orderBy('tgl_pinjam', 'desc')
                        ->get();
                } else {
                    $peminjamanbahan = DB::table('peminjaman_bahans')
                        ->join('users', 'peminjaman_bahans.user_id', '=', 'users.id')
                        ->join('bahan_jurusans', 'peminjaman_bahans.bahanjurusan_id', '=', 'bahan_jurusans.id')
                        ->join('bahan_praktikums', 'bahan_jurusans.bahanpraktikum_id', '=', 'bahan_praktikums.id')
                        ->join('laboratorium', 'bahan_jurusans.laboratorium_id', '=', 'laboratorium.id')
                        ->where('laboratorium.id', '=', $laboratorium->id)
                        ->whereBetween('peminjaman_bahans.tgl_pinjam', $range_tgl_pinjam)
                        ->whereBetween('peminjaman_bahans.tgl_kembali', $range_tgl_kembali)
                        ->select('peminjaman_bahans.*', 'laboratorium.nama as namalab', 'bahan_praktikums.nama as namabahanjurusan', 'users.nama as namauser', 'users.id as iduser')
                        ->orderBy('tgl_pinjam', 'desc')
                        ->get();
                }


                // todo pemakaian->bahanjurusan->laboratorium->user->id == auth()->user()->id
            } else {
                if ($peminjamanbahan->contains('tgl_kembali', NULL)) {
                    $peminjamanbahan = peminjamanbahan::where('user_id', $user->id)->whereBetween('tgl_pinjam', $range_tgl_pinjam)->orderBy('tgl_pinjam', 'desc')->get();
                } else {
                    $peminjamanbahan = peminjamanbahan::where('user_id', $user->id)->whereBetween('tgl_pinjam', $range_tgl_pinjam)->whereBetween('tgl_kembali', $range_tgl_kembali)->orderBy('tgl_pinjam', 'desc')->get();
                }

                $kalab = false;
            }
        } else {
            if ($peminjamanbahan->contains('tgl_kembali', NULL)) {
                $peminjamanbahan = peminjamanbahan::where('user_id', $user->id)->whereBetween('tgl_pinjam', $range_tgl_pinjam)->orderBy('tgl_pinjam', 'desc')->get();
            } else {
                $peminjamanbahan = peminjamanbahan::where('user_id', $user->id)->whereBetween('tgl_pinjam', $range_tgl_pinjam)->whereBetween('tgl_kembali', $range_tgl_kembali)->orderBy('tgl_pinjam', 'desc')->get();
            }

            $kalab = false;
        }

        $terakhir = peminjamanbahan::where('status', '<>', 'menunggu')->where('user_id', auth()->user()->id)->orderBy('tgl_pinjam', 'desc')->first();
        if ($terakhir) {
            if ($terakhir->status == 'menunggu' || $terakhir->status == 'terlambat') {
                $selesai = 1;
            } else {
                $selesai = 0;
            }
        } else {
            $selesai = 1;
        }

        $current_datetime = date('Y-m-d H:i:s');

        foreach ($peminjamanbahan as $pj) {
            if ($current_datetime > $pj->rencana_tgl_kembali && $pj->status == 'menunggu') {
                DB::table('peminjaman_bahans')->where('id', $pj->id)->update([
                    'keterangan' => 'Peminjaman Bahan Kadaluarsa',
                    'status' => 'ditolak',
                ]);
            } else if ($current_datetime > $pj->rencana_tgl_kembali && $pj->status == 'disetujui') {
                DB::table('peminjaman_bahans')->where('id', $pj->id)->update([
                    'keterangan' => 'Pengembalian Bahan Telat',
                    'status' => 'telat',
                ]);
            }
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

        $jenis = $jurusan;

        $bahanjurusan = BahanJurusan::all();
        return view('v_peminjamanbahan.create', [
            'title' => 'Tambah Data peminjaman bahan',
            'jenis' => $jenis,
            'bahanjurusan' => $bahanjurusan
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
            'jumlah' => 'required',
            'rencana_tgl_kembali' => 'required',
        ]);

        $kode = explode(' ## ', $request->bahanjurusan_id);
        $validatedData['bahanjurusan_id'] = end($kode);

        try {
            $bahanjurusan = BahanJurusan::where('kode', $validatedData['bahanjurusan_id'])->first();
            $peminjamanBahanTerakhir = PeminjamanBahan::where('bahanjurusan_id', $bahanjurusan->id)->where('status', 'disetujui')->orderBy('tgl_pinjam', 'desc')->first();
        } catch (\Throwable $th) {
            return redirect('/peminjamanbahan')->with('fail', 'Peminjaman Bahan Gagal');
        }

        if ($bahanjurusan) {
            if ($bahanjurusan->status == 'rusak') {
                return redirect('/peminjamanbahan')->with('fail', 'Bahan Jurusan sedang rusak');
            }
            if ($peminjamanBahanTerakhir) {
                return redirect('/peminjamanbahan')->with('fail', 'Bahan Jurusan sedang dipinjam');
            }
            if ($validatedData['jumlah'] > $bahanjurusan->stok) {
                return redirect('/peminjamanbahan')->with('fail', 'Jumlah Peminjaman melebihi stok bahan jurusan');
            }

            $validatedData['bahanjurusan_id'] = $bahanjurusan->id;
            $validatedData['tgl_pinjam'] = date("Y-m-d H:i:s");

            if ($bahanjurusan->laboratorium->user->id == auth()->user()->id) {
                BahanJurusan::find($bahanjurusan->id)->update(['status' => 'dipinjam']);
                $validatedData['status'] = 'disetujui';
                $bahanjurusan->update([
                    'stok' => $bahanjurusan->stok - $request->jumlah
                ]);
            }

            $pb = PeminjamanBahan::create($validatedData);

            $kalab = User::find($bahanjurusan->laboratorium->user->id);
            $peminjam = User::find($validatedData['user_id']);
            $title = 'Peminjaman Bahan';
            $description = 'Verifikasi Peminjaman ' . $bahanjurusan->nama . ', Oleh ' .  $peminjam->nama;
            $icon = 'bx bx-book';
            $uri = 'peminjamanbahan/' . $pb->id;

            Notification::send($kalab, new NotifPermohonan($title, $description, $uri, $icon));

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
    public function edit($id)
    {
        $peminjamanBahan = PeminjamanBahan::find($id);
        return view('v_peminjamanbahan.edit', [
            'title' => 'Cek Kondisi Peminjaman Bahan',
            'peminjamanbahan' => $peminjamanBahan,
        ]);
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
        $rules = [
            'kondisi' => 'required',
            'upload' => 'required|image|mimes:jpg,jpeg,png|max:8000',
        ];

        $validatedData = $request->validate($rules);

        if ($request->file('upload')) {
            $validatedData['upload'] = $request->file('upload')->store('peminjamanalat-images');
            $validatedData['bukti'] = $validatedData['upload'];
            unset($validatedData['upload']);
        }

        BahanJurusan::find($peminjamanbahan->bahanjurusan->id)->update(['status' => 'tersedia']);
        if ($peminjamanbahan->status == 'telat') {
            $validatedData['status'] = 'terlambat';
        } else {
            $validatedData['status'] = 'selesai';
        }
        $validatedData['tgl_kembali'] = Date('Y-m-d H:i:s');

        $bahanjurusan = BahanJurusan::find($peminjamanbahan->bahanjurusan_id);
        $bahanjurusan->update([
            'stok' => $bahanjurusan->stok + $peminjamanbahan->jumlah
        ]);

        PeminjamanBahan::where('id', $peminjamanbahan->id)->update($validatedData);

        $kalab = User::find($peminjamanbahan->bahanjurusan->laboratorium->user->id);
        $peminjam = User::find($peminjamanbahan->user_id);
        $title = 'Peminjaman Bahan';
        $description = 'Peminjaman ' . $peminjamanbahan->bahanjurusan->nama . ', Oleh ' .  $peminjam->nama . ' telah Selesai & Dikembalikan';
        $icon = 'bx bx-book';
        $uri = 'peminjamanbahan/' . $peminjamanbahan->id;

        Notification::send($kalab, new NotifPermohonan($title, $description, $uri, $icon));

        return redirect('/peminjamanbahan')->with('success', 'Data peminjaman bahan berhasil diselesaikan');
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
            'verif_dospem' => 'nullable',
            'verif_kalab' => 'nullable',
            'keterangan' => 'required',
            'status' => 'required',
        ];

        $validatedData = $request->validate($rules);
        $validatedData['status'] = 'ditolak';
        peminjamanbahan::where('id', $peminjamanbahan->id)->update($validatedData);

        $peminjam = User::find($peminjamanbahan->user_id);
        $title = 'Peminjaman Bahan';
        $description = 'Peminjaman ' . $peminjamanbahan->bahanjurusan->nama . ' Ditolak';
        $icon = 'bx bx-book';
        $uri = 'peminjamanbahan/' . $peminjamanbahan->id;

        Notification::send($peminjam, new NotifPermohonan($title, $description, $uri, $icon));

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

    public function status(Request $request, $id)
    {
        $peminjamanbahan = peminjamanbahan::find($id);
        $bahanjurusan = BahanJurusan::find($peminjamanbahan->bahanjurusan_id);
        $bahanjurusan->update([
            'stok' => $bahanjurusan->stok - $peminjamanbahan->jumlah
        ]);
        $peminjamanbahan->update([
            'status' => $request->status,
            'tgl_kembali' => $request->tgl_kembali ?? null,
            'updated_at' => Date('Y-m-d H:i:s'),
        ]);

        $kalab = User::find($peminjamanbahan->bahanjurusan->laboratorium->user->id);
        $peminjam = User::find($peminjamanbahan->user->id);
        $title = 'Peminjaman Bahan';
        $description = 'Peminjaman ' . $peminjamanbahan->bahanjurusan->nama . ' telah ' . $request->status;
        $icon = 'bx bx-book';
        $uri = 'peminjamanbahan/' . $peminjamanbahan->id;

        Notification::send($peminjam, new NotifPermohonan($title, $description, $uri, $icon));

        return redirect('/peminjamanbahan')->with('success', 'Data peminjaman bahan telah ' . $request->status);
    }
}
