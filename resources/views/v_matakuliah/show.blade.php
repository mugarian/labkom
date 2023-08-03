@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Beranda /</a>
                <a href="/matakuliah" class="text-secondary">Mata Kuliah /</a>
            </span>
            <span class="text-primary">
                {{ $matkul->nama }}
            </span>
        </h5>

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
                        <h5 class="mb-0">Detail Mata Kuliah</h5>
                        <small class="text-muted float-end"><a href="/matakuliah">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama Mata Kuliah</label>
                            <p class="form-control">{{ $matkul->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="matakuliah">Dosen</label>
                            <p class="form-control">{{ $matkul->dosen->user->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="merk">jurusan</label>
                            <p class="form-control">{{ $matkul->jurusan }}</p>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-start">
                                @if (auth()->user()->role == 'admin')
                                    <a href="/matakuliah/{{ $matkul->id }}/edit"
                                        class="btn btn-outline-warning me-3">Edit</a>
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal{{ $matkul->id }}">
                                        Delete
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="exampleModal{{ $matkul->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-wrap">
                            Apakah Anda Yakin Ingin Menghapus Data {{ $matkul->nama }}?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                            <form action="/matakuliah/{{ $matkul->id }}" method="post">
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

        {{-- <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-start">
                    @if (auth()->user()->id == $matkul->user->id || auth()->user()->role == 'admin')
                        <a href="/kelas/{{ $matkul->id }}/edit"
                            class="btn btn-outline-warning me-3">Edit</a>
                        @if (auth()->user()->role == 'admin')
                            <form action="/kelas/{{ $matkul->id }}" method="post">
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
                        <h6 class="alert-heading fw-bold mb-1">Kelola Data kelas</h6>
                        <p class="mb-0">Ketika Form Tambah Data kelas dihapus atau diubah,<br />
                            Maka Secara Otomatis Kode QR akan dihapus atau terubah, <br />
                            Dan Langsung diseusaikan dengan kode qr yang tertera
                        </p>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@endsection
