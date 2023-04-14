<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\BarangHabis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BahanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('v_bahan.index', [
            'title' => 'Data Bahan',
            'bahans' => Bahan::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('v_bahan.create', [
            'title' => 'Tambah Data Bahan',
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
            'nama' => 'required|max:255',
            'spesifikasi' => 'required|max:255',
            'harga' => 'required',
            'stok' => 'required',
            'merk' => 'required',
            'upload' => 'required|image|mimes:jpg,jpeg,png|max:8000'
        ]);

        if ($request->file('upload')) {
            $validatedData['upload'] = $request->file('upload')->store('bahan-images');
        }

        $validatedData['foto'] = $validatedData['upload'];
        unset($validatedData['upload']);

        Bahan::create($validatedData);
        return redirect('/bahan')->with('success', 'Tambah Data Bahan Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bahan  $bahan
     * @return \Illuminate\Http\Response
     */
    public function show(Bahan $bahan)
    {
        $baranghabis = BarangHabis::where('bahan_id', $bahan->id)->get();
        return view('v_bahan.show', [
            'title' => $bahan->nama,
            'bahan' => $bahan,
            'baranghabis' => $baranghabis
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bahan  $bahan
     * @return \Illuminate\Http\Response
     */
    public function edit(Bahan $bahan)
    {
        return view('v_bahan.edit', [
            'title' => 'Edit Data Bahan',
            'bahan' => $bahan
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bahan  $bahan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bahan $bahan)
    {
        $rules = [
            'nama' => 'required|max:255',
            'spesifikasi' => 'required|max:255',
            'harga' => 'required',
            'stok' => 'required',
            'merk' => 'required',
            'upload' => 'required|image|mimes:jpg,jpeg,png|max:8000'
        ];

        $validatedData = $request->validate($rules);

        if ($request->file('upload')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['upload'] = $request->file('upload')->store('bahan-images');
        }

        $validatedData['foto'] = $validatedData['upload'];
        unset($validatedData['upload']);

        Bahan::where('id', $bahan->id)->update($validatedData);

        return redirect('/bahan')->with('success', 'Data Bahan berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bahan  $bahan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bahan $bahan)
    {
        if ($bahan->foto) {
            Storage::delete($bahan->foto);
        }

        Bahan::destroy($bahan->id);
        return redirect('/bahan')->with('success', 'Data Bahan telah dihapus');
    }
}
