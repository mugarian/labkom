<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Bahan;
use App\Models\Dosen;
use App\Models\Kegiatan;
use App\Models\Penggunaan;
use App\Models\BarangHabis;
use App\Models\Laboratorium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenggunaanController extends Controller
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
            $penggunaan = Penggunaan::orderBy('tanggal', 'desc')->paginate(5);
            $kalab = false;
        } elseif ($user->role == 'dosen') {
            $dosen = Dosen::where('user_id', $user->id)->first();
            if ($dosen->kepalalab == 'true') {
                $laboratorium = Laboratorium::where('user_id', $user->id)->first();
                $kalab = true;

                // todo join penggunaan == baranghabis == laboratorium

                // SELECT penggunaans.id as id, barang_habis.nama as namabarang, laboratorium.nama as namalab, kegiatans.nama as namakegiatan, users.nama as namauser, penggunaans.tanggal as tanggal, penggunaans.status as status
                // FROM penggunaans
                // INNER JOIN kegiatans ON penggunaans.kegiatan_id = kegiatans.id
                // INNER JOIN users ON penggunaans.user_id = users.id
                // INNER JOIN barang_habis ON penggunaans.baranghabis_id = barang_habis.id
                // INNER JOIN laboratorium ON barang_habis.laboratorium_id = laboratorium.id
                // WHERE laboratorium.id = '00335b1f-420c-4610-bc8e-7069bb05ed47';

                $penggunaan = DB::table('penggunaans')
                    ->join('kegiatans', 'penggunaans.kegiatan_id', '=', 'kegiatans.id')
                    ->join('users', 'penggunaans.user_id', '=', 'users.id')
                    ->join('barang_habis', 'penggunaans.baranghabis_id', '=', 'barang_habis.id')
                    ->join('laboratorium', 'barang_habis.laboratorium_id', '=', 'laboratorium.id')
                    ->where('laboratorium.id', '=', $laboratorium->id)
                    ->select('penggunaans.*', 'kegiatans.nama as namakegiatan', 'laboratorium.nama as namalab', 'barang_habis.nama as namabarang', 'users.nama as namauser', 'users.id as iduser')
                    ->orderBy('tanggal', 'desc')
                    ->paginate(5);

                // todo pemakaian->barangpakai->laboratorium->user->id == auth()->user()->id
            } else {
                $penggunaan = penggunaan::where('user_id', $user->id)->orderBy('tanggal', 'desc')->paginate(5);
                $kalab = false;
            }
        } else {
            $penggunaan = penggunaan::where('user_id', $user->id)->orderBy('tanggal', 'desc')->paginate(5);
            $kalab = false;
        }
        return view('v_penggunaan.index', [
            'title' => 'Data penggunaan',
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
        return view('v_penggunaan.create', [
            'title' => 'Tambah Data penggunaan',
            'baranghabis' => null
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
            'baranghabis_id' => 'required',
            'kegiatan_id' => 'required',
            'jumlah' => 'required',
        ]);

        $baranghabis = BarangHabis::where('kode', $validatedData['baranghabis_id'])->first();
        $kegiatan = kegiatan::where('kode', $validatedData['kegiatan_id'])->first();


        if ($baranghabis && $kegiatan) {
            if ($baranghabis->laboratorium->id != $kegiatan->laboratorium->id) {
                return redirect('/penggunaan')->with('fail', 'Barang tidak tersedia di kegiatan yang dimaksud');
            }
            if ($kegiatan->status != 'disetujui') {
                return redirect('/penggunaan')->with('fail', 'Kode Kegiatan tidak ada atau belum disetujui');
            }
            if ($validatedData['jumlah'] > $baranghabis->bahan->stok) {
                return redirect('/penggunaan')->with('fail', 'Jumlah Penggunaan melebihi stok');
            }

            $validatedData['baranghabis_id'] = $baranghabis->id;
            $validatedData['kegiatan_id'] = $kegiatan->id;
            $validatedData['tanggal'] = date("Y-m-d H:i:s");

            if ($baranghabis->laboratorium->user->id == auth()->user()->id) {
                $validatedData['status'] = 'disetujui';
            }

            Penggunaan::create($validatedData);
            return redirect('/penggunaan')->with('success', 'Tambah data penggunaan berhasil');
        } else {
            if (!$baranghabis) {
                return redirect('/penggunaan')->with('fail', 'Kode Barang tidak ditemukan');
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
            'title' => 'penggunaan ' . $penggunaan->baranghabis->nama,
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
        if (auth()->user()->role == 'admin' || $penggunaan->baranghabis->laboratorium->user->id == auth()->user()->id) {
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
        if (auth()->user()->role == 'admin' || $penggunaan->baranghabis->laboratorium->user->id == auth()->user()->id) {
            $rules = [
                'keterangan' => 'required',
            ];

            $validatedData = $request->validate($rules);
            $validatedData['status'] = 'ditolak';

            penggunaan::where('id', $penggunaan->id)->update($validatedData);

            return redirect('/penggunaan')->with('success', 'Data penggunaan berhasil ditolak');
        } else {
            abort(403);
        }
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
        if (auth()->user()->role == 'admin' || $penggunaan->baranghabis->laboratorium->user->id == auth()->user()->id) {
            $bahan = Bahan::find($penggunaan->baranghabis->bahan->id);
            $jumlah = $bahan->stok - $penggunaan->jumlah;
            if ($penggunaan->jumlah > $bahan->stok) {
                return redirect('/penggunaan')->with('fail', 'Stok bahan tidak mencukupi');
            } else if ($request->status == 'disetujui' && $bahan->stok >= $penggunaan->jumlah) {
                $penggunaan->update(['status' => $request->status]);
                Bahan::where('id', $bahan->id)->update(['stok' => $jumlah]);
            }
            return redirect('/penggunaan')->with('success', 'penggunaan ' . $penggunaan->nama . ' telah ' . $request->status);
        } else {
            abort(403);
        }
    }

    public function guna($id)
    {
        $baranghabis = baranghabis::find($id);
        return view('v_penggunaan.guna', [
            'title' => 'Tambah Data Penggunaan',
            'baranghabis' => $baranghabis
        ]);
    }
}
