@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Beranda /</a>
                Kegiatan /
                <a href="/pelaksanaan" class="text-secondary">Pelaksanaan Praktikum /</a>
            </span>
            <span class="text-primary">
                {{ $pelaksanaan->nama }}
            </span>
        </h5>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Pelaksanaan Praktikum</h5>
                        <small class="text-muted float-end">
                            <a href="/pelaksanaan">
                                < Kembali </a>
                        </small>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="status">status</label>
                            <p class="form-control">{{ $pelaksanaan->status }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kode">kode Kegiatan</label>
                            <p class="form-control">{{ $pelaksanaan->kode }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama kegiatan</label>
                            <p class="form-control">{{ $pelaksanaan->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="matakuliah">Mata Kuliah</label>
                            <p class="form-control">{{ $pelaksanaan->matakuliah->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jenis">jenis pelasanaan</label>
                            <p class="form-control">{{ $pelaksanaan->jenis }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tipe">tipe pelaksanaan</label>
                            <p class="form-control">{{ $pelaksanaan->tipe }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="laboratorium">laboratorium</label>
                            <p class="form-control">{{ $pelaksanaan->laboratorium->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="Dosen Pengampu">Dosen Pengampu</label>
                            <p class="form-control">{{ $pelaksanaan->dospem->user->nama }}</p>
                            {{-- <p class="form-control">{{ $dospem->user->nama }}</p> --}}
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="deskripsi">deskripsi</label>
                            <p class="form-control">{{ $pelaksanaan->deskripsi }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="semester">semester</label>
                            <p class="form-control">{{ $pelaksanaan->semester }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tahun_ajaran">tahun ajaran</label>
                            <p class="form-control">{{ $pelaksanaan->tahun_ajaran }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kelas">kelas</label>
                            <p class="form-control">{{ $pelaksanaan->kelas->nama }} ({{ $pelaksanaan->kelas->angkatan }})
                            </p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="mulai">Tanggal Mulai</label>
                            <p class="form-control">{{ $pelaksanaan->mulai }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="selesai">Tanggal selesai</label>
                            <p class="form-control">{{ $pelaksanaan->selesai ?? '-' }}</p>
                        </div>
                        @if ($pelaksanaan->status == 'berlangsung')
                            <div class="mb-3">
                                <a href="/pemakaian/{{ $pelaksanaan->id }}/kegiatan"
                                    class="btn btn-outline-primary">Pemakaian
                                    Alat</a>
                                <a href="/penggunaan/{{ $pelaksanaan->id }}/kegiatan"
                                    class="btn btn-outline-warning">Penggunaan
                                    Bahan Praktikum</a>
                            </div>
                        @endif
                        <div class="mb-3">
                            @if ($pelaksanaan->user_id == auth()->user()->id || $pelaksanaan->dospem->user_id == auth()->user()->id)
                                @if ($pelaksanaan->status == 'berlangsung')
                                    <form action="/pelaksanaan/{{ $pelaksanaan->id }}" method="post">
                                        @csrf
                                        @method('put')
                                        <input type="hidden" name="status" value="selesai">
                                        <button type="submit" class="btn btn-outline-primary" data-bs-toggle="tooltip"
                                            data-bs-placement="top" data-bs-title="Selesai">
                                            Selesai
                                        </button>
                                    </form>
                                @elseif ($pelaksanaan->status == 'terjadwal')
                                    <div class="d-flex justify-content-start">
                                        <form action="/pelaksanaan/{{ $pelaksanaan->id }}" method="post">
                                            @csrf
                                            @method('put')
                                            <input type="hidden" name="status" value="berlangsung">
                                            <button type="submit" class="btn btn-outline-primary" data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-title="Jadi">
                                                Jadi
                                            </button>
                                        </form>
                                        <form action="/pelaksanaan/{{ $pelaksanaan->id }}" method="post">
                                            @csrf
                                            @method('put')
                                            <input type="hidden" name="status" value="ditolak">
                                            <button type="submit" class="btn btn-outline-danger"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                data-bs-title="Tidak Jadi">
                                                Tidak Jadi
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
