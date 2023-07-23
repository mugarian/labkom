@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Beranda /</a>
                Akun /
                <a href="/mahasiswa" class="text-secondary">Mahasiswa /</a>
            </span>
            <span class="text-primary">
                {{ $mahasiswa->user->nama }}
            </span>
        </h5>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Akun Mahasiswa</h5>
                        <small class="text-muted float-end"><a href="/mahasiswa">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex align-items-center align-items-sm-center justify-content-center gap-4">
                                @if ($mahasiswa->user->foto)
                                    <img src="{{ asset('storage') . '/' . $mahasiswa->user->foto }}" alt="mahasiswa-avatar"
                                        class="d-block rounded" height="200" width="200" id="uploadedAvatar" />
                                @else
                                    <img src="{{ asset('img') }}/unknown.png" alt="user-avatar" class="d-block rounded"
                                        height="200" width="200" id="uploadedAvatar" />
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama Mahasiswa</label>
                            <p class="form-control">{{ $mahasiswa->user->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nomor_induk">Nomor Induk</label>
                            <p class="form-control">{{ $mahasiswa->user->nomor_induk }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="angkatan">angkatan</label>
                            <p class="form-control">{{ $mahasiswa->angkatan }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kelas">kelas</label>
                            <p class="form-control">{{ $mahasiswa->kelas->nama . ' (' . $mahasiswa->kelas->angkatan . ')' }}
                            </p>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="Email">email</label>
                            <p class="form-control">{{ $mahasiswa->user->email }}</p>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-start">
                                <a href="/mahasiswa/{{ $mahasiswa->id }}/edit" class="btn btn-outline-warning me-3">Edit</a>
                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal{{ $mahasiswa->id }}">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="exampleModal{{ $mahasiswa->id }}" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-wrap">
                            Apakah Anda Yakin Ingin Menghapus Data {{ $mahasiswa->user->nama }}?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                            <form action="/mahasiswa/{{ $mahasiswa->id }}" method="post">
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
                    <a href="/mahasiswa/{{ $mahasiswa->id }}/edit" class="btn btn-outline-warning me-3">Edit</a>
                    <form action="/mahasiswa/{{ $mahasiswa->id }}" method="post">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3 col-12 mb-0">
                    <div class="alert alert-primary">
                        <h6 class="alert-heading fw-bold mb-1">Kelola Data mahasiswa</h6>
                        <p class="mb-0">Ketika Form Tambah Data mahasiswa dihapus atau diubah,<br />
                            Maka Secara Otomatis Kode QR akan dihapus atau terubah, <br />
                            Dan Langsung diseusaikan dengan kode qr yang tertera
                        </p>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@endsection
