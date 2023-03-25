<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Kegiatan;
use App\Models\Laboratorium;
use Illuminate\Auth\Events\Validated;
use Illuminate\Contracts\Support\ValidatedData;
use Illuminate\Http\Request;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dospem = Dosen::where('user_id', auth()->user()->id)->first();
        if (auth()->user()->role == 'mahasiswa' || auth()->user()->role == 'staff') {
            $kegiatan = Kegiatan::where('user_id', auth()->user()->id)->get();
        } elseif (auth()->user()->role == 'dosen') {
            $kegiatan = Kegiatan::where('user_id', auth()->user()->id)->orWhere('dospem_id', $dospem->id);
            if ($dospem->kepalalab == 'true') {
                $laboratorium = Laboratorium::where('user_id', $dospem->user->id)->first();
                $kegiatan = $kegiatan->orWhere('laboratorium_id', $laboratorium->id);
            }
            $kegiatan = $kegiatan->get();
        } else {
            $kegiatan = Kegiatan::all();
        }
        return view('v_kegiatan.index', [
            'title' => 'Data kegiatan',
            'kegiatans' => $kegiatan,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $laboratorium = Laboratorium::all();
        return view('v_kegiatan.create', [
            'title' => 'Tambah Kegiatan Perkuliahan',
            'laboratoriums' => $laboratorium
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
            'user_id' => 'nullable',
            'dospem_id' => 'nullable',
            'laboratorium_id' => 'required',
            'kode' => 'required:unique:kegiatans,kode',
            'nama' => 'required|max:255',
            'jenis' => 'required|',
            'deskripsi' => 'required',
            'mulai' => 'required',
        ]);

        if ($validatedData['jenis'] == 'perkuliahan') {
            $dosen = Dosen::where('user_id', auth()->user()->id)->first();
            $validatedData['dospem_id'] = $dosen->id;
            $validatedData['status'] = 'disetujui';
        }

        Kegiatan::create($validatedData);
        return redirect('/kegiatan')->with('success', 'Tambah Data kegiatan Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kegiatan = Kegiatan::find($id);
        $dospem = Dosen::find($kegiatan->dospem_id);
        return view('v_kegiatan.show', [
            'title' => $kegiatan->nama,
            'kegiatan' => $kegiatan,
            'dospem' => $dospem
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $laboratorium = Laboratorium::all();
        $kegiatan = Kegiatan::find($id);
        $dospem = Dosen::all();
        return view('v_kegiatan.edit', [
            'title' => 'Edit Data kegiatan',
            'kegiatan' => $kegiatan,
            'laboratoriums' => $laboratorium,
            'dospems' => $dospem
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $kegiatan = Kegiatan::find($id);
        $rules = [
            'user_id' => 'nullable',
            'dospem_id' => 'nullable',
            'laboratorium_id' => 'required',
            'kode' => 'required:unique:kegiatans,kode',
            'nama' => 'required|max:255',
            'jenis' => 'required|',
            'deskripsi' => 'required',
            'mulai' => 'required',
        ];

        $validatedData = $request->validate($rules);

        Kegiatan::where('id', $kegiatan->id)->update($validatedData);

        return redirect('/kegiatan')->with('success', 'Data kegiatan berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        kegiatan::destroy($id);
        return redirect('/kegiatan')->with('success', 'Data kegiatan telah dihapus');
    }

    public function peminjaman()
    {
        $dospem = Dosen::all();
        $laboratorium = Laboratorium::all();
        return view('v_kegiatan.peminjaman', [
            'title' => 'Tambah Kegiatan Peminjaman',
            'laboratoriums' => $laboratorium,
            'dospems' => $dospem
        ]);
    }

    public function status(Request $request, $id)
    {
        $kegiatan = Kegiatan::find($id);
        $kegiatan->update(['status' => $request->status]);

        return redirect('/kegiatan')->with('success', 'Kegiatan ' . $kegiatan->nama . ' telah ' . $request->status);
    }
}
