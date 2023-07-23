@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Beranda /</a>
                Invetori /
                <a href="/bahanpraktikum" class="text-secondary">Bahan Praktikum /</a>
            </span>
            <span class="text-primary">
                {{ $bahanpraktikum->nama }}
            </span>
        </h5>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Bahan Praktikum</h5>
                        <small class="text-muted float-end"><a href="/bahanpraktikum">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 d-flex justify-content-center">
                            <div>
                                <div
                                    class="d-flex align-items-center align-items-sm-center justify-content-center gap-4 mx-4">
                                    @if ($bahanpraktikum->foto)
                                        <img src="{{ asset('storage') . '/' . $bahanpraktikum->foto }}"
                                            alt="bahanpraktikum-avatar" class="d-block rounded" height="200"
                                            width="200" id="uploadedAvatar" />
                                    @else
                                        <img src="{{ asset('img') }}/unknown.png" alt="user-avatar" class="d-block rounded"
                                            height="200" width="200" id="uploadedAvatar" />
                                    @endif
                                </div>
                            </div>
                            <div>
                                <div
                                    class="d-flex align-items-center align-items-sm-center justify-content-center gap-4 mx-4">
                                    {{ $qrcode }}
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="status">Status Bahan Praktikum</label>
                            <p class="form-control">{{ $bahanpraktikum->status }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jenis">Jenis Bahan Praktikum</label>
                            <p class="form-control">Bahan {{ $bahanpraktikum->jenis }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kode">kode Barang</label>
                            <p class="form-control">{{ $bahanpraktikum->kode }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">Lokasi</label>
                            <p class="form-control">{{ $bahanpraktikum->laboratorium->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama barang</label>
                            <p class="form-control">{{ $bahanpraktikum->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="merk">Merk</label>
                            <p class="form-control">{{ $bahanpraktikum->merk }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="spesifikasi">Spesifikasi</label>
                            <p class="form-control">{{ $bahanpraktikum->spesifikasi }}</p>
                        </div>
                        @if (!auth()->user()->role == 'mahasiswa')
                            <div class="mb-3">
                                <label class="form-label" for="harga">Harga</label>
                                <p class="form-control">Rp. {{ number_format($bahanpraktikum->harga, 2, ',', '.') }}</p>
                            </div>
                        @endif
                        <div class="mb-3">
                            <label class="form-label" for="stok">stok</label>
                            <p class="form-control">{{ $bahanpraktikum->stok }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tahun">tahun</label>
                            <p class="form-control">{{ $bahanpraktikum->tahun }}</p>
                        </div>
                        <div class="mb-3">
                            @if (auth()->user()->role == 'admin')
                                <div class="d-flex justify-content-start">
                                    <a href="/bahanpraktikum/{{ $bahanpraktikum->id }}/edit"
                                        class="btn btn-outline-warning me-3">Edit</a>
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal{{ $bahanpraktikum->id }}">
                                        Delete
                                    </button>
                                </div>
                            @endif
                            @if (auth()->user()->role != 'admin')
                                <a href="/penggunaan/{{ $bahanpraktikum->id }}/guna"
                                    class="btn btn-outline-primary mx-1">Gunakan</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="exampleModal{{ $bahanpraktikum->id }}" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-wrap">
                            Apakah Anda Yakin Ingin Menghapus Data {{ $bahanpraktikum->nama }}?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                            <form action="/bahanpraktikum/{{ $bahanpraktikum->id }}" method="post">
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

            {{-- <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Foto Bahan Praktikum</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex align-items-center align-items-sm-center justify-content-center gap-4">
                                @if ($bahanpraktikum->foto)
                                    <img src="{{ asset('storage') . '/' . $bahanpraktikum->foto }}"
                                        alt="bahanpraktikum-avatar" class="d-block rounded" height="200"
                                        width="200" id="uploadedAvatar" />
                                @else
                                    <img src="{{ asset('img') }}/unknown.png" alt="user-avatar" class="d-block rounded"
                                        height="200" width="200" id="uploadedAvatar" />
                                @endif
                            </div>
                        </div>
                        <div class="mt-5 mb-3">
                            <h5 class="mb-3">Kode Bahan Praktikum</h5>
                            <div class="d-flex align-items-center align-items-sm-center justify-content-center gap-4">
                                {{ $qrcode }}
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>

        <div class="row">
            <div class="col-xl">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Tracking Penggunaan</h5>
                    </div>
                    <div class="card-body pb-2">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-bordered" id="myTable">
                                <thead>
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Oleh</th>
                                        <th>Kegiatan</th>
                                        <th>Jumlah</th>
                                        <th>Keterangan</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Oleh</th>
                                        <th>Kegiatan</th>
                                        <th>Jumlah</th>
                                        <th>Keterangan</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                                <tbody class="text-center">
                                    @foreach ($penggunaans as $penggunaan)
                                        <tr>
                                            <td style="width:10%">{{ $loop->iteration }}</td>
                                            <td>{{ $penggunaan->user->nama }}</td>
                                            <td class="text-wrap">{{ $penggunaan->kegiatan->nama }}</td>
                                            <td class="text-wrap">{{ $penggunaan->jumlah }}</td>
                                            <td class="text-wrap">{{ $penggunaan->keterangan }}</td>
                                            <td class="text-wrap">{{ $penggunaan->tanggal }}</td>
                                            <td>
                                                <a class="btn btn-outline-success p-1" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-title="Lihat"
                                                    href="/penggunaan/{{ $penggunaan->id }}">
                                                    <i class="bx bx-info-circle"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="card mt-4">
            <div class="card-header">
                @if (auth()->user()->role == 'admin')
                    <div class="d-flex justify-content-start">
                        <a href="/bahanpraktikum/{{ $bahanpraktikum->id }}/edit" class="btn btn-outline-warning me-3">Edit</a>
                        <form action="/bahanpraktikum/{{ $bahanpraktikum->id }}" method="post">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-outline-danger">
                                Delete
                            </button>
                        </form>
                    </div>
                @endif
            </div>
            <div class="card-body">
                <div class="mb-3 col-12 mb-0">
                    <div class="alert alert-primary">
                        <h6 class="alert-heading fw-bold mb-1">Kelola Data bahanpraktikum</h6>
                        <p class="mb-0">Ketika Form Tambah Data bahanpraktikum dihapus atau diubah,<br />
                            Maka Secara Otomatis Kode QR akan dihapus atau terubah, <br />
                            Dan Langsung diseusaikan dengan kode qr yang tertera
                        </p>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@endsection
