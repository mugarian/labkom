<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Kegiatan;
use App\Models\Mahasiswa;
use App\Models\Permohonan;
use App\Models\Laboratorium;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\NotifPermohonan;
use Illuminate\Support\Facades\Notification;

class PermohonanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has(['mulaidari', 'mulaisampai', 'selesaidari', 'selesaisampai'])) {
            $range_mulai = [$request->mulaidari, $request->mulaisampai];
            $range_selesai = [$request->selesaidari, $request->selesaisampai];
        } else {
            $mulaimin = date('Y-m-d H:i:s', strtotime(Kegiatan::where('jenis', 'permohonan')->min('mulai')));
            $mulaimax = date('Y-m-d H:i:s', strtotime(Kegiatan::where('jenis', 'permohonan')->max('mulai')));
            $selesaimin = date('Y-m-d H:i:s', strtotime(Kegiatan::where('jenis', 'permohonan')->min('selesai')));
            $selesaimax = date('Y-m-d H:i:s', strtotime(Kegiatan::where('jenis', 'permohonan')->max('selesai')));
            $range_mulai = [$mulaimin, $mulaimax];
            $range_selesai = [$selesaimin, $selesaimax];
        }

        $month = date('m');
        $year = date('Y');

        $semester = ($month > 6) ? 'genap' : 'ganjil';

        $permohonan = Kegiatan::where('jenis', 'permohonan')->orderBy('mulai', 'desc')->get();

        $user = User::find(auth()->user()->id);
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

        if ($user->role == 'mahasiswa' || $user->role == 'staff') {
            if ($permohonan->contains('selesai', NULL)) {
                $kegiatan = Kegiatan::where('jenis', 'permohonan')->where('semester', $semester)->where('tahun_ajaran', $year)->where('user_id', $user->id)->whereBetween('mulai', $range_mulai)->orderBy('mulai', 'desc')->get();
            } else {
                $kegiatan = Kegiatan::where('jenis', 'permohonan')->where('semester', $semester)->where('tahun_ajaran', $year)->where('user_id', $user->id)->whereBetween('mulai', $range_mulai)->whereBetween('selesai', $range_selesai)->orderBy('mulai', 'desc')->get();
            }
            $jabatan = 'ms';
            $dospem = 'false';
        } elseif ($user->role == 'dosen') {
            $dosen = Dosen::where('user_id', $user->id)->first();
            if ($dosen->jabatan == 'dosen pengampu') {
                if ($dosen->kepalalab == 'true') {
                    // kepala lab
                    // ? sort by kelas wali dosen

                    $laboratorium = Laboratorium::where('user_id', $dosen->user->id)->first();

                    if ($permohonan->contains('selesai', NULL)) {
                        $kegiatan = Kegiatan::where('jenis', 'permohonan')->where('semester', $semester)->where('tahun_ajaran', $year)->where('laboratorium_id', $laboratorium->id)->orWhere('user_id', auth()->user()->id)->orWhere('dospem_id', $dosen->id)->whereBetween('mulai', $range_mulai)->orderBy('mulai', 'desc')->get();
                        $pengampu = Kegiatan::where('jenis', 'permohonan')->where('semester', $semester)->where('tahun_ajaran', $year)->where('dospem_id', $dosen->id)->whereBetween('mulai', $range_mulai)->get();
                    } else {
                        $kegiatan = Kegiatan::where('jenis', 'permohonan')->where('semester', $semester)->where('tahun_ajaran', $year)->where('laboratorium_id', $laboratorium->id)->orWhere('user_id', auth()->user()->id)->orWhere('dospem_id', $dosen->id)->whereBetween('mulai', $range_mulai)->whereBetween('selesai', $range_selesai)->orderBy('mulai', 'desc')->get();
                        $pengampu = Kegiatan::where('jenis', 'permohonan')->where('semester', $semester)->where('tahun_ajaran', $year)->where('dospem_id', $dosen->id)->whereBetween('mulai', $range_mulai)->whereBetween('selesai', $range_selesai)->get();
                    }

                    $jabatan = 'kalab';
                    if ($pengampu) {
                        $dospem = 'true';
                    } else {
                        $dospem = 'false';
                    }
                } else {
                    // dosen pengampu
                    if ($permohonan->contains('selesai', NULL)) {
                        $kegiatan = Kegiatan::where('jenis', 'permohonan')->where('semester', $semester)->where('tahun_ajaran', $year)->where('user_id', auth()->user()->id)->orWhere('dospem_id', $dosen->id)->whereBetween('mulai', $range_mulai)->orderBy('mulai', 'desc')->get();
                    } else {
                        $kegiatan = Kegiatan::where('jenis', 'permohonan')->where('semester', $semester)->where('tahun_ajaran', $year)->where('user_id', auth()->user()->id)->orWhere('dospem_id', $dosen->id)->whereBetween('mulai', $range_mulai)->whereBetween('selesai', $range_selesai)->orderBy('mulai', 'desc')->get();
                    }

                    $jabatan = 'dospem';
                    $dospem = 'true';
                }
            } else {
                // ketua jurusan + prodi
                if ($permohonan->contains('selesai', NULL)) {
                    $kegiatan = Kegiatan::where('jenis', 'permohonan')->where('semester', $semester)->where('tahun_ajaran', $year)->whereBetween('mulai', $range_mulai)->orderBy('mulai', 'desc')->get();
                } else {
                    $kegiatan = Kegiatan::where('jenis', 'permohonan')->where('semester', $semester)->where('tahun_ajaran', $year)->whereBetween('mulai', $range_mulai)->whereBetween('selesai', $range_selesai)->orderBy('mulai', 'desc')->get();
                }

                $jabatan = 'kajurpro';
                $dospem = 'false';
            }
        } else {
            //admin
            if ($permohonan->contains('selesai', NULL)) {
                $kegiatan = Kegiatan::where('jenis', 'permohonan')->where('semester', $semester)->where('tahun_ajaran', $year)->whereBetween('mulai', $range_mulai)->orderBy('mulai', 'desc')->get();
            } else {
                $kegiatan = Kegiatan::where('jenis', 'permohonan')->where('semester', $semester)->where('tahun_ajaran', $year)->whereBetween('mulai', $range_mulai)->whereBetween('selesai', $range_selesai)->orderBy('mulai', 'desc')->get();
            }

            $jabatan = 'admin';
            $dospem = 'false';
        }

        $current_date = date('Y-m-d');
        $current_datetime = date('Y-m-d H:i:s');

        foreach ($kegiatan as $kg) {
            if ($current_datetime > $kg->selesai && $kg->status == 'berlangsung') {
                DB::table('kegiatans')->where('id', $kg->id)->update([
                    'status' => 'selesai'
                ]);
            }
            if ($current_date > $kg->mulai && $kg->status == 'menunggu') {
                DB::table('kegiatans')->where('id', $kg->id)->update([
                    'keterangan' => 'Permohonan Kadaluarsa',
                    'status' => 'ditolak',
                ]);
            }
        }

        $terakhir = Kegiatan::where('jenis', 'permohonan')->where('user_id', auth()->user()->id)->orderBy('mulai', 'desc')->first();

        if ($terakhir) {
            if ($terakhir->status == 'selesai' || $terakhir->status == 'ditolak') {
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

        $matkuls = MataKuliah::all();
        // $matkuls = $this->matakuliah();

        return view('v_permohonan.create', [
            'title' => 'Tambah Permohonan Kegiatan',
            'laboratoriums' => $laboratorium,
            'kelas' => $kelas,
            'dospems' => $dospem,
            'matkuls' => $matkuls
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
            'matakuliah_id' => 'required',
            'kode' => 'required|unique:kegiatans,kode',
            'nama' => 'required|max:255',
            'deskripsi' => 'required',
            'tipe' => 'required',
            'mulai' => 'required',
            'selesai' => 'required',
            'semester' => 'required',
            'tahun_ajaran' => 'required',
        ]);

        $kegiatan = Kegiatan::where('laboratorium_id', $validatedData['laboratorium_id'])->orderBy('mulai', 'desc')->first();

        if ($kegiatan) {
            if ($kegiatan->status == 'berlangsung') {
                return redirect('/permohonan')->with('fail', 'Laboratorium Sedang Dipakai');
            }
        }

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['jenis'] = 'permohonan';
        if (auth()->user()->role == 'dosen' || auth()->user()->role == 'staff') {
            $validatedData['verif_dospem'] = 'disetujui';
            $laboratorium = Laboratorium::find($validatedData['laboratorium_id']);
            $user = User::find($laboratorium->user->id);
        } else {
            $validatedData['verif_dospem'] = 'menunggu';
            $dosen = Dosen::find($validatedData['dospem_id']);
            $user = User::find($dosen->user->id);
        }
        $validatedData['verif_kalab'] = 'menunggu';
        $validatedData['status'] = 'menunggu';

        $pm = Kegiatan::create($validatedData);

        $pemohon = User::find($validatedData['user_id']);

        $title = 'Permohonan Kegiatan';
        $description = 'Verifikasi Permohonan ' . $pm->nama . ', Oleh ' . $pemohon->nama;
        $icon = 'bx bx-calendar';
        $uri = 'permohonan/' . $pm->id;


        Notification::send($user, new NotifPermohonan($title, $description, $uri, $icon));

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

        if ($kegiatan->verif_kalab == 'menunggu') {
            $user = User::find($kegiatan->laboratorium->user_id);
            $status = $request['verif_kalab'] . ' kalab';
        } else {
            $user = User::find($kegiatan->dospem->user->id);
            $status = $request['verif_dospem'] . ' dospem';
        }

        $pemohon = User::find($kegiatan->user_id);

        $title = 'Permohonan Kegiatan';
        $description = 'Verifikasi Permohonan ' . $kegiatan->nama . ', Oleh ' . $pemohon->nama . ' telah ' . $status;
        $icon = 'bx bx-calendar';
        $uri = 'permohonan/' . $kegiatan->id;

        Notification::send($user, new NotifPermohonan($title, $description, $uri, $icon));

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
            'verif_dospem' => 'nullable',
            'verif_kalab' => 'nullable',
            'keterangan' => 'required',
            'status' => 'required',
        ];

        $validatedData = $request->validate($rules);

        Kegiatan::where('id', $permohonan->id)->update($validatedData);

        $title = 'Permohonan Kegiatan';
        $description = 'Permohonan ' . $permohonan->nama . ' telah Ditolak';
        $icon = 'bx bx-calendar';
        $uri = 'permohonan/' . $permohonan->id;

        $user = User::find($permohonan->user_id);

        Notification::send($user, new NotifPermohonan($title, $description, $uri, $icon));

        return redirect('/permohonan')->with('success', 'Data permohonan berhasil ditolak');
    }

    public function matakuliah()
    {
        $matkuls = [
            'Pemrograman Dasar 1', 'Pengolahan Data & Informasi', 'Bahasa Inggris', 'Pendidikan Pancasila', 'Pendidikan Agama', 'Matematika Diskrit', 'Pengantar Teknologi Informasi dan Komunikasi', 'Sistem Informasi Manajemen', 'Pemrograman Berbasis Objek', 'Bahasa Inggris Teknis 1', 'Basis Data 1', 'Komunikasi Data dan Jaringan', 'Statistik dan Probabilitas', 'Sistem Informasi Akuntansi', 'Sistem Pengambil Keputusan', 'Data Mining', 'Bahasa Indonesia', 'Analisis dan Perancangan Sistem Informasi 2',
            'Pemrograman Dasar 2', 'Matematika Terapan', 'Manajemen', 'Sistem Operasi', 'Pendidikan Kewarganegaraan', 'Komunikasi Teknis', 'Pengatar Akuntansi', 'Project 1', 'Analisis dan Perancangan Sistem Informasi 1', 'Basis Data 2', 'Pemrograman Web', 'Etika Profesi', 'Data Warehouse', 'Project 2', 'Bahasa Inggris Teknis 2', 'E-Commerce', 'Manajemen Proyek', 'Perancangan Antar Muka', 'Kewirausahaan',
            'Lainnya'
        ];

        sort($matkuls);

        return $matkuls;
    }
}
