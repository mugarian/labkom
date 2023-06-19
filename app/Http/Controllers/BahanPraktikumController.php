<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Penggunaan;
use Illuminate\Support\Str;
use App\Models\Laboratorium;
use Illuminate\Http\Request;
use App\Models\BahanPraktikum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BahanPraktikumController extends Controller
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
        $bahanpraktikum = BahanPraktikum::orderBy('nama', 'asc')->get();
        $total = BahanPraktikum::sum('harga');
        return view('v_bahanpraktikum.index', [
            'title' => 'Data Bahan Praktikum',
            'bahanpraktikums' => $bahanpraktikum,
            'total' => "Rp " . number_format($total, 2, ',', '.'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $laboratoriums = Laboratorium::orderBy('nama')->get();
        $kode = Str::random(8);
        return view('v_bahanpraktikum.create', [
            'title' => 'Data Bahan Praktikum',
            'laboratoriums' => $laboratoriums,
            'kode' => $kode,
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
            'laboratorium_id' => 'required',
            'kode' => 'required|unique:bahan_praktikums,kode',
            'jenis' => 'required',
            'nama' => 'required|max:255',
            'merk' => 'required',
            'spesifikasi' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            'tahun' => 'required',
            'upload' => 'required|image|mimes:jpg,jpeg,png|max:8000'
        ]);

        if ($request->file('upload')) {
            $validatedData['upload'] = $request->file('upload')->store('bahanpraktikum-images');
            $validatedData['foto'] = $validatedData['upload'];
            unset($validatedData['upload']);
        }

        BahanPraktikum::create($validatedData);

        return redirect('/bahanpraktikum')->with('success', 'Tambah Data Bahan Praktikum Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BahanPraktikum  $bahanPraktikum
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bahanpraktikum = BahanPraktikum::find($id);
        $qrcode = QrCode::size(200)->generate(route('scan', $bahanpraktikum->kode));
        $user = User::find($bahanpraktikum->laboratorium->user->id);
        $penggunaans = Penggunaan::where('bahanpraktikum_id', $bahanpraktikum->id)->orderBy('tanggal', 'desc')->get();
        return view('v_bahanpraktikum.show', [
            'title' => $bahanpraktikum->nama,
            'bahanpraktikum' => $bahanpraktikum,
            'qrcode' => $qrcode,
            'user' => $user,
            'penggunaans' => $penggunaans
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BahanPraktikum  $bahanPraktikum
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bahanpraktikum = BahanPraktikum::find($id);
        $laboratoriums = Laboratorium::orderBy('nama')->get()->except([$bahanpraktikum->laboratorium_id]);
        return view('v_bahanpraktikum.edit', [
            'title' => $bahanpraktikum->nama,
            'bahanpraktikum' => $bahanpraktikum,
            'laboratoriums' => $laboratoriums,
            'bahanpraktikum' => $bahanpraktikum
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BahanPraktikum  $bahanPraktikum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bahanpraktikum = BahanPraktikum::find($id);
        $rules = [
            'nama' => 'required|max:255',
            'laboratorium_id' => 'required',
            'jenis' => 'required',
            'merk' => 'required',
            'spesifikasi' => 'required',
            'harga' => 'required',
            'stok' => 'required',
            'tahun' => 'required',
            'upload' => 'nullable|image|mimes:jpg,jpeg,png|max:8000'
        ];

        if ($request->kode != $bahanpraktikum->kode) {
            $rules['kode'] = 'required|unique:bahan_praktikums,kode';
        }

        $validatedData = $request->validate($rules);

        if ($request->file('upload')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['upload'] = $request->file('upload')->store('bahanpraktikum-images');
            $validatedData['foto'] = $validatedData['upload'];
            unset($validatedData['upload']);
        }

        BahanPraktikum::where('id', $bahanpraktikum->id)->update($validatedData);
        return redirect('/bahanpraktikum')->with('success', 'Ubah Data Bahan Praktikum Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BahanPraktikum  $bahanPraktikum
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bahanpraktikum = BahanPraktikum::find($id);
        if ($bahanpraktikum->foto) {
            Storage::delete($bahanpraktikum->foto);
        }

        BahanPraktikum::destroy($bahanpraktikum->id);

        return redirect('/bahanpraktikum')->with('success', 'Data Bahan Praktikum Berhasil Dihapus');
    }
}
