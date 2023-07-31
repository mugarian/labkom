<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\User;
use App\Models\Dosen;
use App\Models\Pemakaian;
use App\Models\BarangPakai;
use Illuminate\Support\Str;
use App\Models\Laboratorium;
use App\Models\PeminjamanAlat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $this->middleware('dosen')->except(['index', 'show']);
    }

    public function index()
    {
        return view('v_barangpakai.index', [
            'title' => 'Data Barang Pakai',
            'barangpakai' => BarangPakai::all(),
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
        return view('v_barangpakai.create', [
            'title' => 'Data Barang Pakai',
            'laboratoriums' => $laboratoriums,
            'alats' => $alats,
            'kode' => $kode,
        ]);
    }

    public function tambah($id)
    {
        $laboratorium = Laboratorium::all();
        if (auth()->user()->role == 'admin' || $laboratorium->user->id == auth()->user()->id) {
            $alat = Alat::find($id);
            $kode = Str::random(8);
            return view('v_barangpakai.create', [
                'title' => 'Tambah Data Barang Pakai',
                'laboratoriums' => $laboratorium,
                'alat' => $alat,
                'kode' => $kode
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
            'harga' => 'required',
            'laboratorium_id' => 'required',
            'alat_id' => 'required',
            'tahun' => 'required',
            'upload' => 'required|image|mimes:jpg,jpeg,png|max:8000'
        ]);

        if ($request->file('upload')) {
            $validatedData['upload'] = $request->file('upload')->store('barangpakai-images');
            $validatedData['foto'] = $validatedData['upload'];
            unset($validatedData['upload']);
        }


        BarangPakai::create($validatedData);

        return redirect('/alat/' . $request->alat_id)->with('success', 'Tambah Data Barang Pakai Berhasil');
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
        $pemakaians = Pemakaian::where('barangpakai_id', '=', $barangpakai->id)->where('status', 'mulai')->orderBy('mulai', 'desc')->get();
        $peminjamans = PeminjamanAlat::where('barangpakai_id', '=', $barangpakai->id)->where('status', 'disetujui')->orderBy('tgl_pinjam', 'desc')->get();
        $pemakaianTerakhir = Pemakaian::where('barangpakai_id', $barangpakai->id)->where('status', 'mulai')->orderBy('mulai', 'desc')->first();
        $peminjamanAlatTerakhir = PeminjamanAlat::where('barangpakai_id', $barangpakai->id)->where('status', 'disetujui')->orderBy('tgl_pinjam', 'desc')->first();
        return view('v_barangpakai.show', [
            'title' => $barangpakai->nama,
            'barangpakai' => $barangpakai,
            'qrcode' => $qrcode,
            'user' => $user,
            'pemakaians' => $pemakaians,
            'peminjamans' => $peminjamans,
            'pemakaianTerakhir' => $pemakaianTerakhir,
            'peminjamanAlatTerakhir' => $peminjamanAlatTerakhir,
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
                'status' => 'required',
                'tahun' => 'required',
                'harga' => 'required',
                'laboratorium_id' => 'required',
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
            return redirect('/alat/' . $request->alat_id)->with('success', 'Ubah Data Barang Pakai Berhasil');
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
        $alat = $barangpakai->alat_id;
        if (auth()->user()->role == 'admin' || $barangpakai->laboratorium->user->id == auth()->user()->id) {
            try {
                if ($barangpakai->foto) {
                    Storage::delete($barangpakai->foto);
                }

                barangpakai::destroy($barangpakai->id);
                return redirect('/alat/' . $alat)->with('success', 'Data Barang Pakai Berhasil Dihapus');
            } catch (\Throwable $th) {
                return redirect('/alat/' . $alat)->with('fail', 'Gagal Menghapus Data Karena Data Terhubung dengan Data Lain');
            }
        } else {
            abort(403);
        }
    }
}
