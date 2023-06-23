@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Home /</a>
                Invetori /
                <a href="/bahanjurusan" class="text-secondary">Bahan Jurusan /</a>
            </span>
            <span class="text-primary">
                {{ $bahanjurusan->bahanpraktikum->nama }}
            </span>
        </h5>
        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Bahan jurusan</h5>
                        <small class="text-muted float-end"><a href="/bahanjurusan">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="alert alert-primary">
                                <h6 class="alert-heading fw-bold mb-1">Pemberitahuan</h6>
                                <p class="mb-0">Bahan jurusan mempunyai relasi ke bahan praktikum karena jika bahan
                                    praktikum habis atau berkurang, maka data yang berkurang berpindah ke bahan jurusan
                                    menjadi bertambah
                                </p>
                            </div>
                        </div>
                        <div class="mb-3">

                            <div class="d-flex align-items-center align-items-sm-center justify-content-center gap-4">
                                @if ($bahanjurusan->foto)
                                    <img src="{{ asset('storage') . '/' . $bahanjurusan->foto }}" alt="bahanjurusan-avatar"
                                        class="d-block rounded" height="200" width="200" id="uploadedAvatar" />
                                @else
                                    <img src="{{ asset('img') }}/unknown.png" alt="user-avatar" class="d-block rounded"
                                        height="200" width="200" id="uploadedAvatar" />
                                @endif
                                {{ $qrcode }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama Bahan Jurusan</label>
                            <p class="form-control">{{ $bahanjurusan->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kode">kode</label>
                            <p class="form-control">{{ $bahanjurusan->kode }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="stok">stok</label>
                            <p class="form-control">{{ $bahanjurusan->stok }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="stok">Laboratorium</label>
                            <p class="form-control">{{ $bahanjurusan->laboratorium->nama }}</p>
                        </div>
                        <div class="mb-3">
                            @if (auth()->user()->role == 'admin')
                                <div class="d-flex justify-content-start">
                                    <a href="/bahanjurusan/{{ $bahanjurusan->id }}/edit"
                                        class="btn btn-outline-warning me-3">Edit</a>
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal{{ $bahanjurusan->id }}">
                                        Delete
                                    </button>
                                </div>
                            @endif
                            @if (auth()->user()->role != 'admin')
                                <a href="/peminjamanbahan/{{ $bahanjurusan->id }}/pinjam"
                                    class="btn btn-outline-primary mx-1">Pinjam</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="exampleModal{{ $bahanjurusan->id }}" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-wrap">
                            Apakah Anda Yakin Ingin Menghapus Data {{ $bahanjurusan->nama }}?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                            <form action="/bahanjurusan/{{ $bahanjurusan->id }}" method="post">
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

        <div class="row">
            <div class="col-xl">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Tracking Peminjaman Bahan</h5>
                    </div>
                    <div class="card-body pb-2">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-bordered" id="myTable">
                                <thead>
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Oleh</th>
                                        <th>Deskripsi</th>
                                        <th>Kondisi</th>
                                        <th>Jenis</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Oleh</th>
                                        <th>Deskripsi</th>
                                        <th>Kondisi</th>
                                        <th>Jenis</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                                <tbody class="text-center">
                                    @foreach ($peminjamans as $peminjaman)
                                        <tr>
                                            <td style="width:10%">{{ $loop->iteration }}</td>
                                            <td>{{ $peminjaman->user->nama }}</td>
                                            <td class="text-wrap">{{ $peminjaman->deskripsi }}</td>
                                            <td class="text-wrap">{{ $peminjaman->kondisi }}</td>
                                            <td class="text-wrap">{{ $peminjaman->jenis }} jurusan</td>
                                            <td class="text-wrap">{{ $peminjaman->status }}</td>
                                            <td>
                                                <a class="btn btn-outline-success p-1" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-title="Lihat"
                                                    href="/peminjamanbahan/{{ $peminjaman->id }}">
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
                        <a href="/bahanjurusan/{{ $bahanjurusan->id }}/edit" class="btn btn-outline-warning me-3">Edit</a>
                        <form action="/bahanjurusan/{{ $bahanjurusan->id }}" method="post">
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
                        <h6 class="alert-heading fw-bold mb-1">Kelola Data bahanjurusan</h6>
                        <p class="mb-0">Ketika Form Tambah Data bahanjurusan dihapus atau diubah,<br />
                            Maka Secara Otomatis Kode QR akan dihapus atau terubah, <br />
                            Dan Langsung diseusaikan dengan kode qr yang tertera
                        </p>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@endsection
