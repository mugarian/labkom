<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Kegiatan;
use App\Models\Mahasiswa;
use App\Models\Pelaksanaan;
use App\Models\Laboratorium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelaksanaanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(auth()->user()->id);
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

        if ($user->role == 'mahasiswa' || $user->role == 'staff') {
            $kegiatan = Kegiatan::where('jenis', 'pelaksanaan')->where('kelas_id', $mahasiswa->kelas_id)->orderBy('mulai', 'desc')->get();
            $jabatan = 'ms';
            $dospem = 'false';
        } elseif ($user->role == 'dosen') {
            $dosen = Dosen::where('user_id', $user->id)->first();
            if ($dosen->jabatan == 'dosen pengampu') {
                if ($dosen->kepalalab == 'true') {
                    // kepala lab
                    // ? sort by kelas wali dosen

                    $laboratorium = Laboratorium::where('user_id', $dosen->user->id)->first();
                    $kegiatan = Kegiatan::where('jenis', 'pelaksanaan')->where('user_id', auth()->user()->id)->orWhere('dospem_id', $dosen->id)->orWhere('laboratorium_id', $laboratorium->id)->orderBy('mulai', 'desc')->get();
                    $jabatan = 'kalab';
                    $pengampu = Kegiatan::where('jenis', 'pelaksanaan')->where('dospem_id', $dosen->id)->get();
                    if ($pengampu) {
                        $dospem = 'true';
                    } else {
                        $dospem = 'false';
                    }
                } else {
                    // dosen pengampu
                    $kegiatan = Kegiatan::where('jenis', 'pelaksanaan')->where('user_id', auth()->user()->id)->orWhere('dospem_id', $dosen->id)->orderBy('mulai', 'desc')->get();
                    $jabatan = 'dospem';
                    $dospem = 'true';
                }
            } else {
                // ketua jurusan + prodi
                $kegiatan = Kegiatan::where('jenis', 'pelaksanaan')->orderBy('mulai', 'desc')->get();
                $jabatan = 'kajurpro';
                $dospem = 'false';
            }
        } else {
            //admin
            $kegiatan = Kegiatan::where('jenis', 'pelaksanaan')->orderBy('mulai', 'desc')->get();
            $jabatan = 'admin';
            $dospem = 'false';
        }

        $current_date = date('Y-m-d H:i:s');

        foreach ($kegiatan as $kg) {
            if ($current_date > $kg->selesai && $kg->status == 'berlangsung') {
                DB::table('kegiatans')->where('id', $kg->id)->update([
                    'status' => 'selesai'
                ]);
            }
        }

        $terakhir = Kegiatan::where('jenis', 'pelaksanaan')->where('user_id', auth()->user()->id)->orderBy('mulai', 'desc')->first();

        if ($terakhir) {
            if ($terakhir->status == 'selesai') {
                $selesai = 1;
            } else {
                $selesai = 0;
            }
        } else {
            $selesai = 1;
        }

        return view('v_pelaksanaan.index', [
            'title' => 'Data Pelaksanaan Praktikum',
            'pelaksanaans' => $kegiatan,
            'jabatan' => $jabatan,
            'dospem' => $dospem,
            'selesai' => $selesai,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $laboratorium = Laboratorium::where('user_id', auth()->user()->id)->first();

        if (!$laboratorium) {
            return redirect('pelaksanaan')->with('fail', 'Tambah Pelaksanaan Praktikum Hanya Diperuntukkan Bagi Kepala Lab');
        }

        $kelas = Kelas::orderBy('angkatan', 'desc')->get();
        $dospem = Dosen::all();
        return view('v_pelaksanaan.create', [
            'title' => 'Tambah Pelaksanaan Praktikum',
            'laboratorium' => $laboratorium,
            'kelas' => $kelas,
            'dospems' => $dospem
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
            'laboratorium_id' => 'required',
            'kelas_id' => 'required',
            'dospem_id' => 'required',
            'kode' => 'required|unique:kegiatans,kode',
            'nama' => 'required|max:255',
            'deskripsi' => 'required',
            'tipe' => 'required',
            'mulai' => 'required',
            'selesai' => 'required',
        ]);

        $kegiatan = Kegiatan::where('laboratorium_id', $validatedData['laboratorium_id'])->orderBy('mulai', 'desc')->first();

        if ($kegiatan->status == 'berlangsung') {
            return redirect('/pelaksanaan')->with('fail', 'Laboratorium Sedang Dipakai');
        }

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['jenis'] = 'pelaksanaan';
        $validatedData['status'] = 'disetujui';
        $validatedData['verif_dospem'] = 'disetujui';
        $validatedData['verif_kalab'] = 'disetujui';
        $validatedData['status'] = 'berlangsung';

        Kegiatan::create($validatedData);
        return redirect('/pelaksanaan')->with('success', 'Tambah Data Pelaksanaan Praktium Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pelaksanaan  $pelaksanaan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pelaksanaan = Kegiatan::find($id);
        return view('v_pelaksanaan.show', [
            'title' => $pelaksanaan->nama,
            'pelaksanaan' => $pelaksanaan,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pelaksanaan  $pelaksanaan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pelaksanaan $pelaksanaan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pelaksanaan  $pelaksanaan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $kegiatan = Kegiatan::find($id);
        $kegiatan->update([
            'status' => $request->status,
            'selesai' => Date('Y-m-d H:i:s'),
            'updated_at' => Date('Y-m-d H:i:s'),
        ]);

        return redirect('/pelaksanaan')->with('success', 'Data Pelaksanaan telah ' . $request->status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pelaksanaan  $pelaksanaan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pelaksanaan $pelaksanaan)
    {
    }
}
