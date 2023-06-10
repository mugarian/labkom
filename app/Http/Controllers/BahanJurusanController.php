<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BahanJurusan;
use App\Models\Laboratorium;
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
        return view('v_bahanjurusan.show', [
            'title' => $bahanjurusan->bahanpraktikum->nama,
            'bahanjurusan' => $bahanjurusan,
            'qrcode' => $qrcode,
            'user' => $user
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
        ];

        if ($request->kode != $bahanjurusan->kode) {
            $rules['kode'] = 'required|unique:bahan_jurusans,kode';
        }

        $validatedData = $request->validate($rules);

        bahanjurusan::where('id', $bahanjurusan->id)->update($validatedData);
        return redirect('/bahanjurusan')->with('success', 'Ubah Data Bahan Praktikum Berhasil');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BahanJurusan  $bahanJurusan
     * @return \Illuminate\Http\Response
     */
    public function destroy(BahanJurusan $bahanJurusan)
    {
        //
    }
}
