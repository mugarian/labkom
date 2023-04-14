@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">
                <a href="/laboratorium/{{ $barangpakai->laboratorium_id }}"
                    class="text-secondary">{{ $barangpakai->laboratorium->nama }}</a> /
            </span> {{ $barangpakai->nama }}
        </h4>
        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Barang Pakai</h5>
                        <small class="text-muted float-end">
                            <a href="/laboratorium/{{ $barangpakai->laboratorium_id }}">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="kode">Kode</label>
                            <p class="form-control">{{ $barangpakai->kode }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama</label>
                            <p class="form-control">{{ $barangpakai->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="merk">Alat</label>
                            <p class="form-control">{{ $barangpakai->alat->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="deskripsi">Deskripsi</label>
                            <p class="form-control">{{ $barangpakai->deskripsi }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="keterangan">Keterangan</label>
                            <p class="form-control">{{ $barangpakai->keterangan }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Foto Barang</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex align-items-center align-items-sm-center justify-content-center gap-4">
                                @if ($barangpakai->foto)
                                    <img src="{{ asset('storage') . '/' . $barangpakai->foto }}" alt="barangpakai-avatar"
                                        class="d-block rounded" height="200" width="200" id="uploadedAvatar" />
                                @else
                                    <img src="{{ asset('img') }}/unknown.png" alt="user-avatar" class="d-block rounded"
                                        height="200" width="200" id="uploadedAvatar" />
                                @endif
                            </div>
                        </div>
                        <div class="mt-5 mb-3">
                            <h5 class="mb-3">Kode Barang</h5>
                            <div class="d-flex align-items-center align-items-sm-center justify-content-center gap-4">
                                {{ $qrcode }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-start">
                    @if (auth()->user()->id == $barangpakai->laboratorium->user->id || auth()->user()->role == 'admin')
                        <a href="/barangpakai/{{ $barangpakai->id }}/edit" class="btn btn-outline-warning me-3">Edit</a>
                        <form action="/barangpakai/{{ $barangpakai->id }}" method="post">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-outline-danger">
                                Delete
                            </button>
                        </form>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3 col-12 mb-0">
                    <div class="alert alert-primary">
                        <h6 class="alert-heading fw-bold mb-1">Kelola Data Barang Pakai</h6>
                        <p class="mb-0">Ketika Form Tambah Data barang pakai dihapus atau diubah,<br />
                            Maka Secara Otomatis Kode QR akan dihapus atau terubah, <br />
                            Dan Langsung diseusaikan dengan kode qr yang tertera
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
