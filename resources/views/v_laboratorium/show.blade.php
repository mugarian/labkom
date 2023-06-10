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
                                            <button type="submit" class="btn btn-outline-danger"
                                                onclick="if (confirm('Hapus Data')) return true; return false">
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
                        @if ($kegiatan)
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="my-3">Status Laboratorium</h5>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="merk">Status Kegiatan</label>
                                <p class="form-control">{{ $kegiatan->status }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="merk">Nama Kegiatan</label>
                                <p class="form-control">{{ $kegiatan->nama }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="merk">Oleh</label>
                                <p class="form-control">{{ $kegiatan->user->nama }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="merk">Tanggal Mulai</label>
                                <p class="form-control">{{ $kegiatan->mulai }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-xl">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Tracking Barang Pakai (Alat)</h5>
                    </div>
                    <div class="card-body pb-2">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-bordered" id="myTable">
                                <thead>
                                    <tr class="text-center">
                                        <th>Foto</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Lokasi</th>
                                        <th>Harga</th>
                                        {{-- <th style="width: 0">Aksi</th> --}}
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr class="text-center">
                                        <th>Foto</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Lokasi</th>
                                        <th>Harga</th>
                                        {{-- <th style="width: 0">Aksi</th> --}}
                                    </tr>
                                </tfoot>
                                <tbody class="text-center">
                                    @foreach ($barangpakais as $baprak)
                                        <tr>
                                            <td style="width:10%">
                                                @if ($baprak->foto)
                                                    <img src="{{ asset('storage') . '/' . $baprak->foto }}" alt="bp-avatar"
                                                        class="d-block rounded img-preview" height="100" width="100"
                                                        id="uploadedAvatar" />
                                                @else
                                                    <img src="{{ asset('img') }}/unknown.png" alt="user-avatar"
                                                        class="d-block rounded img-preview" height="100" width="100"
                                                        id="uploadedAvatar" />
                                                @endif
                                            </td>
                                            <td>{{ $baprak->kode }}</td>
                                            <td class="text-wrap">{{ $baprak->nama }}</td>
                                            <td class="text-wrap">{{ $baprak->laboratorium->nama }}</td>
                                            <td class="text-wrap">Rp. {{ number_format($baprak->harga, 2, ',', '.') }}
                                            </td>
                                            {{-- <td>
                                                <div class="d-flex justify-content-center">
                                                    <a class="btn btn-outline-success p-1"
                                                        href="/barangpakai/{{ $baprak->id }}"><i
                                                            class="bx bx-info-circle"></i></a>
                                                    @if (auth()->user()->role == 'admin' || $baprak->laboratorium->user->id == auth()->user()->id)
                                                        <a class="btn btn-outline-warning p-1"
                                                            href="/barangpakai/{{ $baprak->id }}/edit"><i
                                                                class="bx bx-edit-alt"></i></a>
                                                        <form action="/barangpakai/{{ $baprak->id }}" method="post">
                                                            @method('delete')
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-danger p-1">
                                                                <i class="bx bx-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td> --}}
                                        </tr>
                                        {{-- @empty
                                            <tr>
                                                <td colspan="100%">
                                                    <div class="my-5">
                                                        <h3 class="text-muted">
                                                            Tidak Ada Data Barang Pakai (Alat)
                                                        </h3>
                                                    </div>
                                                </td>
                                            </tr> --}}
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- <div class="d-flex align-items-center justify-content-end mt-4 mb-0">
                            {{ $barangpakai->links() }}
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Tracking Bahan Jurusan</h5>
                    </div>
                    <div class="card-body pb-2">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-bordered" id="myTable2">
                                <thead>
                                    <tr class="text-center">
                                        <th>Foto</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Lokasi</th>
                                        <th>Harga</th>
                                        {{-- <th style="width: 0">Aksi</th> --}}
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr class="text-center">
                                        <th>Foto</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Lokasi</th>
                                        <th>Harga</th>
                                        {{-- <th style="width: 0">Aksi</th> --}}
                                    </tr>
                                </tfoot>
                                <tbody class="text-center">
                                    @foreach ($bahanpraktikums as $baprak)
                                        <tr>
                                            <td style="width:10%">
                                                @if ($baprak->foto)
                                                    <img src="{{ asset('storage') . '/' . $baprak->foto }}"
                                                        alt="bp-avatar" class="d-block rounded img-preview"
                                                        height="100" width="100" id="uploadedAvatar" />
                                                @else
                                                    <img src="{{ asset('img') }}/unknown.png" alt="user-avatar"
                                                        class="d-block rounded img-preview" height="100" width="100"
                                                        id="uploadedAvatar" />
                                                @endif
                                            </td>
                                            <td>{{ $baprak->kode }}</td>
                                            <td class="text-wrap">{{ $baprak->nama }}</td>
                                            <td class="text-wrap">{{ $baprak->laboratorium->nama }}</td>
                                            <td class="text-wrap">Rp. {{ number_format($baprak->harga, 2, ',', '.') }}
                                            </td>
                                            {{-- <td>
                                                <div class="d-flex justify-content-center">
                                                    <a class="btn btn-outline-success p-1"
                                                        href="/barangpakai/{{ $baprak->id }}"><i
                                                            class="bx bx-info-circle"></i></a>
                                                    @if (auth()->user()->role == 'admin' || $baprak->laboratorium->user->id == auth()->user()->id)
                                                        <a class="btn btn-outline-warning p-1"
                                                            href="/barangpakai/{{ $baprak->id }}/edit"><i
                                                                class="bx bx-edit-alt"></i></a>
                                                        <form action="/barangpakai/{{ $baprak->id }}" method="post">
                                                            @method('delete')
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-danger p-1">
                                                                <i class="bx bx-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td> --}}
                                        </tr>
                                        {{-- @empty
                                            <tr>
                                                <td colspan="100%">
                                                    <div class="my-5">
                                                        <h3 class="text-muted">
                                                            Tidak Ada Data Barang Pakai (Alat)
                                                        </h3>
                                                    </div>
                                                </td>
                                            </tr> --}}
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- <div class="d-flex align-items-center justify-content-end mt-4 mb-0">
                            {{ $barangpakai->links() }}
                        </div> --}}
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
