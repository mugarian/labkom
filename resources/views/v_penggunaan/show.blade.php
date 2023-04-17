@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">
                <a href="/penggunaan" class="text-secondary">Data Penggunaan</a> /
            </span> {{ $penggunaan->baranghabis->nama }}</h4>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">penggunaan</h5>
                        <small class="text-muted float-end"><a href="/penggunaan">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="alert alert-primary">
                                <h6 class="alert-heading fw-bold mb-1">Status Penggunaan</h6>
                                <p class="mb-0">
                                    Penggunaan bisa dilakukan ketika status sudah disetujui Kepala Lab
                                </p>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="status">Status</label>
                            <p class="form-control">{{ $penggunaan->status }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="keterangan">keterangan</label>
                            <p class="form-control">
                                {{ $penggunaan->keterangan ?? '-' }}
                            </p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tanggal">Tanggal penggunaan</label>
                            <p class="form-control">{{ $penggunaan->tanggal }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jumlah">Jumlah Barang</label>
                            <p class="form-control">{{ $penggunaan->jumlah }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Barang</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex align-items-center align-items-sm-center justify-content-center gap-4">
                                @if ($penggunaan->baranghabis->foto)
                                    <img src="{{ asset('storage') . '/' . $penggunaan->baranghabis->foto }}"
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
                            <p class="form-control">{{ $penggunaan->baranghabis->kode }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">nama Barang</label>
                            <p class="form-control">{{ $penggunaan->baranghabis->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="keterangan">keterangan Barang</label>
                            <p class="form-control">{{ $penggunaan->baranghabis->keterangan }}</p>
                        </div>
                        <div class="mt-5 mb-3">
                            <h5 class="mb-0">Kegiatan</h5>
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
