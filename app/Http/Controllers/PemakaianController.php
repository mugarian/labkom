<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Kegiatan;
use App\Models\Pemakaian;
use App\Models\BarangPakai;
use App\Models\Laboratorium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $user = User::find(auth()->user()->id);
        if ($user->role == 'admin') {
            $pemakaian = Pemakaian::orderBy('mulai', 'desc')->paginate(5);
            $kalab = false;
        } elseif ($user->role == 'dosen') {
            $dosen = Dosen::where('user_id', $user->id)->first();
            if ($dosen->kepalalab == 'true') {
                $laboratorium = Laboratorium::where('user_id', $user->id)->first();
                $pemakaian = Pemakaian::orderBy('mulai', 'desc')->paginate(5);
                $kalab = true;

                // todo join pemakaian == barangpakai == laboratorium
                // SELECT pemakaians.id as id, barang_pakais.nama as namabarang, laboratorium.nama as namalab, kegiatans.nama as namakegiatan, users.nama as namauser, pemakaians.mulai as mulai, pemakaians.selesai as selesai
                // FROM pemakaians
                // INNER JOIN kegiatans ON pemakaians.kegiatan_id = kegiatans.id
                // INNER JOIN users ON pemakaians.user_id = users.id
                // INNER JOIN barang_pakais ON pemakaians.barangpakai_id = barang_pakais.id
                // INNER JOIN laboratorium ON barang_pakais.laboratorium_id = laboratorium.id
                // WHERE laboratorium.id = '00335b1f-420c-4610-bc8e-7069bb05ed47';

                $pemakaian = DB::table('pemakaians')
                    ->join('kegiatans', 'pemakaians.kegiatan_id', '=', 'kegiatans.id')
                    ->join('users', 'pemakaians.user_id', '=', 'users.id')
                    ->join('barang_pakais', 'pemakaians.barangpakai_id', '=', 'barang_pakais.id')
                    ->join('laboratorium', 'barang_pakais.laboratorium_id', '=', 'laboratorium.id')
                    ->where('laboratorium.id', '=', $laboratorium->id)
                    ->select('pemakaians.*', 'kegiatans.nama as namakegiatan', 'laboratorium.nama as namalab', 'barang_pakais.nama as namabarang', 'users.nama as namauser', 'users.id as iduser')
                    ->orderBy('pemakaians.mulai', 'desc')
                    ->paginate(5);

                // todo pemakaian->barangpakai->laboratorium->user->id == auth()->user()->id
            } else {
                $pemakaian = Pemakaian::where('user_id', $user->id)->orderBy('mulai', 'desc')->paginate(5);
                $kalab = false;
            }
        } else {
            $pemakaian = Pemakaian::where('user_id', $user->id)->orderBy('mulai', 'desc')->paginate(5);
            $kalab = false;
        }

        $akhir = Pemakaian::all()->last();
        return view('v_pemakaian.index', [
            'title' => 'Data pemakaian',
            'pemakaians' => $pemakaian,
            'akhir' => $akhir,
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
            if ($barangpakai->laboratorium->id != $kegiatan->laboratorium->id) {
                return redirect('/pemakaian')->with('fail', 'Barang tidak tersedia di kegiatan yang dimaksud');
            }
            if ($kegiatan->status != 'disetujui') {
                return redirect('/pemakaian')->with('fail', 'kode kegiatan tidak ada atau belum disetujui');
            }
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

    public function pakai($id)
    {
        $barangpakai = BarangPakai::find($id);
        return view('v_pemakaian.pakai', [
            'title' => 'Tambah Data Pemakaian',
            'barangpakai' => $barangpakai
        ]);
    }
}
