@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Beranda /</a>
                Logbook /
                <a href="/peminjamanbahan" class="text-secondary">Peminjaman Bahan Jurusan /</a>
            </span>
            <span class="text-primary">
                {{ $peminjamanbahan->bahanjurusan->bahanpraktikum->nama }}
            </span>
        </h5>
        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Peminjaman bahan</h5>
                        <small class="text-muted float-end"><a href="/peminjamanbahan">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="alert alert-primary">
                                <h6 class="alert-heading fw-bold mb-1">Status Peminjaman bahan</h6>
                                <p class="mb-0">
                                    peminjamanbahan bisa dilakukan ketika status sudah disetujui Kepala Lab
                                </p>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="status">Status</label>
                            <p class="form-control">{{ $peminjamanbahan->status }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="keterangan">Keterangan</label>
                            <p class="form-control">
                                {{ $peminjamanbahan->keterangan ?? '-' }}
                            </p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="bahan_id">Kode Bahan jurusan</label>
                            <p class="form-control">
                                {{ $peminjamanbahan->bahanjurusan->kode }}
                            </p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="deskripsi">deskripsi</label>
                            <p class="form-control">
                                {{ $peminjamanbahan->deskripsi }}
                            </p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jumlah">jumlah</label>
                            <p class="form-control">
                                {{ $peminjamanbahan->jumlah }}
                            </p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tgl_pinjam">Tanggal peminjaman</label>
                            <p class="form-control">{{ $peminjamanbahan->tgl_pinjam }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tanggal">Tanggal Pengembalian</label>
                            <p class="form-control">{{ $peminjamanbahan->tgl_kembali ?? '-' }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kondisi">kondisi</label>
                            <p class="form-control">
                                {{ $peminjamanbahan->kondisi ?? '-' }}
                            </p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="bukti">Bukti Pengembalian</label>
                            @if ($peminjamanbahan->bukti)
                                <img src="{{ asset('storage') . '/' . $peminjamanbahan->bukti }}" alt="barangpakai-avatar"
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
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Informasi Bahan Jurusan</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex align-items-center align-items-sm-center justify-content-center gap-4">
                                @if ($peminjamanbahan->bahanjurusan->bahanpraktikum->foto)
                                    <img src="{{ asset('storage') . '/' . $peminjamanbahan->bahanjurusan->bahanpraktikum->foto }}"
                                        alt="peminjamanbahan-avatar" class="d-block rounded" height="200" width="200"
                                        id="uploadedAvatar" />
                                @else
                                    <img src="{{ asset('img') }}/unknown.png" alt="user-avatar" class="d-block rounded"
                                        height="200" width="200" id="uploadedAvatar" />
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kode">Kode Bahan Jurusan</label>
                            <p class="form-control">{{ $peminjamanbahan->bahanjurusan->kode }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama bahan</label>
                            <p class="form-control">{{ $peminjamanbahan->bahanjurusan->bahanpraktikum->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="merk">Merk bahan</label>
                            <p class="form-control">{{ $peminjamanbahan->bahanjurusan->bahanpraktikum->merk }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="spesifikasi">Spesifikasi bahan</label>
                            <p class="form-control">{{ $peminjamanbahan->bahanjurusan->bahanpraktikum->spesifikasi }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-start">
                    <a href="/peminjamanbahan/{{ $peminjamanbahan->id }}/edit" class="btn btn-outline-warning me-3">Edit</a>
                    <form action="/peminjamanbahan/{{ $peminjamanbahan->id }}" method="post">
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
                            <h6 class="alert-heading fw-bold mb-1">Kelola Data peminjamanbahan</h6>
                            <p class="mb-0">Ketika Form Tambah Data peminjamanbahan dihapus atau diubah,<br />
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
