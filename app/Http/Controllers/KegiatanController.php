<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Kegiatan;
use App\Models\Laboratorium;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Validated;
use Illuminate\Contracts\Support\ValidatedData;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('dosen')->only(['pelaksanaan', 'storePelaksanaan', 'edit', 'update']);
    }

    public function index()
    {

        /**
         * AKTOR
         * admin = all
         * dosen
         *  - kepala lab = user_id / laboratorium_id
         *  - dosen pengampu = user_id / dospem_id
         *  - ketua jurusan = all
         * mahasiswa  & staff = user_id
         *
         *
         */

        $user = User::find(auth()->user()->id);

        if ($user->role == 'mahasiswa' || $user->role == 'staff') {
            $kegiatan = Kegiatan::where('user_id', auth()->user()->id)->orderBy('mulai', 'desc')->paginate(5);
            $jabatan = 'ms';
            $dospem = 'false';
        } elseif ($user->role == 'dosen') {
            $dosen = Dosen::where('user_id', $user->id)->first();
            if ($dosen->jabatan == 'dosen pengampu') {
                if ($dosen->kepalalab == 'true') {
                    // kepala lab
                    $laboratorium = Laboratorium::where('user_id', $dosen->user->id)->first();
                    $kegiatan = Kegiatan::where('user_id', auth()->user()->id)->orWhere('dospem_id', $dosen->id)->orWhere('laboratorium_id', $laboratorium->id)->orderBy('mulai', 'desc')->paginate(5);
                    $jabatan = 'kalab';
                    $pengampu = Kegiatan::where('dospem_id', $dosen->id)->get();
                    if ($pengampu) {
                        $dospem = 'true';
                    } else {
                        $dospem = 'false';
                    }
                } else {
                    // dosen pengampu
                    $kegiatan = Kegiatan::where('user_id', auth()->user()->id)->orWhere('dospem_id', $dosen->id)->orderBy('mulai', 'desc')->paginate(5);
                    $jabatan = 'dospem';
                    $dospem = 'true';
                }
            } else {
                // ketua jurusan + prodi
                $kegiatan = Kegiatan::orderBy('mulai', 'desc')->paginate(5);
                $jabatan = 'kajurpro';
                $dospem = 'false';
            }
        } else {
            //admin
            $kegiatan = Kegiatan::orderBy('mulai', 'desc')->paginate(5);
            $jabatan = 'admin';
            $dospem = 'false';
        }

        return view('v_kegiatan.index', [
            'title' => 'Data kegiatan',
            'kegiatans' => $kegiatan,
            'jabatan' => $jabatan,
            'dospem' => $dospem
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // $laboratorium = Laboratorium::all();
        // return view('v_kegiatan.create', [
        //     'title' => 'Tambah Kegiatan Perkuliahan',
        //     'laboratoriums' => $laboratorium
        // ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $validatedData = $request->validate([
        //     'user_id' => 'nullable',
        //     'dospem_id' => 'nullable',
        //     'laboratorium_id' => 'required',
        //     'kode' => 'required:unique:kegiatans,kode',
        //     'nama' => 'required|max:255',
        //     'jenis' => 'required|',
        //     'deskripsi' => 'required',
        //     'mulai' => 'required',
        // ]);

        // if ($validatedData['jenis'] == 'perkuliahan') {
        //     $dosen = Dosen::where('user_id', auth()->user()->id)->first();
        //     $validatedData['dospem_id'] = $dosen->id;
        //     $validatedData['status'] = 'disetujui';
        // }

        // Kegiatan::create($validatedData);
        // return redirect('/kegiatan')->with('success', 'Tambah Data kegiatan Berhasil');
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
        return view('v_kegiatan.show', [
            'title' => $kegiatan->nama,
            'kegiatan' => $kegiatan,
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
            'keterangan' => 'required',
        ];

        $validatedData = $request->validate($rules);
        $validatedData['status'] = 'ditolak';

        Kegiatan::where('id', $kegiatan->id)->update($validatedData);

        return redirect('/kegiatan')->with('success', 'Data kegiatan berhasil ditolak');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kegiatan  $kegiatan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // kegiatan::destroy($id);
        // return redirect('/kegiatan')->with('success', 'Data kegiatan telah dihapus');
    }

    public function pelaksanaan()
    {
        $laboratorium = Laboratorium::where('user_id', auth()->user()->id)->first();
        return view('v_kegiatan.pelaksanaan', [
            'title' => 'Tambah Kegiatan Perkuliahan',
            'laboratorium' => $laboratorium
        ]);
    }

    public function storePelaksanaan(Request $request)
    {
        $dosen = Dosen::where('user_id', auth()->user()->id)->first();
        $validatedData = $request->validate([
            'laboratorium_id' => 'required',
            'kode' => 'required|unique:kegiatans,kode',
            'nama' => 'required|max:255',
            'deskripsi' => 'required',
            'jenis' => 'required',
            'tipe' => 'required',
            'mulai' => 'required',
        ]);

        $dosen = Dosen::where('user_id', auth()->user()->id)->first();

        $validatedData['status'] = 'disetujui';
        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['dospem_id'] = $dosen->id;

        if ($validatedData['jenis'] == 'perkuliahan') {
        }

        Kegiatan::create($validatedData);
        return redirect('/kegiatan')->with('success', 'Tambah Data kegiatan Berhasil');
    }

    public function permohonan()
    {
        $laboratorium = Laboratorium::all();
        $dospem = Dosen::all();
        $dosen = Dosen::where('user_id', auth()->user()->id)->first();
        return view('v_kegiatan.permohonan', [
            'title' => 'Tambah Kegiatan Permohanan',
            'laboratoriums' => $laboratorium,
            'dospems' => $dospem,
            'dosen' => $dosen
        ]);
    }

    public function storePermohonan(Request $request)
    {
        $validatedData = $request->validate([
            'dospem_id' => 'required',
            'laboratorium_id' => 'required',
            'kode' => 'required|unique:kegiatans,kode',
            'nama' => 'required|max:255',
            'deskripsi' => 'required',
            'jenis' => 'required',
            'tipe' => 'required',
            'mulai' => 'required',
        ]);

        if (auth()->user()->role == 'dosen') {
            $validatedData['status'] = 'diverifikasi';
        } else {
            $validatedData['status'] = 'menunggu';
        }

        $validatedData['user_id'] = auth()->user()->id;

        Kegiatan::create($validatedData);
        return redirect('/kegiatan')->with('success', 'Tambah Data kegiatan Berhasil');
    }

    public function status(Request $request, $id)
    {
        $kegiatan = Kegiatan::find($id);
        $kegiatan->update(['status' => $request->status]);

        return redirect('/kegiatan')->with('success', 'Kegiatan ' . $kegiatan->nama . ' telah ' . $request->status);
    }
}
