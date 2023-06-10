@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="/alat" class="text-secondary">Data Alat</a>
                /</span> {{ $alat->nama }}
        </h4>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Alat</h5>
                        <small class="text-muted float-end"><a href="/alat">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="kategori">Kategori</label>
                            <p class="form-control">{{ $alat->kategori }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="laboratorium">laboratorium</label>
                            <p class="form-control">{{ $alat->laboratorium->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kode">kode</label>
                            <p class="form-control">{{ $alat->kode }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama</label>
                            <p class="form-control">{{ $alat->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="merk">Merk</label>
                            <p class="form-control">{{ $alat->merk }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="spesifikasi">Spesifikasi</label>
                            <p class="form-control">{{ $alat->spesifikasi }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="harga">Harga</label>
                            <p class="form-control">{{ $alat->harga }}</p>
                        </div>
                        <div class="mb-3">
                            @if (auth()->user()->role == 'admin')
                                <div class="d-flex justify-content-start">
                                    <a href="/alat/{{ $alat->id }}/edit" class="btn btn-outline-warning me-3">Edit</a>
                                    <form action="/alat/{{ $alat->id }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger"
                                            onclick="if (confirm('Hapus Data')) return true; return false">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            @endif
                            @if (auth()->user()->role != 'admin')
                                <a href="/pemakaian/{{ $alat->id }}/pakai"
                                    class="btn btn-outline-primary mx-1">Pakai</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Foto Alat</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex align-items-center align-items-sm-center justify-content-center gap-4">
                                @if ($alat->foto)
                                    <img src="{{ asset('storage') . '/' . $alat->foto }}" alt="alat-avatar"
                                        class="d-block rounded" height="200" width="200" id="uploadedAvatar" />
                                @else
                                    <img src="{{ asset('img') }}/unknown.png" alt="user-avatar" class="d-block rounded"
                                        height="200" width="200" id="uploadedAvatar" />
                                @endif
                            </div>
                        </div>
                        <div class="mt-5 mb-3">
                            <h5 class="mb-3">Kode QR Alat</h5>
                            <div class="d-flex align-items-center align-items-sm-center justify-content-center gap-4">
                                {{ $qrcode }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
