@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">
                <a href="/laboratorium" class="text-secondary">Data Laboratorium</a> /
            </span> {{ $laboratorium->nama }}
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
                        <h5 class="mb-0">Laboratorium</h5>
                        <small class="text-muted float-end"><a href="/laboratorium">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama</label>
                            <p class="form-control">{{ $laboratorium->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="merk">Kepala Lab</label>
                            <p class="form-control">{{ $laboratorium->user->nama }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="spesifikasi">Deskripsi</label>
                            <p class="form-control">{{ $laboratorium->deskripsi }}</p>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-start">
                                @if (auth()->user()->id == $laboratorium->user->id || auth()->user()->role == 'admin')
                                    <a href="/laboratorium/{{ $laboratorium->id }}/edit"
                                        class="btn btn-outline-warning me-3">Edit</a>
                                    @if (auth()->user()->role == 'admin')
                                        <form action="/laboratorium/{{ $laboratorium->id }}" method="post">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Foto Laboratorium</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex align-items-center align-items-sm-center justify-content-center gap-4">
                                @if ($laboratorium->foto)
                                    <img src="{{ asset('storage') . '/' . $laboratorium->foto }}" alt="laboratorium-avatar"
                                        class="d-block rounded" height="200" width="200" id="uploadedAvatar" />
                                @else
                                    <img src="{{ asset('img') }}/unknown.png" alt="user-avatar" class="d-block rounded"
                                        height="200" width="200" id="uploadedAvatar" />
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- barang pakai & habis --}}
        <div class="row">
            {{-- barang pakai --}}
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Barang Pakai</h5>
                        @if (auth()->user()->id == $laboratorium->user->id || auth()->user()->role == 'admin')
                            <small class="text-muted float-end">
                                <a href="/barangpakai/create/{{ $laboratorium->id }}">
                                    <button class="btn btn-primary">Tambah</button>
                                </a>
                            </small>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th>Nama</th>
                                        <th>Keterangan</th>
                                        <th style="width: 0">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @forelse ($barangpakai as $bp)
                                        <tr>
                                            <td>{{ $bp->nama }}</td>
                                            <td>{{ $bp->keterangan }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a class="btn btn-outline-success p-1"
                                                        href="/barangpakai/{{ $bp->id }}"><i
                                                            class="bx bx-info-circle"></i></a>
                                                    @if (auth()->user()->id == $laboratorium->user->id || auth()->user()->role == 'admin')
                                                        <a class="btn btn-outline-warning p-1"
                                                            href="/barangpakai/{{ $bp->id }}/edit"><i
                                                                class="bx bx-edit-alt"></i></a>
                                                        <form action="/barangpakai/{{ $bp->id }}" method="post">
                                                            @method('delete')
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-danger p-1">
                                                                <i class="bx bx-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="100%">
                                                <div class="my-5">
                                                    <h5 class="text-muted">
                                                        Tidak Ada Data Barang Pakai (Alat)
                                                    </h5>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- barang habis --}}
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Barang Habis</h5>
                        @if (auth()->user()->id == $laboratorium->user->id || auth()->user()->role == 'admin')
                            <small class="text-muted float-end">
                                <a href="/baranghabis/create/{{ $laboratorium->id }}">
                                    <button class="btn btn-primary">Tambah</button>
                                </a>
                            </small>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th>Nama</th>
                                        <th>Keterangan</th>
                                        <th style="width: 0">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @forelse ($baranghabis as $bh)
                                        <tr>
                                            <td class="text-wrap">{{ $bh->nama }}</td>
                                            <td class="text-wrap">{{ $bh->keterangan }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a class="btn btn-outline-success p-1"
                                                        href="/baranghabis/{{ $bh->id }}"><i
                                                            class="bx bx-info-circle"></i></a>
                                                    @if (auth()->user()->id == $laboratorium->user->id || auth()->user()->role == 'admin')
                                                        <a class="btn btn-outline-warning p-1"
                                                            href="/baranghabis/{{ $bh->id }}/edit"><i
                                                                class="bx bx-edit-alt"></i></a>
                                                        <form action="/baranghabis/{{ $bh->id }}" method="post">
                                                            @method('delete')
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-danger p-1">
                                                                <i class="bx bx-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="100%">
                                                <div class="my-5">
                                                    <h5 class="text-muted">
                                                        Tidak Ada Data Barang Habis (Bahan)
                                                    </h5>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-start">
                    @if (auth()->user()->id == $laboratorium->user->id || auth()->user()->role == 'admin')
                        <a href="/laboratorium/{{ $laboratorium->id }}/edit"
                            class="btn btn-outline-warning me-3">Edit</a>
                        @if (auth()->user()->role == 'admin')
                            <form action="/laboratorium/{{ $laboratorium->id }}" method="post">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-outline-danger">
                                    Delete
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3 col-12 mb-0">
                    <div class="alert alert-primary">
                        <h6 class="alert-heading fw-bold mb-1">Kelola Data laboratorium</h6>
                        <p class="mb-0">Ketika Form Tambah Data laboratorium dihapus atau diubah,<br />
                            Maka Secara Otomatis Kode QR akan dihapus atau terubah, <br />
                            Dan Langsung diseusaikan dengan kode qr yang tertera
                        </p>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@endsection
