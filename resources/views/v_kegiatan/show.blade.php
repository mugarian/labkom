@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="/kegiatan" class="text-secondary">Data
                    Kegiatan</a>
                /</span> {{ $kegiatan->nama }}</h4>

        {{-- <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-start">
                            <a href="/kegiatan/{{ $kegiatan->id }}/edit" class="btn btn-outline-warning me-3">Edit</a>
                            <form action="/kegiatan/{{ $kegiatan->id }}" method="post">
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
                        <h6 class="alert-heading fw-bold mb-1">Status Kegiatan</h6>
                        <p class="mb-0">
                            Kegiatan bertipe permohonan bisa dilaksanakan ketika status sudah diverifikasi <br>
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
                        <h5 class="mb-0">kegiatan</h5>
                        <small class="text-muted float-end">
                            <a href="/kegiatan">
                                < Kembali </a>
                        </small>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="status">status</label>
                            <p class="form-control">{{ $kegiatan->status }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="status">Keterangan</label>
                            <p class="form-control">{{ $kegiatan->keterangan ?? '-' }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kode">kode</label>
                            <p class="form-control">{{ $kegiatan->kode }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama</label>
                            <p class="form-control">{{ $kegiatan->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jenis">jenis</label>
                            <p class="form-control">{{ $kegiatan->jenis }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="laboratorium">laboratorium</label>
                            <p class="form-control">{{ $kegiatan->laboratorium->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="Dosen Pembimbing">Dosen Pembimbing</label>
                            <p class="form-control">{{ $kegiatan->dospem->user->nama }}</p>
                            {{-- <p class="form-control">{{ $dospem->user->nama }}</p> --}}
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="deskripsi">deskripsi</label>
                            <p class="form-control">{{ $kegiatan->deskripsi }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="mulai">Tanggal Mulai</label>
                            <p class="form-control">{{ $kegiatan->mulai }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Perhatian</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="alert alert-primary">
                                <h6 class="alert-heading fw-bold mb-1">Status Kegiatan</h6>
                                <p class="mb-0">
                                    Kegiatan berjenis permohonan bisa dilaksanakan ketika status sudah diverifikasi
                                    oleh Dosen Pengampu dan disetujui Kepala Lab
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
