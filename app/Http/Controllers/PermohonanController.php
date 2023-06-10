<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Kegiatan;
use App\Models\Mahasiswa;
use App\Models\Permohonan;
use App\Models\Laboratorium;
use Illuminate\Http\Request;

class PermohonanController extends Controller
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
            $kegiatan = Kegiatan::where('jenis', 'permohonan')->where('kelas_id', $mahasiswa->kelas_id)->orderBy('mulai', 'desc')->get();
            $jabatan = 'ms';
            $dospem = 'false';
        } elseif ($user->role == 'dosen') {
            $dosen = Dosen::where('user_id', $user->id)->first();
            if ($dosen->jabatan == 'dosen pengampu') {
                if ($dosen->kepalalab == 'true') {
                    // kepala lab
                    // ? sort by kelas wali dosen

                    $laboratorium = Laboratorium::where('user_id', $dosen->user->id)->first();
                    $kegiatan = Kegiatan::where('jenis', 'permohonan')->where('user_id', auth()->user()->id)->orWhere('dospem_id', $dosen->id)->orWhere('laboratorium_id', $laboratorium->id)->orderBy('mulai', 'desc')->get();
                    $jabatan = 'kalab';
                    $pengampu = Kegiatan::where('jenis', 'permohonan')->where('dospem_id', $dosen->id)->get();
                    if ($pengampu) {
                        $dospem = 'true';
                    } else {
                        $dospem = 'false';
                    }
                } else {
                    // dosen pengampu
                    $kegiatan = Kegiatan::where('jenis', 'permohonan')->where('user_id', auth()->user()->id)->orWhere('dospem_id', $dosen->id)->orderBy('mulai', 'desc')->get();
                    $jabatan = 'dospem';
                    $dospem = 'true';
                }
            } else {
                // ketua jurusan + prodi
                $kegiatan = Kegiatan::where('jenis', 'permohonan')->orderBy('mulai', 'desc')->get();
                $jabatan = 'kajurpro';
                $dospem = 'false';
            }
        } else {
            //admin
            $kegiatan = Kegiatan::where('jenis', 'permohonan')->orderBy('mulai', 'desc')->get();
            $jabatan = 'admin';
            $dospem = 'false';
        }

        $terakhir = Kegiatan::where('jenis', 'permohonan')->where('user_id', auth()->user()->id)->orderBy('mulai', 'desc')->first();

        if ($terakhir) {
            if ($terakhir->status == 'selesai') {
                $selesai = 1;
            } else {
                $selesai = 0;
            }
        } else {
            $selesai = 1;
        }

        return view('v_permohonan.index', [
            'title' => 'Data kegiatan',
            'permohonans' => $kegiatan,
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
        $laboratorium = Laboratorium::orderBy('nama', 'asc')->get();
        if (auth()->user()->role == 'dosen') {
            $dospem = Dosen::where('user_id', auth()->user()->id)->get();
        } else {
            $dospem = Dosen::all();
        }

        if (auth()->user()->role == 'mahasiswa') {
            $mahasiswa = Mahasiswa::where('user_id', auth()->user()->id)->first();
            $kelas = Kelas::where('id', $mahasiswa->kelas_id)->get();
        } elseif (auth()->user()->role == 'dosen') {
            $dosen = Dosen::where('user_id', auth()->user()->id)->first();
            $kelas = Kelas::where('jurusan', $dosen->jurusan)->orderBy('angkatan', 'desc')->get();
        } else {
            $kelas = Kelas::orderBy('angkatan', 'desc')->get();
        }

        return view('v_permohonan.create', [
            'title' => 'Tambah Permohonan Kegiatan',
            'laboratoriums' => $laboratorium,
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
            'kelas_id' => 'nullable',
            'dospem_id' => 'nullable',
            'kode' => 'required|unique:kegiatans,kode',
            'nama' => 'required|max:255',
            'deskripsi' => 'required',
            'tipe' => 'required',
            'mulai' => 'required',
        ]);

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['jenis'] = 'permohonan';
        if (auth()->user()->role == 'dosen' || auth()->user()->role == 'staff') {
            $validatedData['verif_dospem'] = 'disetujui';
        } else {
            $validatedData['verif_dospem'] = 'menunggu';
        }
        $validatedData['verif_kalab'] = 'menunggu';
        $validatedData['status'] = 'menunggu';

        Kegiatan::create($validatedData);
        return redirect('/permohonan')->with('success', 'Tambah Data Permohonan Kegiatan Berhasil');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permohonan  $permohonan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permohonan = Kegiatan::find($id);
        return view('v_permohonan.show', [
            'title' => $permohonan->nama,
            'permohonan' => $permohonan,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permohonan  $permohonan
     * @return \Illuminate\Http\Response
     */
    public function edit(Permohonan $permohonan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permohonan  $permohonan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $kegiatan = Kegiatan::find($id);

        if (!$request->mulai) {
            $request['mulai'] = $kegiatan->mulai;
        }
        if (!$request->selesai) {
            $request['selesai'] = $kegiatan->selesai;
        }

        if (!$request->verif_dospem || !$request->verif_kalab) {
            $request['verif_dospem'] = $kegiatan->verif_dospem;
            $request['verif_kalab'] = $kegiatan->verif_kalab;
        }

        $kegiatan->update([
            'verif_dospem' => $request->verif_dospem,
            'verif_kalab' => $request->verif_kalab,
            'status' => $request->status,
            'mulai' => $request->mulai,
            'selesai' => $request->selesai,
            'updated_at' => Date('Y-m-d H:i:s'),
        ]);

        return redirect('/permohonan')->with('success', 'Data Permohonan telah ' . $request->status);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permohonan  $permohonan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permohonan $permohonan)
    {
        //
    }

    public function ditolak($id)
    {
        $permohonan = Kegiatan::find($id);
        return view('v_permohonan.ditolak', [
            'title' => 'Permohonan Kegiatan Ditolak',
            'permohonan' => $permohonan,
        ]);
    }

    public function updateDitolak(Request $request, $id)
    {
        $permohonan = Kegiatan::find($id);
        $rules = [
            'keterangan' => 'required',
            'status' => 'required',
        ];

        $validatedData = $request->validate($rules);

        $dosen = Dosen::where('user_id', auth()->user()->id)->first();
        if ($dosen->kepalalab == 'true') {
            $validatedData['verif_kalab'] = 'ditolak';
        } else {
            $validatedData['verif_dospem'] = 'ditolak';
        }

        Kegiatan::where('id', $permohonan->id)->update($validatedData);

        return redirect('/permohonan')->with('success', 'Data permohonan berhasil ditolak');
    }
}
