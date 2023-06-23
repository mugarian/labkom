<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kelas = Kelas::orderBy('nama', 'asc')->get();
        return view('v_kelas.index', [
            'title' => 'Data kelas',
            'kelass' => $kelas,
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

        return view('v_kelas.create', [
            'title' => 'Tambah Data Kelas',
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
            'angkatan' => 'required',
            'jurusan' => 'required',
        ]);

        Kelas::create($validatedData);
        return redirect('/kelas')->with('success', 'Tambah Data Kelas Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kelas = Kelas::find($id);
        $mahasiswas = Mahasiswa::where('kelas_id', $kelas->id)->get();
        return view('v_kelas.show', [
            'title' => $kelas->nama,
            'kelas' => $kelas,
            'mahasiswas' => $mahasiswas,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kelas = Kelas::find($id);
        $dosens = Dosen::where('id', '<>', $kelas->dosen_id)->get();

        return view('v_kelas.edit', [
            'title' => 'Edit Data laboratorium',
            'kelas' => $kelas,
            'dosens' => $dosens
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $kelas = Kelas::find($id);
        $rules = [
            'nama' => 'required|max:255',
            'dosen_id' => 'required',
            'angkatan' => 'required',
            'jurusan' => 'required',
        ];

        $validatedData = $request->validate($rules);

        Kelas::where('id', $kelas->id)->update($validatedData);
        return redirect('/kelas')->with('success', 'Data Kelas berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Kelas::destroy($id);

            return redirect('/kelas')->with('success', 'Data Kelas telah dihapus');
        } catch (\Throwable $th) {
            return redirect('/kelas')->with('fail', 'Gagal Menghapus Data Karena Data Terhubung dengan Data Lain');
        }
    }
}
