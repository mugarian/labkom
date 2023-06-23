@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Home /</a>
                Inventori /
                <a href="/alat" class="text-secondary">Alat /</a>
                <a href="/alat/{{ $barangpakai->alat->id }}" class="text-secondary">{{ $barangpakai->alat->nama }} /</a>
            </span>
            <span class="text-primary">
                {{ $barangpakai->nama }}
            </span>
        </h5>
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session()->has('fail'))
            <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                {{ session('fail') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Barang Pakai</h5>
                        <small class="text-muted float-end">
                            <a href="/alat/{{ $barangpakai->alat_id }}">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 d-flex justify-content-center">
                            <div class="mx-3">
                                <div class="d-flex align-items-center align-items-sm-center justify-content-center gap-4">
                                    @if ($barangpakai->foto)
                                        <img src="{{ asset('storage') . '/' . $barangpakai->foto }}"
                                            alt="barangpakai-avatar" class="d-block rounded" height="200" width="200"
                                            id="uploadedAvatar" />
                                    @else
                                        <img src="{{ asset('img') }}/unknown.png" alt="user-avatar" class="d-block rounded"
                                            height="200" width="200" id="uploadedAvatar" />
                                    @endif
                                </div>
                            </div>
                            <div class="mx-3">
                                <div class="d-flex align-items-center align-items-sm-center justify-content-center gap-4">
                                    {{ $qrcode }}
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kode">Kode Barang</label>
                            <p class="form-control">{{ $barangpakai->kode }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama Barang</label>
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
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal{{ $barangpakai->id }}">
                                        Delete
                                    </button>
                                @endif
                                @if (auth()->user()->role != 'admin')
                                    <a href="/pemakaian/{{ $barangpakai->id }}/pakai"
                                        class="btn btn-outline-primary mx-1">Pakai</a>
                                    <a href="/peminjamanalat/{{ $barangpakai->id }}/pinjam"
                                        class="btn btn-outline-warning mx-1">Pinjam</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="exampleModal{{ $barangpakai->id }}" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-wrap">
                            Apakah Anda Yakin Ingin Menghapus Data {{ $barangpakai->nama }}?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                            <form action="/barangpakai/{{ $barangpakai->id }}" method="post">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    Ya
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- PEMAKAIAN --}}
        <div class="row">
            <div class="col-xl">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Tracking Pemakaian</h5>
                    </div>
                    <div class="card-body pb-2">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-bordered" id="myTable">
                                <thead>
                                    <tr class="text-center">
                                        <th>No.</th>
                                        <th>Oleh</th>
                                        <th>Kegiatan</th>
                                        <th class="text-wrap">Tanggal Pemakaian</th>
                                        <th>Kondisi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr class="text-center">
                                        <th>No.</th>
                                        <th>Oleh</th>
                                        <th>Kegiatan</th>
                                        <th class="text-wrap">Tanggal Pemakaian</th>
                                        <th>Kondisi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                                <tbody class="text-center">
                                    @foreach ($pemakaians as $pemakaian)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $pemakaian->user->nama }}</td>
                                            <td class="text-wrap">{{ $pemakaian->kegiatan->nama }}</td>
                                            <td class="text-wrap">
                                                <b>Mulai:</b><br> {{ $pemakaian->mulai }} <br>
                                                <b>Selesai:</b><br> {{ $pemakaian->selesai }}
                                            </td>
                                            <td class="text-wrap">{{ $pemakaian->keterangan ?? '-' }}</td>
                                            <td class="text-wrap">{{ $pemakaian->status }}</td>
                                            <td>
                                                <a class="btn btn-outline-success p-1" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-title="Lihat"
                                                    href="/pemakaian/{{ $pemakaian->id }}">
                                                    <i class="bx bx-info-circle"></i>
                                                </a>
                                            </td>
                                        </tr>
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
        {{-- PEMINJAMAN --}}
        <div class="row my-4">
            <div class="col-xl">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Tracking Peminjaman Alat</h5>
                    </div>
                    <div class="card-body pb-2">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-bordered" id="myTable2">
                                <thead>
                                    <tr class="text-center">
                                        <th>No.</th>
                                        <th>Oleh</th>
                                        <th class="text-wrap">Tanggal Peminjaman</th>
                                        <th>Kondisi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr class="text-center">
                                        <th>No.</th>
                                        <th>Oleh</th>
                                        <th class="text-wrap">Tanggal Peminjaman</th>
                                        <th>Kondisi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                                <tbody class="text-center">
                                    @foreach ($peminjamans as $peminjaman)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $peminjaman->user->nama }}</td>
                                            <td class="text-wrap">
                                                <b>Mulai:</b><br> {{ $peminjaman->tgl_pinjam }} <br>
                                                <b>Selesai:</b><br> {{ $peminjaman->tgl_kembali }}
                                            </td>
                                            <td class="text-wrap">{{ $peminjaman->kondisi ?? '-' }}</td>
                                            <td class="text-wrap">{{ $peminjaman->status }}</td>
                                            <td>
                                                <a class="btn btn-outline-success p-1" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-title="Lihat"
                                                    href="/peminjamanalat/{{ $peminjaman->id }}">
                                                    <i class="bx bx-info-circle"></i>
                                                </a>
                                            </td>
                                        </tr>
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
