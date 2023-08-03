<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\MataKuliah;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $matkuls = MataKuliah::orderBy('nama', 'asc')->get();
        return view('v_matakuliah.index', [
            'title' => 'Data Mata Kuliah',
            'matkuls' => $matkuls,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dosens = Dosen::all();

        return view('v_matakuliah.create', [
            'title' => 'Tambah Data Mata Kuliah',
            'dosens' => $dosens
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
            'dosen_id' => 'required',
            'jurusan' => 'required',
        ]);

        MataKuliah::create($validatedData);
        return redirect('/matakuliah')->with('success', 'Tambah Data Mata Kuliah Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MataKuliah  $mataKuliah
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $matkul = MataKuliah::find($id);
        return view('v_matakuliah.show', [
            'title' => $matkul->nama,
            'matkul' => $matkul,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MataKuliah  $mataKuliah
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $matakuliah = MataKuliah::find($id);
        $dosens = Dosen::where('id', '<>', $matakuliah->dosen_id)->get();

        return view('v_matakuliah.edit', [
            'title' => 'Edit Data Mata Kuliah',
            'matakuliah' => $matakuliah,
            'dosens' => $dosens
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MataKuliah  $mataKuliah
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $matakuliah = MataKuliah::find($id);
        $rules = [
            'nama' => 'required|max:255',
            'dosen_id' => 'required',
            'jurusan' => 'required',
        ];

        $validatedData = $request->validate($rules);

        MataKuliah::where('id', $matakuliah->id)->update($validatedData);
        return redirect('/matakuliah')->with('success', 'Data Mata Kuliah berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MataKuliah  $mataKuliah
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            MataKuliah::destroy($id);

            return redirect('/matakuliah')->with('success', 'Data Mata Kuliah telah dihapus');
        } catch (\Throwable $th) {
            return redirect('/matakuliah')->with('fail', 'Gagal Menghapus Data Karena Data Terhubung dengan Data Lain');
        }
    }
}
