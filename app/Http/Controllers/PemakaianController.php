<?php

namespace App\Http\Controllers;

use App\Models\BarangPakai;
use App\Models\Kegiatan;
use App\Models\Pemakaian;
use Illuminate\Http\Request;
use PhpParser\NodeVisitor\FirstFindingVisitor;

class PemakaianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->role == 'admin') {
            $pemakaian = Pemakaian::all();
        } else {
            $pemakaian = Pemakaian::where('user_id', auth()->user()->id)->get();
        }
        $akhir = Pemakaian::all()->last();
        return view('v_pemakaian.index', [
            'title' => 'Data pemakaian',
            'pemakaians' => $pemakaian,
            'akhir' => $akhir
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('v_pemakaian.create', [
            'title' => 'Tambah Data Pemakaian',
            'barangpakai' => null
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
            'barangpakai_id' => 'required',
            'kegiatan_id' => 'required',
        ]);

        $barangpakai = BarangPakai::where('kode', $validatedData['barangpakai_id'])->first();
        $kegiatan = Kegiatan::where('kode', $validatedData['kegiatan_id'])->first();

        if ($barangpakai && $kegiatan) {
            $validatedData['barangpakai_id'] = $barangpakai->id;
            $validatedData['kegiatan_id'] = $kegiatan->id;
            $validatedData['mulai'] = date("Y-m-d H:i:s");

            Pemakaian::create($validatedData);
            return redirect('/pemakaian')->with('success', 'Tambah data Pemakaian berhasil');
        } else {
            if (!$barangpakai) {
                return redirect('/pemakaian')->with('fail', 'kode barang tidak ditemukan');
            } else {
                return redirect('/pemakaian')->with('fail', 'kode kegiatan tidak ditemukan');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pemakaian  $pemakaian
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pemakaian = pemakaian::find($id);
        return view('v_pemakaian.show', [
            'title' => 'Pemakaian ' . $pemakaian->barangpakai->nama,
            'pemakaian' => $pemakaian,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pemakaian  $pemakaian
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pemakaian = pemakaian::find($id);
        return view('v_pemakaian.edit', [
            'title' => 'Edit Data pemakaian',
            'pemakaian' => $pemakaian,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pemakaian  $pemakaian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $pemakaian = pemakaian::find($id);
        $rules = [
            'selesai' => 'required',
            'keterangan' => 'required',
        ];

        $validatedData = $request->validate($rules);
        $validatedData['status'] = 'selesai';

        pemakaian::where('id', $pemakaian->id)->update($validatedData);

        return redirect('/pemakaian')->with('success', 'Data pemakaian berhasil diselesaikan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pemakaian  $pemakaian
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pemakaian $pemakaian)
    {
        //
    }
}
