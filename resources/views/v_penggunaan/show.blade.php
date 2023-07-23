@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Beranda /</a>
                Logbook /
                <a href="/penggunaan" class="text-secondary">Penggunaan Bahan Praktikum/</a>
            </span>
            <span class="text-primary">
                {{ $penggunaan->bahanpraktikum->nama }}
            </span>
        </h5>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Penggunaan Bahan Praktikum</h5>
                        <small class="text-muted float-end"><a href="/penggunaan">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="deskripsi">deskripsi</label>
                            <p class="form-control">
                                {{ $penggunaan->deskripsi ?? '-' }}
                            </p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tanggal">Tanggal penggunaan</label>
                            <p class="form-control">{{ $penggunaan->tanggal }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama Barang</label>
                            <p class="form-control">{{ $penggunaan->bahanpraktikum->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jumlah">Jumlah Barang</label>
                            <p class="form-control">{{ $penggunaan->jumlah }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama Kegiatan</label>
                            <p class="form-control">{{ $penggunaan->kegiatan->nama }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Informasi Bahan dan Kegiatan</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex align-items-center align-items-sm-center justify-content-center gap-4">
                                @if ($penggunaan->bahanpraktikum->foto)
                                    <img src="{{ asset('storage') . '/' . $penggunaan->bahanpraktikum->foto }}"
                                        alt="penggunaan-avatar" class="d-block rounded" height="200" width="200"
                                        id="uploadedAvatar" />
                                @else
                                    <img src="{{ asset('img') }}/unknown.png" alt="user-avatar" class="d-block rounded"
                                        height="200" width="200" id="uploadedAvatar" />
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kode">Kode Barang</label>
                            <p class="form-control">{{ $penggunaan->bahanpraktikum->kode }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama Barang</label>
                            <p class="form-control">{{ $penggunaan->bahanpraktikum->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="stok">stok Barang</label>
                            <p class="form-control">{{ $penggunaan->bahanpraktikum->stok }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kode">kode kegiatan</label>
                            <p class="form-control">{{ $penggunaan->kegiatan->kode }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jenis">jenis kegiatan</label>
                            <p class="form-control">{{ $penggunaan->kegiatan->jenis }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">Oleh</label>
                            <p class="form-control">{{ $penggunaan->kegiatan->user->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">nama kegiatan</label>
                            <p class="form-control">{{ $penggunaan->kegiatan->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="keterangan">Deskripsi kegiatan</label>
                            <p class="form-control">{{ $penggunaan->kegiatan->deskripsi }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tanggal">Tanggal Mulai</label>
                            <p class="form-control">{{ $penggunaan->kegiatan->mulai }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-start">
                    <a href="/penggunaan/{{ $penggunaan->id }}/edit" class="btn btn-outline-warning me-3">Edit</a>
                    <form action="/penggunaan/{{ $penggunaan->id }}" method="post">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">
                            Delete
                        </button>
                    </form>
                </div>
                <div class="card-body">
                    <div class="mb-3 col-12 mb-0">
                        <div class="alert alert-primary">
                            <h6 class="alert-heading fw-bold mb-1">Kelola Data penggunaan</h6>
                            <p class="mb-0">Ketika Form Tambah Data penggunaan dihapus atau diubah,<br />
                                Maka Secara Otomatis Kode QR akan dihapus atau terubah, <br />
                                Dan Langsung diseusaikan dengan kode qr yang tertera
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@endsection
