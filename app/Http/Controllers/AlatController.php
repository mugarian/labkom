<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use Ramsey\Uuid\Uuid;
use App\Models\Pemakaian;
use App\Models\BarangPakai;
use Illuminate\Support\Str;
use App\Models\Laboratorium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        $alats = Alat::orderBy('nama', 'asc')->get();
        $jumlahharga = DB::select('SELECT sum(harga) as jumlah, alat_id FROM barang_pakais GROUP BY alat_id');
        $total = BarangPakai::sum('harga');
        return view('v_alat.index', [
            'title' => 'Data Alat',
            'alats' => $alats,
            'jumlahharga' => $jumlahharga,
            'total' => "Rp " . number_format($total, 2, ',', '.'),
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
            'kategori' => 'required',
            'nama' => 'required|max:255',
            'spesifikasi' => 'required|max:255',
            'merk' => 'required',
            'tahun' => 'required',
            'upload' => 'required|image|mimes:jpg,jpeg,png|max:8000'
        ]);

        if ($request->file('upload')) {
            $validatedData['upload'] = $request->file('upload')->store('alat-images');
            $validatedData['foto'] = $validatedData['upload'];
            unset($validatedData['upload']);
        }

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
        $barangpakai = BarangPakai::where('alat_id', $alat->id)->get();
        $jumlahharga = BarangPakai::where('alat_id', $alat->id)->sum('harga');
        $pemakaians = DB::table('pemakaians')
            ->join('barang_pakais', 'pemakaians.barangpakai_id', '=', 'barang_pakais.id')
            ->select('barang_pakais.id as idbp', 'pemakaians.status as statuspemakaian')
            ->orderBy('pemakaians.mulai', 'desc')
            ->get();

        $peminjamans = DB::table('peminjaman_alats')
            ->join('barang_pakais', 'peminjaman_alats.barangpakai_id', '=', 'barang_pakais.id')
            ->join('laboratorium', 'barang_pakais.laboratorium_id', '=', 'laboratorium.id')
            ->select('barang_pakais.id as idbp', 'peminjaman_alats.status as statuspeminjaman')
            ->orderBy('peminjaman_alats.tgl_pinjam', 'desc')
            ->get();

        return view('v_alat.show', [
            'title' => $alat->nama,
            'alat' => $alat,
            'barangpakai' => $barangpakai,
            'jumlahharga' => $jumlahharga,
            'pemakaians' => $pemakaians,
            'peminjamans' => $peminjamans,
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
            'alat' => $alat,
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
            'merk' => 'required',
            'tahun' => 'required',
            'upload' => 'nullable|image|mimes:jpg,jpeg,png|max:8000'
        ];

        $validatedData = $request->validate($rules);


        if ($request->file('upload')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['upload'] = $request->file('upload')->store('alat-images');
            $validatedData['foto'] = $validatedData['upload'];
            unset($validatedData['upload']);
        }


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
