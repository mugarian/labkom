<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\User;
use App\Models\BarangPakai;
use Illuminate\Support\Str;
use App\Models\Laboratorium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BarangPakaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('dosen')->except(['show']);
    }

    public function index()
    {
        return view('v_barangpakai.index', [
            'title' => 'Data Barang Pakai',
            'barangpakai' => BarangPakai::all()
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
        $alats = Alat::all();
        $kode = Str::random(8);
        $kalab = Laboratorium::where('user_id', auth()->user()->id)->first();
        return view('v_barangpakai.create', [
            'title' => 'Data Barang Pakai',
            'laboratoriums' => $laboratoriums,
            'alats' => $alats,
            'kode' => $kode,
            'kalab' => $kalab
        ]);
    }

    public function tambah($lab)
    {
        $laboratorium = Laboratorium::find($lab);
        if (auth()->user()->role == 'admin' || $laboratorium->user->id == auth()->user()->id) {
            $alat = Alat::all();
            return view('v_barangpakai.create', [
                'title' => 'Tambah Data Barang Pakai',
                'laboratorium' => $laboratorium,
                'alats' => $alat
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
            'kode' => 'required|unique:barang_pakais',
            'nama' => 'required|max:255',
            'laboratorium_id' => 'required',
            'alat_id' => 'required',
            'deskripsi' => 'required',
            'keterangan' => 'required',
            'upload' => 'required|image|mimes:jpg,jpeg,png|max:8000'
        ]);

        if ($request->file('upload')) {
            $validatedData['upload'] = $request->file('upload')->store('barangpakai-images');
        }

        $validatedData['foto'] = $validatedData['upload'];
        unset($validatedData['upload']);

        BarangPakai::create($validatedData);

        return redirect('/barangpakai')->with('success', 'Tambah Data Barang Pakai Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BarangPakai  $barangPakai
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $barangpakai = BarangPakai::find($id);
        $qrcode = QrCode::size(200)->generate(route('scan', $barangpakai->kode));
        $user = User::find($barangpakai->laboratorium->user->id);
        return view('v_barangpakai.show', [
            'title' => $barangpakai->nama,
            'barangpakai' => $barangpakai,
            'qrcode' => $qrcode,
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BarangPakai  $barangPakai
     * @return \Illuminate\Http\Response
     */
    public function edit(BarangPakai $barangpakai)
    {
        if (auth()->user()->role == 'admin' || $barangpakai->laboratorium->user->id == auth()->user()->id) {
            $alat = Alat::all()->except([$barangpakai->alat_id]);
            $laboratoriums = Laboratorium::orderBy('nama')->get()->except([$barangpakai->laboratorium_id]);
            return view('v_barangpakai.edit', [
                'title' => $barangpakai->nama,
                'barangpakai' => $barangpakai,
                'laboratoriums' => $laboratoriums,
                'alats' => $alat
            ]);
        } else {
            abort(403);
        }
    }

    public function ubah($id)
    {
        $barangpakai = BarangPakai::find($id);
        if (auth()->user()->role == 'admin' || $barangpakai->laboratorium->user->id == auth()->user()->id) {
            $alat = Alat::all()->except([$barangpakai->alat_id]);
            return view('v_barangpakai.edit', [
                'title' => $barangpakai->nama,
                'barangpakai' => $barangpakai,
                'alats' => $alat
            ]);
        } else {
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BarangPakai  $barangPakai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BarangPakai $barangpakai)
    {
        if (auth()->user()->role == 'admin' || $barangpakai->laboratorium->user->id == auth()->user()->id) {
            $rules = [
                'nama' => 'required|max:255',
                'alat_id' => 'required',
                'laboratorium_id' => 'required',
                'deskripsi' => 'required',
                'keterangan' => 'required',
                'upload' => 'nullable|image|mimes:jpg,jpeg,png|max:8000'
            ];

            if ($request->kode != $barangpakai->kode) {
                $rules['kode'] = 'required|unique:barang_pakais';
            }

            $validatedData = $request->validate($rules);

            if ($request->file('upload')) {
                if ($request->oldImage) {
                    Storage::delete($request->oldImage);
                }
                $validatedData['upload'] = $request->file('upload')->store('barangpakai-images');
                $validatedData['foto'] = $validatedData['upload'];
                unset($validatedData['upload']);
            }


            BarangPakai::where('id', $barangpakai->id)->update($validatedData);
            return redirect('/barangpakai/')->with('success', 'Ubah Data Barang Pakai Berhasil');
        } else {
            abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BarangPakai  $barangPakai
     * @return \Illuminate\Http\Response
     */
    public function destroy(BarangPakai $barangpakai)
    {
        if (auth()->user()->role == 'admin' || $barangpakai->laboratorium->user->id == auth()->user()->id) {
            if ($barangpakai->foto) {
                Storage::delete($barangpakai->foto);
            }

            barangpakai::destroy($barangpakai->id);

            return redirect('/barangpakai')->with('success', 'Data Barang Pakai Berhasil Dihapus');
        } else {
            abort(403);
        }
    }
}
