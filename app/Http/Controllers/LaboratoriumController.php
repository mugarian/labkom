<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Bahan;
use App\Models\Dosen;
use App\Models\Kegiatan;
use App\Models\BarangPakai;
use App\Models\Laboratorium;
use Illuminate\Http\Request;
use App\Models\BahanPraktikum;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LaboratoriumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index()
    {
        // SELECT laboratorium.foto, laboratorium.nama, laboratorium.user_id, laboratorium.deskripsi, kegiatans.status, kegiatans.mulai FROM `kegiatans` INNER JOIN `laboratorium` ON kegiatans.laboratorium_id = laboratorium.id GROUP BY laboratorium.id ORDER BY kegiatans.mulai DESC;

        $laboratorium = laboratorium::orderBy('nama', 'asc')->get();

        $kegiatans = DB::table('kegiatans')
            ->join('laboratorium', 'kegiatans.laboratorium_id', '=', 'laboratorium.id')
            ->select('laboratorium.id as idlab', 'kegiatans.nama as namakegiatan', 'kegiatans.status as statuskegiatan', 'kegiatans.mulai as mulaikegiatan', 'kegiatans.selesai as selesaikegiatan')
            ->orderBy('kegiatans.mulai', 'desc')
            ->get();

        return view('v_laboratorium.index', [
            'title' => 'Data laboratorium',
            'laboratoriums' => $laboratorium,
            'kegiatans' => $kegiatans,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kepalalab = Dosen::where('kepalalab', 'false')->get();

        return view('v_laboratorium.create', [
            'title' => 'Tambah Data laboratorium',
            'kepalalab' => $kepalalab
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
            'user_id' => 'required',
            'deskripsi' => 'required',
            'upload' => 'required|image|mimes:jpg,jpeg,png|max:8000'
        ]);

        if ($request->file('upload')) {
            $validatedData['upload'] = $request->file('upload')->store('laboratorium-images');
            $validatedData['foto'] = $validatedData['upload'];
            unset($validatedData['upload']);
        }

        Laboratorium::create($validatedData);
        Dosen::where('user_id', $request->user_id)->update(['kepalalab' => 'true']);
        return redirect('/laboratorium')->with('success', 'Tambah Data laboratorium Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Laboratorium  $laboratorium
     * @return \Illuminate\Http\Response
     */
    public function show(Laboratorium $laboratorium)
    {
        $barangpakais = BarangPakai::where('laboratorium_id', $laboratorium->id)->orderBy('nama', 'asc')->get();
        $bahanpraktikums = BahanPraktikum::where('laboratorium_id', $laboratorium->id)->orderBy('nama', 'asc')->get();
        $kegiatan = Kegiatan::where('laboratorium_id', $laboratorium->id)->orderBy('mulai', 'desc')->first();
        return view('v_laboratorium.show', [
            'title' => $laboratorium->nama,
            'laboratorium' => $laboratorium,
            'barangpakais' => $barangpakais,
            'bahanpraktikums' => $bahanpraktikums,
            'kegiatan' => $kegiatan,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Laboratorium  $laboratorium
     * @return \Illuminate\Http\Response
     */
    public function edit(Laboratorium $laboratorium)
    {
        if (auth()->user()->role == 'admin' || $laboratorium->user->id == auth()->user()->id) {
            $kepalalab = Dosen::where('kepalalab', 'false')->get();
            return view('v_laboratorium.edit', [
                'title' => 'Edit Data laboratorium',
                'laboratorium' => $laboratorium,
                'kepalalab' => $kepalalab
            ]);
        } else {
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Laboratorium  $laboratorium
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Laboratorium $laboratorium)
    {
        if (auth()->user()->role == 'admin' || $laboratorium->user->id == auth()->user()->id) {
            $rules = [
                'nama' => 'required|max:255',
                'user_id' => 'required',
                'deskripsi' => 'required',
                'upload' => 'required|image|mimes:jpg,jpeg,png|max:8000'
            ];

            $validatedData = $request->validate($rules);

            if ($request->file('upload')) {
                if ($request->oldImage) {
                    Storage::delete($request->oldImage);
                }
                $validatedData['upload'] = $request->file('upload')->store('laboratorium-images');
                $validatedData['foto'] = $validatedData['upload'];
                unset($validatedData['upload']);
            }


            laboratorium::where('id', $laboratorium->id)->update($validatedData);
            Dosen::where('user_id', $request->user_id)->update(['kepalalab' => 'true']);
            return redirect('/laboratorium')->with('success', 'Data laboratorium berhasil diubah');
        } else {
            abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Laboratorium  $laboratorium
     * @return \Illuminate\Http\Response
     */
    public function destroy(Laboratorium $laboratorium)
    {
        if ($laboratorium->foto) {
            Storage::delete($laboratorium->foto);
        }

        Dosen::where('user_id', $laboratorium->user_id)->update(['kepalalab' => 'false']);
        laboratorium::destroy($laboratorium->id);

        return redirect('/laboratorium')->with('success', 'Data laboratorium telah dihapus');
    }
}
