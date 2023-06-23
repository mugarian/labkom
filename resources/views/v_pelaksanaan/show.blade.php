@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Home /</a>
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
                            <label class="form-label" for="Dosen Pembimbing">Dosen Pembimbing</label>
                            <p class="form-control">{{ $pelaksanaan->dospem->user->nama }}</p>
                            {{-- <p class="form-control">{{ $dospem->user->nama }}</p> --}}
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="deskripsi">deskripsi</label>
                            <p class="form-control">{{ $pelaksanaan->deskripsi }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="mulai">Tanggal Mulai</label>
                            <p class="form-control">{{ $pelaksanaan->mulai }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="selesai">Tanggal selesai</label>
                            <p class="form-control">{{ $pelaksanaan->selesai ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
