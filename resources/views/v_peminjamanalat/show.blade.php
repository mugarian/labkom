@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Beranda /</a>
                Logbook /
                <a href="/peminjamanalat" class="text-secondary">Peminjaman Alat /</a>
            </span>
            <span class="text-primary">
                {{ $peminjamanalat->barangpakai->nama }}
            </span>
        </h5>
        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Peminjaman Alat</h5>
                        <small class="text-muted float-end"><a href="/peminjamanalat">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="alert alert-primary">
                                <h6 class="alert-heading fw-bold mb-1">Status Peminjaman Alat</h6>
                                <p class="mb-0">
                                    peminjamanalat bisa dilakukan ketika status sudah disetujui Kepala Lab
                                </p>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="status">Status</label>
                            <p class="form-control">{{ $peminjamanalat->status }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="keterangan">Keterangan</label>
                            <p class="form-control">
                                {{ $peminjamanalat->keterangan ?? '-' }}
                            </p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="alat_id">Kode Barang Pakai</label>
                            <p class="form-control">
                                {{ $peminjamanalat->barangpakai->kode }}
                            </p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="deskripsi">deskripsi</label>
                            <p class="form-control">
                                {{ $peminjamanalat->deskripsi }}
                            </p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tgl_pinjam">Tanggal peminjaman</label>
                            <p class="form-control">{{ $peminjamanalat->tgl_pinjam }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tgl_pinjam">Rencana Tanggal pengembalian</label>
                            <p class="form-control">{{ $peminjamanalat->rencana_tgl_kembali }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tanggal">Tanggal Pengembalian</label>
                            <p class="form-control">{{ $peminjamanalat->tgl_kembali ?? '-' }}</p>
                        </div>
                        @if ($peminjamanalat->barangpakai->alat->kategori == 'pc')
                            <div class="mb-3">
                                <label class="form-label" for="cpu">CPU</label>
                                <p class="form-control">{{ $peminjamanalat->cpu ?? '-' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="monitor">Monitor</label>
                                <p class="form-control">{{ $peminjamanalat->monitor ?? '-' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="keyboard">Keyboard</label>
                                <p class="form-control">{{ $peminjamanalat->keyboard ?? '-' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="mouse">Mouse</label>
                                <p class="form-control">{{ $peminjamanalat->mouse ?? '-' }}</p>
                            </div>
                        @endif
                        <div class="mb-3">
                            <label class="form-label" for="kondisi">kondisi</label>
                            <p class="form-control">
                                {{ $peminjamanalat->kondisi ?? '-' }}
                            </p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="bukti">Bukti Pengembalian</label>
                            @if ($peminjamanalat->bukti)
                                <img src="{{ asset('storage') . '/' . $peminjamanalat->bukti }}" alt="barangpakai-avatar"
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
                        <h5 class="mb-0">Informasi Barang Pakai</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex align-items-center align-items-sm-center justify-content-center gap-4">
                                @if ($peminjamanalat->barangpakai->foto)
                                    <img src="{{ asset('storage') . '/' . $peminjamanalat->barangpakai->foto }}"
                                        alt="peminjamanalat-avatar" class="d-block rounded" height="200" width="200"
                                        id="uploadedAvatar" />
                                @else
                                    <img src="{{ asset('img') }}/unknown.png" alt="user-avatar" class="d-block rounded"
                                        height="200" width="200" id="uploadedAvatar" />
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kode">Kode Barang Pakai</label>
                            <p class="form-control">{{ $peminjamanalat->barangpakai->kode }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama Alat</label>
                            <p class="form-control">{{ $peminjamanalat->barangpakai->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="lokasi">Lokasi Alat</label>
                            <p class="form-control">{{ $peminjamanalat->barangpakai->laboratorium->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="merk">Merk Alat</label>
                            <p class="form-control">{{ $peminjamanalat->barangpakai->alat->merk }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="spesifikasi">Spesifikasi Alat</label>
                            <p class="form-control">{{ $peminjamanalat->barangpakai->alat->spesifikasi }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-start">
                    <a href="/peminjamanalat/{{ $peminjamanalat->id }}/edit" class="btn btn-outline-warning me-3">Edit</a>
                    <form action="/peminjamanalat/{{ $peminjamanalat->id }}" method="post">
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
                            <h6 class="alert-heading fw-bold mb-1">Kelola Data peminjamanalat</h6>
                            <p class="mb-0">Ketika Form Tambah Data peminjamanalat dihapus atau diubah,<br />
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
