@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Beranda /</a>
                Logbook /
                <a href="/pemakaian" class="text-secondary">Pemakaian Alat /</a>
            </span>
            <span class="text-primary">
                {{ $pemakaian->barangpakai->nama }}
            </span>
        </h5>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Pemakaian Alat</h5>
                        <small class="text-muted float-end"><a href="/pemakaian">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="mulai">Tanggal Pemakaian</label>
                            <p class="form-control">{{ $pemakaian->mulai }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="selesai">Selesai Pemakaian</label>
                            <p class="form-control">{{ $pemakaian->selesai ?? '-' }}</p>
                        </div>
                        @if ($pemakaian->barangpakai->alat->kategori == 'pc')
                            <div class="mb-3">
                                <label class="form-label" for="cpu">CPU</label>
                                <p class="form-control">{{ $pemakaian->cpu ?? '-' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="monitor">Monitor</label>
                                <p class="form-control">{{ $pemakaian->monitor ?? '-' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="keyboard">Keyboard</label>
                                <p class="form-control">{{ $pemakaian->keyboard ?? '-' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="mouse">Mouse</label>
                                <p class="form-control">{{ $pemakaian->mouse ?? '-' }}</p>
                            </div>
                        @endif
                        <div class="mb-3">
                            <label class="form-label" for="keterangan">keterangan</label>
                            <p class="form-control">{{ $pemakaian->keterangan ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Informasi Alat dan Kegiatan</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex align-items-center align-items-sm-center justify-content-center gap-4">
                                @if ($pemakaian->barangpakai->foto)
                                    <img src="{{ asset('storage') . '/' . $pemakaian->barangpakai->foto }}"
                                        alt="pemakaian-avatar" class="d-block rounded" height="200" width="200"
                                        id="uploadedAvatar" />
                                @else
                                    <img src="{{ asset('img') }}/unknown.png" alt="user-avatar" class="d-block rounded"
                                        height="200" width="200" id="uploadedAvatar" />
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kode">Kode barangpakai</label>
                            <p class="form-control">{{ $pemakaian->barangpakai->kode }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">nama barangpakai</label>
                            <p class="form-control">{{ $pemakaian->barangpakai->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kode">kode kegiatan</label>
                            <p class="form-control">{{ $pemakaian->kegiatan->kode }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jenis">jenis kegiatan</label>
                            <p class="form-control">{{ $pemakaian->kegiatan->jenis }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">Oleh</label>
                            <p class="form-control">{{ $pemakaian->kegiatan->user->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">nama kegiatan</label>
                            <p class="form-control">{{ $pemakaian->kegiatan->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="keterangan">Deskripsi kegiatan</label>
                            <p class="form-control">{{ $pemakaian->kegiatan->deskripsi }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tanggal">Tanggal Mulai</label>
                            <p class="form-control">{{ $pemakaian->kegiatan->mulai }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-start">
                    <a href="/pemakaian/{{ $pemakaian->id }}/edit" class="btn btn-outline-warning me-3">Edit</a>
                    <form action="/pemakaian/{{ $pemakaian->id }}" method="post">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3 col-12 mb-0">
                    <div class="alert alert-primary">
                        <h6 class="alert-heading fw-bold mb-1">Kelola Data pemakaian</h6>
                        <p class="mb-0">Ketika Form Tambah Data pemakaian dihapus atau diubah,<br />
                            Maka Secara Otomatis Kode QR akan dihapus atau terubah, <br />
                            Dan Langsung diseusaikan dengan kode qr yang tertera
                        </p>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>

    </div>
@endsection
