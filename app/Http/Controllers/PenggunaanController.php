<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\Kegiatan;
use App\Models\Penggunaan;
use App\Models\BarangHabis;
use App\Models\Laboratorium;
use Illuminate\Http\Request;

class PenggunaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $penggunaan = Penggunaan::all();
        return view('v_penggunaan.index', [
            'title' => 'Data penggunaan',
            'penggunaans' => $penggunaan,
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
            'keterangan' => 'required',
        ]);

        $baranghabis = BarangHabis::where('kode', $validatedData['baranghabis_id'])->first();
        $kegiatan = kegiatan::where('kode', $validatedData['kegiatan_id'])->first();

        if ($baranghabis && $kegiatan) {
            if ($validatedData['jumlah'] > $baranghabis->bahan->stok) {
                return redirect('/penggunaan')->with('fail', 'Jumlah Penggunaan melebihi stok');
            }

            $validatedData['baranghabis_id'] = $baranghabis->id;
            $validatedData['kegiatan_id'] = $kegiatan->id;
            $validatedData['tanggal'] = date("Y-m-d H:i:s");
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
    public function show(Penggunaan $penggunaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Penggunaan  $penggunaan
     * @return \Illuminate\Http\Response
     */
    public function edit(Penggunaan $penggunaan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Penggunaan  $penggunaan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Penggunaan $penggunaan)
    {
        //
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
        $bahan = Bahan::find($penggunaan->baranghabis->bahan->id);
        $jumlah = $bahan->stok - $penggunaan->jumlah;
        $penggunaan->update(['status' => $request->status]);
        if ($request->status == 'disetujui') {
            Bahan::where('id', $bahan->id)->update(['stok'], $jumlah);
        }

        return redirect('/penggunaan')->with('success', 'penggunaan ' . $penggunaan->nama . ' telah ' . $request->status);
    }
}
