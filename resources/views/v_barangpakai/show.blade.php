@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">
                <a href="/barangpakai" class="text-secondary">Data Barang Pakai</a> /
            </span> {{ $barangpakai->nama }}
        </h4>
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Barang Pakai</h5>
                        <small class="text-muted float-end">
                            <a href="/barangpakai">
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
                            <label class="form-label" for="harga">harga</label>
                            <p class="form-control">Rp. {{ number_format($barangpakai->harga, 2, ',', '.') }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="merk">Alat</label>
                            <p class="form-control">{{ $barangpakai->alat->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="merk">Laboratorium</label>
                            <p class="form-control">{{ $barangpakai->laboratorium->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-start">
                                @if (auth()->user()->role == 'admin')
                                    <a href="/barangpakai/{{ $barangpakai->id }}/edit"
                                        class="btn btn-outline-warning mx-1">Edit</a>
                                    <form action="/barangpakai/{{ $barangpakai->id }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger mx-1"
                                            onclick="if (confirm('Hapus Data')) return true; return false">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                                @if (auth()->user()->role != 'admin')
                                    <a href="/peminjamanalat/{{ $barangpakai->id }}/pinjam"
                                        class="btn btn-outline-primary mx-1">Pinjam</a>
                                @endif
                            </div>
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

        {{-- <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-start">
                    @if (auth()->user()->id == $barangpakai->laboratorium->user->id || auth()->user()->role == 'admin')
                        <a href="/barangpakai/{{ $barangpakai->id }}/edit" class="btn btn-outline-warning mx-1">Edit</a>
                        <form action="/barangpakai/{{ $barangpakai->id }}" method="post">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-outline-danger mx-1">
                                Delete
                            </button>
                        </form>
                    @endif
                    @if (auth()->user()->role != 'admin')
                        <a href="/pemakaian/{{ $barangpakai->id }}/pakai" class="btn btn-outline-primary mx-1">Pakai</a>
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
        </div> --}}
    </div>
@endsection
