<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BahanJurusan;
use App\Models\Laboratorium;
use App\Models\PeminjamanBahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BahanJurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('admin')->except(['index', 'show']);
    }

    public function index()
    {
        return view('v_bahanjurusan.index', [
            'title' => 'Data Bahan Jurusan',
            'bahanjurusans' => BahanJurusan::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BahanJurusan  $bahanJurusan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bahanjurusan = bahanjurusan::find($id);
        $qrcode = QrCode::size(200)->generate(route('scan', $bahanjurusan->kode));
        $user = User::find($bahanjurusan->laboratorium->user->id);
        $peminjamans = PeminjamanBahan::where('bahanjurusan_id', $bahanjurusan->id)->orderBy('tgl_pinjam', 'desc')->get();
        return view('v_bahanjurusan.show', [
            'title' => $bahanjurusan->bahanpraktikum->nama,
            'bahanjurusan' => $bahanjurusan,
            'qrcode' => $qrcode,
            'user' => $user,
            'peminjamans' => $peminjamans,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BahanJurusan  $bahanJurusan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bahanjurusan = BahanJurusan::find($id);
        $laboratoriums = Laboratorium::orderBy('nama')->get()->except([$bahanjurusan->laboratorium_id]);
        return view('v_bahanjurusan.edit', [
            'title' => $bahanjurusan->bahanpraktikum->nama,
            'bahanjurusan' => $bahanjurusan,
            'laboratoriums' => $laboratoriums,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BahanJurusan  $bahanJurusan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bahanjurusan = bahanjurusan::find($id);
        $rules = [
            'laboratorium_id' => 'required',
            'upload' => 'required',
            'nama' => 'required',
        ];

        if ($request->kode != $bahanjurusan->kode) {
            $rules['kode'] = 'required|unique:bahan_jurusans,kode';
        }

        $validatedData = $request->validate($rules);

        if ($request->file('upload')) {
            $validatedData['upload'] = $request->file('upload')->store('bahanjurusan-images');
            $validatedData['foto'] = $validatedData['upload'];
            unset($validatedData['upload']);
        }

        bahanjurusan::where('id', $bahanjurusan->id)->update($validatedData);
        return redirect('/bahanjurusan')->with('success', 'Ubah Data Bahan Jurusan Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BahanJurusan  $bahanJurusan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bahanjurusan = bahanjurusan::find($id);
        if ($bahanjurusan->foto) {
            Storage::delete($bahanjurusan->foto);
        }
        try {
            bahanjurusan::destroy($bahanjurusan->id);
            return redirect('/bahanjurusan')->with('success', 'Data Bahan Jurusan telah dihapus');
        } catch (\Throwable $th) {
            return redirect('/bahanjurusan')->with('fail', 'Gagal Menghapus Data karena Data Terhubung dengan Data Lain');
        }
    }
}
