@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Home /</a>
                Akun /
                <a href="/dosen" class="text-secondary">Dosen /</a>
            </span>
            <span class="text-primary">
                {{ $dosen->user->nama }}
            </span>
        </h5>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Akun Dosen</h5>
                        <small class="text-muted float-end"><a href="/dosen">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex align-items-center align-items-sm-center justify-content-center gap-4 mb-3">
                                @if ($dosen->user->foto)
                                    <img src="{{ asset('storage') . '/' . $dosen->user->foto }}" alt="dosen-avatar"
                                        class="d-block rounded" height="200" width="200" id="uploadedAvatar" />
                                @else
                                    <img src="{{ asset('img') }}/unknown.png" alt="user-avatar" class="d-block rounded"
                                        height="200" width="200" id="uploadedAvatar" />
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama Dosen</label>
                            <p class="form-control">{{ $dosen->user->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nomor_induk">Nomor Induk</label>
                            <p class="form-control">{{ $dosen->user->nomor_induk }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jabatan">Jabatan</label>
                            <p class="form-control">{{ $dosen->jabatan }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jurusan">Jurusan</label>
                            <p class="form-control">{{ $dosen->jurusan }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="Email">email</label>
                            <p class="form-control">{{ $dosen->user->email }}</p>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-start">
                                <a href="/dosen/{{ $dosen->id }}/edit" class="btn btn-outline-warning me-3">Edit</a>
                                <div class="d-flex justify-content-start">
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal{{ $dosen->id }}">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="exampleModal{{ $dosen->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-wrap">
                            Apakah Anda Yakin Ingin Menghapus Data {{ $dosen->user->nama }}?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                            <form action="/dosen/{{ $dosen->id }}" method="post">
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
                    <a href="/dosen/{{ $dosen->id }}/edit" class="btn btn-outline-warning me-3">Edit</a>
                    <form action="/dosen/{{ $dosen->id }}" method="post">
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
                        <h6 class="alert-heading fw-bold mb-1">Kelola Data dosen</h6>
                        <p class="mb-0">Ketika Form Tambah Data dosen dihapus atau diubah,<br />
                            Maka Secara Otomatis Kode QR akan dihapus atau terubah, <br />
                            Dan Langsung diseusaikan dengan kode qr yang tertera
                        </p>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@endsection
