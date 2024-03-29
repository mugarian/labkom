<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Kegiatan;
use App\Models\Mahasiswa;
use App\Models\Pelaksanaan;
use App\Models\Laboratorium;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Notifications\NotifPermohonan;
use Illuminate\Support\Facades\Notification;

class PelaksanaanController extends Controller
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
            $mulaimin = date('Y-m-d H:i:s', strtotime(Kegiatan::where('jenis', 'pelaksanaan')->min('mulai')));
            $mulaimax = date('Y-m-d H:i:s', strtotime(Kegiatan::where('jenis', 'pelaksanaan')->max('mulai')));
            $selesaimin = date('Y-m-d H:i:s', strtotime(Kegiatan::where('jenis', 'pelaksanaan')->min('selesai')));
            $selesaimax = date('Y-m-d H:i:s', strtotime(Kegiatan::where('jenis', 'pelaksanaan')->max('selesai')));
            $range_mulai = [$mulaimin, $mulaimax];
            $range_selesai = [$selesaimin, $selesaimax];
        }

        $month = date('m');
        $year = date('Y');

        $semester = ($month > 6) ? 'genap' : 'ganjil';

        $pelaksanaan = Kegiatan::where('jenis', 'pelaksanaan')->orderBy('mulai', 'desc')->get();

        $user = User::find(auth()->user()->id);
        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();
        if ($user->role == 'mahasiswa' || $user->role == 'staff') {
            if ($pelaksanaan->contains('selesai', NULL)) {
                $kegiatan = Kegiatan::where('jenis', 'pelaksanaan')->where('tahun_ajaran', $year)->where('kelas_id', $mahasiswa->kelas_id)->whereBetween('mulai', $range_mulai)->orderBy('mulai', 'desc')->get();
            } else {
                $kegiatan = Kegiatan::where('jenis', 'pelaksanaan')->where('tahun_ajaran', $year)->where('kelas_id', $mahasiswa->kelas_id)->whereBetween('mulai', $range_mulai)->whereBetween('selesai', $range_selesai)->orderBy('mulai', 'desc')->get();
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

                    if ($pelaksanaan->contains('selesai', NULL)) {
                        $kegiatan = Kegiatan::where('jenis', 'pelaksanaan')->where('tahun_ajaran', $year)->where('user_id', auth()->user()->id)->orWhere('dospem_id', $dosen->id)->orWhere('laboratorium_id', $laboratorium->id)->whereBetween('mulai', $range_mulai)->orderBy('mulai', 'desc')->get();
                        $pengampu = Kegiatan::where('jenis', 'pelaksanaan')->where('tahun_ajaran', $year)->where('dospem_id', $dosen->id)->whereBetween('mulai', $range_mulai)->get();
                    } else {
                        $kegiatan = Kegiatan::where('jenis', 'pelaksanaan')->where('tahun_ajaran', $year)->where('user_id', auth()->user()->id)->orWhere('dospem_id', $dosen->id)->orWhere('laboratorium_id', $laboratorium->id)->whereBetween('mulai', $range_mulai)->whereBetween('selesai', $range_selesai)->orderBy('mulai', 'desc')->get();
                        $pengampu = Kegiatan::where('jenis', 'pelaksanaan')->where('tahun_ajaran', $year)->where('dospem_id', $dosen->id)->whereBetween('mulai', $range_mulai)->whereBetween('selesai', $range_selesai)->get();
                    }

                    $jabatan = 'kalab';
                    if ($pengampu) {
                        $dospem = 'true';
                    } else {
                        $dospem = 'false';
                    }
                } else {
                    // dosen pengampu
                    if ($pelaksanaan->contains('selesai', NULL)) {
                        $kegiatan = Kegiatan::where('jenis', 'pelaksanaan')->where('tahun_ajaran', $year)->where('user_id', auth()->user()->id)->orWhere('dospem_id', $dosen->id)->whereBetween('mulai', $range_mulai)->orderBy('mulai', 'desc')->get();
                    } else {
                        $kegiatan = Kegiatan::where('jenis', 'pelaksanaan')->where('tahun_ajaran', $year)->where('user_id', auth()->user()->id)->orWhere('dospem_id', $dosen->id)->whereBetween('mulai', $range_mulai)->whereBetween('selesai', $range_selesai)->orderBy('mulai', 'desc')->get();
                    }
                    $jabatan = 'dospem';
                    $dospem = 'true';
                }
            } else {
                // ketua jurusan + prodi
                if ($pelaksanaan->contains('selesai', NULL)) {
                    $kegiatan = Kegiatan::where('jenis', 'pelaksanaan')->where('tahun_ajaran', $year)->orderBy('mulai', 'desc')->whereBetween('mulai', $range_mulai)->get();
                } else {
                    $kegiatan = Kegiatan::where('jenis', 'pelaksanaan')->where('tahun_ajaran', $year)->orderBy('mulai', 'desc')->whereBetween('mulai', $range_mulai)->whereBetween('selesai', $range_selesai)->get();
                }
                $jabatan = 'kajurpro';
                $dospem = 'false';
            }
        } else {
            //admin
            if ($pelaksanaan->contains('selesai', NULL)) {
                $kegiatan = Kegiatan::where('jenis', 'pelaksanaan')->where('tahun_ajaran', $year)->orderBy('mulai', 'desc')->whereBetween('mulai', $range_mulai)->get();
            } else {
                $kegiatan = Kegiatan::where('jenis', 'pelaksanaan')->where('tahun_ajaran', $year)->orderBy('mulai', 'desc')->whereBetween('mulai', $range_mulai)->whereBetween('selesai', $range_selesai)->get();
            }
            $jabatan = 'admin';
            $dospem = 'false';
        }

        $current_date = date('Y-m-d H:i:s');

        foreach ($kegiatan as $kg) {
            if ($current_date > $kg->selesai) {
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
        // $matkuls = $this->matakuliah();
        $matkuls = MataKuliah::all();

        return view('v_pelaksanaan.create', [
            'title' => 'Tambah Pelaksanaan Praktikum',
            'laboratorium' => $laboratorium,
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
            'kelas_id' => 'required',
            'dospem_id' => 'required',
            'matakuliah_id' => 'required',
            'kode' => 'required|unique:kegiatans,kode',
            'nama' => 'required|max:255',
            'deskripsi' => 'required',
            'tipe' => 'required',
            'mulai' => 'required',
            'tahun_ajaran' => 'required',
            'semester' => 'required',
            'selesai' => 'required',
        ]);

        $kegiatan = Kegiatan::where('laboratorium_id', $validatedData['laboratorium_id'])->where('status', 'berlangsung')->orderBy('mulai', 'desc')->first();

        if ($kegiatan) {
            return redirect('/pelaksanaan')->with('fail', 'Laboratorium Sedang Dipakai');
        }

        $validatedData['user_id'] = auth()->user()->id;
        $validatedData['jenis'] = 'pelaksanaan';
        $validatedData['status'] = 'disetujui';
        $validatedData['verif_dospem'] = 'disetujui';
        $validatedData['verif_kalab'] = 'disetujui';
        $validatedData['status'] = 'terjadwal';

        $pl = Kegiatan::create($validatedData);

        $dospem = Dosen::find($validatedData['dospem_id']);
        $dosen = User::find($dospem->user_id);

        $title = 'Pelaksanaan Kegiatan';
        $description = 'Pelaksanaan ' . $pl->nama . ', Telah Dijadawlkan ';
        $icon = 'bx bx-calendar';
        $uri = 'pelaksanaan/' . $pl->id;

        Notification::send($dosen, new NotifPermohonan($title, $description, $uri, $icon));

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
        if ($request->status == 'berlangsung') {
            $kegiatan->update([
                'status' => $request->status,
                'updated_at' => Date('Y-m-d H:i:s'),
            ]);
        } else {
            $kegiatan->update([
                'status' => $request->status,
                'selesai' => Date('Y-m-d H:i:s'),
                'updated_at' => Date('Y-m-d H:i:s'),
            ]);
        }

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
