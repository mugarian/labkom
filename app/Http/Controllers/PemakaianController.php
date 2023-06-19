<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\User;
use App\Models\Dosen;
use App\Models\Kegiatan;
use App\Models\Pemakaian;
use App\Models\Peminjaman;
use App\Models\BarangPakai;
use App\Models\Laboratorium;
use Illuminate\Http\Request;
use App\Models\PeminjamanAlat;
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
            $pemakaian = Pemakaian::orderBy('mulai', 'desc')->get();
            $kalab = false;
        } elseif ($user->role == 'dosen') {
            $dosen = Dosen::where('user_id', $user->id)->first();
            if ($dosen->kepalalab == 'true') {
                $laboratorium = Laboratorium::where('user_id', $user->id)->first();
                $pemakaian = Pemakaian::orderBy('mulai', 'desc')->get();
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
                    ->orWhere('users.id', '=', $user->id)
                    ->select('pemakaians.*', 'kegiatans.nama as namakegiatan', 'laboratorium.nama as namalab', 'barang_pakais.nama as namabarangpakai', 'users.nama as namauser', 'users.id as iduser')
                    ->orderBy('pemakaians.mulai', 'desc')
                    ->get();

                // todo pemakaian->barangpakai->laboratorium->user->id == auth()->user()->id
            } else {
                $pemakaian = Pemakaian::where('user_id', $user->id)->orderBy('mulai', 'desc')->get();
                $kalab = false;
            }
        } else {
            $pemakaian = Pemakaian::where('user_id', $user->id)->orderBy('mulai', 'desc')->get();
            $kalab = false;
        }

        $terakhir = Pemakaian::where('status', 'mulai')->where('user_id', auth()->user()->id)->orderBy('mulai', 'desc')->first();
        if ($terakhir) {
            if ($terakhir->status == 'selesai') {
                $selesai = 1;
            } else {
                $selesai = 0;
            }
        } else {
            $selesai = 1;
        }

        return view('v_pemakaian.index', [
            'title' => 'Data pemakaian',
            'pemakaians' => $pemakaian,
            'selesai' => $selesai,
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
        $pemakaianTerakhir = Pemakaian::where('barangpakai_id', $barangpakai->id)->where('status', 'mulai')->orderBy('mulai', 'desc')->first();
        $peminjamanTerakhir = PeminjamanAlat::where('barangpakai_id', $barangpakai->id)->where('status', 'disetujui')->orderBy('tgl_pinjam', 'desc')->first();

        if ($barangpakai && $kegiatan) {
            if ($barangpakai->laboratorium->id != $kegiatan->laboratorium->id) {
                return redirect('/pemakaian')->with('fail', 'barangpakai tidak tersedia di kegiatan yang dimaksud');
            }
            if ($pemakaianTerakhir) {
                return redirect('/pemakaian')->with('fail', 'barangpakai sedang dipakai');
            }
            if ($peminjamanTerakhir) {
                return redirect('/pemakaian')->with('fail', 'barangpakai sedang dipinjam');
            }
            if ($kegiatan->status != 'berlangsung') {
                return redirect('/pemakaian')->with('fail', 'Kegiatan yang dimaksud belum berlangsung atau sudah selesai');
            }
            $validatedData['barangpakai_id'] = $barangpakai->id;
            $validatedData['kegiatan_id'] = $kegiatan->id;
            $validatedData['mulai'] = date("Y-m-d H:i:s");

            Pemakaian::create($validatedData);
            return redirect('/pemakaian')->with('success', 'Tambah data Pemakaian berhasil');
        } else {
            if (!$barangpakai) {
                return redirect('/pemakaian')->with('fail', 'kode barangpakai tidak ditemukan');
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
            'cpu' => 'nullable',
            'monitor' => 'nullable',
            'keyboard' => 'nullable',
            'mouse' => 'nullable',
            'keterangan' => 'nullable',
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
