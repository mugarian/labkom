@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Beranda /</a>
                Kegiatan /
                <a href="/permohonan" class="text-secondary">Permohonan Kegiatan /</a>
            </span>
            <span class="text-primary">
                {{ $permohonan->nama }}
            </span>
        </h5>


        {{-- <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-start">
                            <a href="/permohonan/{{ $permohonan->id }}/edit" class="btn btn-outline-warning me-3">Edit</a>
                            <form action="/permohonan/{{ $permohonan->id }}" method="post">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-outline-danger">
                                    Delete
                                </button>
                            </form>
                        </div>
            </div>
            <div class="card-body">
                <div class="my-3 col-12 mb-0">
                    <div class="alert alert-primary">
                        <h6 class="alert-heading fw-bold mb-1">Status permohonan</h6>
                        <p class="mb-0">
                            permohonan bertipe permohonan bisa dilaksanakan ketika status sudah diverifikasi <br>
                            oleh Dosen Pengampu dan disetujui Kepala Lab
                        </p>
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Permohonan Kegiatan</h5>
                        <small class="text-muted float-end">
                            <a href="/permohonan">
                                < Kembali </a>
                        </small>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="verif_dospem">Verifikasi Dospem</label>
                            <p class="form-control">{{ $permohonan->verif_dospem }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="verif_kalab">Verifikasi Kalab</label>
                            <p class="form-control">{{ $permohonan->verif_kalab }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="status">status</label>
                            <p class="form-control">{{ $permohonan->status }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="keterangan">keterangan</label>
                            <p class="form-control">{{ $permohonan->keterangan ?? '-' }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kode">kode</label>
                            <p class="form-control">{{ $permohonan->kode }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama</label>
                            <p class="form-control">{{ $permohonan->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="matakuliah">Mata Kuliah</label>
                            <p class="form-control">{{ $permohonan->matakuliah->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jenis">jenis</label>
                            <p class="form-control">{{ $permohonan->jenis }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="laboratorium">laboratorium</label>
                            <p class="form-control">{{ $permohonan->laboratorium->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="Dosen Pengampu">Dosen Pengampu</label>
                            <p class="form-control">{{ $permohonan->dospem->user->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="deskripsi">deskripsi</label>
                            <p class="form-control">{{ $permohonan->deskripsi }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="semester">semester</label>
                            <p class="form-control">{{ $permohonan->semester }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tahun_ajaran">tahun ajaran</label>
                            <p class="form-control">{{ $permohonan->tahun_ajaran }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="mulai">Tanggal Mulai</label>
                            <p class="form-control">{{ $permohonan->mulai }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="selesai">Tanggal selesai</label>
                            <p class="form-control">{{ $permohonan->selesai ?? '-' }}</p>
                        </div>

                        <div class="mb-3 d-flex justify-content-start">
                            @if ($permohonan->user_id == auth()->user()->id)
                                @if ($permohonan->status == 'disetujui')
                                    <form action="/permohonan/{{ $permohonan->id }}" method="post">
                                        @csrf
                                        @method('put')
                                        <input type="hidden" name="status" value="berlangsung">
                                        <input type="hidden" name="mulai" value="{{ Date('Y-m-d H:i:s') }}">
                                        <button type="submit" class="btn btn-outline-primary" data-bs-toggle="tooltip"
                                            data-bs-placement="top" data-bs-title="Mulai">
                                            Mulai
                                        </button>
                                    </form>
                                @elseif ($permohonan->status == 'berlangsung')
                                    <form action="/permohonan/{{ $permohonan->id }}" method="post">
                                        @csrf
                                        @method('put')
                                        <input type="hidden" name="status" value="selesai">
                                        <input type="hidden" name="selesai" value="{{ Date('Y-m-d H:i:s') }}">
                                        <button type="submit" class="btn btn-primary" data-bs-toggle="tooltip"
                                            data-bs-placement="top" data-bs-title="Selesai">
                                            Selesai
                                        </button>
                                    </form>
                                @endif
                                {{-- Dospem --}}
                            @elseif ($permohonan->dospem->user_id == auth()->user()->id)
                                @if ($permohonan->verif_dospem == 'menunggu' && $permohonan->status == 'menunggu')
                                    <form action="/permohonan/{{ $permohonan->id }}" method="post">
                                        @csrf
                                        @method('put')
                                        <input type="hidden" name="verif_dospem" value="disetujui">
                                        @if ($permohonan->laboratorium->user_id == auth()->user()->id)
                                            <input type="hidden" name="verif_kalab" value="disetujui">
                                            <input type="hidden" name="status" value="disetujui">
                                        @else
                                            <input type="hidden" name="status" value="menunggu">
                                            <input type="hidden" name="verif_kalab" value="menunggu">
                                        @endif
                                        <button type="submit" class="btn btn-outline-primary" data-bs-toggle="tooltip"
                                            data-bs-placement="top" data-bs-title="Dospem Setuju">
                                            Setuju
                                        </button>
                                    </form>
                                    <a href="/permohonan/{{ $permohonan->id }}/ditolak" class="btn btn-outline-danger "
                                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Menolak">
                                        Tolak
                                    </a>
                                @endif
                            @endif
                            @if ($permohonan->laboratorium->user_id == auth()->user()->id)
                                @if ($permohonan->verif_dospem == 'disetujui' && $permohonan->verif_kalab == 'menunggu')
                                    <form action="/permohonan/{{ $permohonan->id }}" method="post">
                                        @csrf
                                        @method('put')
                                        <input type="hidden" name="verif_dospem" value="disetujui">
                                        <input type="hidden" name="verif_kalab" value="disetujui">
                                        <input type="hidden" name="status" value="disetujui">
                                        <button type="submit" class="btn btn-outline-primary " data-bs-toggle="tooltip"
                                            data-bs-placement="top" data-bs-title="Setuju">
                                            Setuju
                                        </button>
                                    </form>
                                    <a href="/permohonan/{{ $permohonan->id }}/ditolak" class="btn btn-outline-danger "
                                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tolak">
                                        Tolak
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
