<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\BarangPakai;
use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlatController extends Controller
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
        return view('v_alat.index', [
            'title' => 'Data Alat',
            'alats' => Alat::orderBy('nama', 'asc')->paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('v_alat.create', [
            'title' => 'Tambah Data Alat',
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
            'kategori' => 'required',
            'spesifikasi' => 'required|max:255',
            'harga' => 'required',
            'stok' => 'required',
            'merk' => 'required',
            'upload' => 'required|image|mimes:jpg,jpeg,png|max:8000'
        ]);

        if ($request->file('upload')) {
            $validatedData['upload'] = $request->file('upload')->store('alat-images');
        }

        // $validatedData['id'] = (string) Uuid::uuid4();

        $validatedData['foto'] = $validatedData['upload'];
        unset($validatedData['upload']);


        Alat::create($validatedData);
        return redirect('/alat')->with('success', 'Tambah Data Alat Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Alat  $alat
     * @return \Illuminate\Http\Response
     */
    public function show(Alat $alat)
    {
        $barangpakai = BarangPakai::where('alat_id', $alat->id)->orderBy('nama', 'asc')->paginate(5);
        return view('v_alat.show', [
            'title' => $alat->nama,
            'alat' => $alat,
            'barangpakai' => $barangpakai
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Alat  $alat
     * @return \Illuminate\Http\Response
     */
    public function edit(Alat $alat)
    {
        return view('v_alat.edit', [
            'title' => 'Edit Data Alat',
            'alat' => $alat
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Alat  $alat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Alat $alat)
    {
        $rules = [
            'nama' => 'required|max:255',
            'kategori' => 'required',
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
            $validatedData['upload'] = $request->file('upload')->store('alat-images');
        }

        $validatedData['foto'] = $validatedData['upload'];
        unset($validatedData['upload']);

        Alat::where('id', $alat->id)->update($validatedData);

        return redirect('/alat')->with('success', 'Data Alat berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Alat  $alat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Alat $alat)
    {
        if ($alat->foto) {
            Storage::delete($alat->foto);
        }

        Alat::destroy($alat->id);
        return redirect('/alat')->with('success', 'Data Alat telah dihapus');
    }
}
