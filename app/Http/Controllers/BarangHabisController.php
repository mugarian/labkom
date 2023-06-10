<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Bahan;
use App\Models\Dosen;
use App\Models\BarangHabis;
use Illuminate\Support\Str;
use App\Models\Laboratorium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BarangHabisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('dosen')->except(['index', 'show']);
    }

    public function index()
    {
        if (auth()->user()->role == 'dosen') {
            $kalab = Dosen::where('user_id', auth()->user()->id)->first()->kepalalab;
        } else {
            $kalab = 'false';
        }
        return view('v_baranghabis.index', [
            'title' => 'Data Barang Habis',
            'baranghabis' => BarangHabis::all(),
            'kalab' => $kalab
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
        $bahans = Bahan::all();
        $kode = Str::random(8);
        $kalab = Laboratorium::where('user_id', auth()->user()->id)->first();
        return view('v_baranghabis.create', [
            'title' => 'Data Barang Babis',
            'laboratoriums' => $laboratoriums,
            'bahans' => $bahans,
            'kode' => $kode,
            'kalab' => $kalab
        ]);
    }

    public function tambah($lab)
    {
        $laboratorium = Laboratorium::find($lab);
        if (auth()->user()->role == 'admin' || $laboratorium->user->id == auth()->user()->id) {
            $bahan = Bahan::all();
            return view('v_baranghabis.create', [
                'title' => 'Tambah Data Barang Habis',
                'laboratorium' => $laboratorium,
                'bahans' => $bahan
            ]);
        } else {
            abort(403);
        }
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
            'kode' => 'required|unique:barang_habis',
            'nama' => 'required|max:255',
            'laboratorium_id' => 'required',
            'bahan_id' => 'required',
            'deskripsi' => 'required',
            'keterangan' => 'required',
            'upload' => 'required|image|mimes:jpg,jpeg,png|max:8000'
        ]);

        if ($request->file('upload')) {
            $validatedData['upload'] = $request->file('upload')->store('baranghabis-images');
            $validatedData['foto'] = $validatedData['upload'];
            unset($validatedData['upload']);
        }

        BarangHabis::create($validatedData);

        return redirect('/baranghabis')->with('success', 'Tambah Data Barang Habis Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BarangHabis  $barangHabis
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $baranghabis = BarangHabis::find($id);
        $qrcode = QrCode::size(200)->generate(route('scan', $baranghabis->kode));
        $user = User::find($baranghabis->laboratorium->user->id);
        return view('v_baranghabis.show', [
            'title' => $baranghabis->nama,
            'baranghabis' => $baranghabis,
            'qrcode' => $qrcode,
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BarangHabis  $barangHabis
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $baranghabis = BarangHabis::find($id);
        if (auth()->user()->role == 'admin' || $baranghabis->laboratorium->user->id == auth()->user()->id) {
            $bahan = bahan::all()->except([$baranghabis->bahan_id]);
            $laboratoriums = Laboratorium::orderBy('nama')->get()->except([$baranghabis->laboratorium_id]);
            return view('v_baranghabis.edit', [
                'title' => $baranghabis->nama,
                'baranghabis' => $baranghabis,
                'laboratoriums' => $laboratoriums,
                'bahans' => $bahan
            ]);
        } else {
            abort(403);
        }
    }

    public function ubah($id)
    {
        $baranghabis = BarangHabis::find($id);
        if (auth()->user()->role == 'admin' || $baranghabis->laboratorium->user->id == auth()->user()->id) {
            $bahan = Bahan::all()->except([$baranghabis->bahan_id]);
            return view('v_baranghabis.edit', [
                'title' => $baranghabis->nama,
                'baranghabis' => $baranghabis,
                'bahans' => $bahan
            ]);
        } else {
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BarangHabis  $barangHabis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $baranghabis = BarangHabis::find($id);
        if (auth()->user()->role == 'admin' || $baranghabis->laboratorium->user->id == auth()->user()->id) {
            $rules = [
                'nama' => 'required|max:255',
                'bahan_id' => 'required',
                'deskripsi' => 'required',
                'keterangan' => 'required',
                'upload' => 'nullable|image|mimes:jpg,jpeg,png|max:8000'
            ];

            if ($request->kode != $baranghabis->kode) {
                $rules['kode'] = 'required|unique:barang_habis';
            }

            $validatedData = $request->validate($rules);

            if ($request->file('upload')) {
                if ($request->oldImage) {
                    Storage::delete($request->oldImage);
                }
                $validatedData['upload'] = $request->file('upload')->store('baranghabis-images');
                $validatedData['foto'] = $validatedData['upload'];
                unset($validatedData['upload']);
            }


            BarangHabis::where('id', $baranghabis->id)->update($validatedData);
            return redirect('/baranghabis')->with('success', 'Ubah Data Barang Habis Berhasil');
        } else {
            abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BarangHabis  $barangHabis
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $baranghabis = BarangHabis::find($id);
        if (auth()->user()->role == 'admin' || $baranghabis->laboratorium->user->id == auth()->user()->id) {
            $laboratorium = Laboratorium::find($baranghabis->laboratorium_id);

            if ($baranghabis->foto) {
                Storage::delete($baranghabis->foto);
            }

            BarangHabis::destroy($baranghabis->id);

            return redirect('/baranghabis')->with('success', 'Data Barang Habis Berhasil Dihapus');
        } else {
            abort(403);
        }
    }
}
