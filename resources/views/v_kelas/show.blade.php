@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Home /</a>
                <a href="/kelas" class="text-secondary">Kelas /</a>
            </span>
            <span class="text-primary">
                {{ $kelas->nama }}
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
                        <h5 class="mb-0">Detail Kelas</h5>
                        <small class="text-muted float-end"><a href="/kelas">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama Kelas</label>
                            <p class="form-control">{{ $kelas->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="merk">jurusan</label>
                            <p class="form-control">{{ $kelas->jurusan }}</p>
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="spesifikasi">Angkatan</label>
                            <p class="form-control">{{ $kelas->angkatan }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="merk">Nama</label>
                            <p class="form-control">{{ $kelas->dosen->user->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">Nomor Induk</label>
                            <p class="form-control">{{ $kelas->dosen->user->nomor_induk }}</p>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-start">
                                @if (auth()->user()->role == 'admin')
                                    <a href="/kelas/{{ $kelas->id }}/edit" class="btn btn-outline-warning me-3">Edit</a>
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal{{ $kelas->id }}">
                                        Delete
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="exampleModal{{ $kelas->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-wrap">
                            Apakah Anda Yakin Ingin Menghapus Data {{ $kelas->nama }}?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                            <form action="/kelas/{{ $kelas->id }}" method="post">
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
                        <h5 class="mb-0">Mahasiswa</h5>
                    </div>
                    <div class="card-body pb-2">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-bordered" id="myTable">
                                <thead>
                                    <tr class="text-center">
                                        <th>Foto</th>
                                        <th>NIM</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Angkatan</th>
                                        <th>Jurusan</th>
                                        <th stile="width:0">Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr class="text-center">
                                        <th>Foto</th>
                                        <th>NIM</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Angkatan</th>
                                        <th>Jurusan</th>
                                        <th stile="width:0">Aksi</th>
                                    </tr>
                                </tfoot>
                                <tbody class="text-center">
                                    @foreach ($mahasiswas as $mahasiswa)
                                        <tr>
                                            <td style="width:10%">
                                                @if ($mahasiswa->user->foto)
                                                    <img src="{{ asset('storage') . '/' . $mahasiswa->user->foto }}"
                                                        alt="mahasiswa-avatar" class="d-block rounded img-preview"
                                                        height="100" width="100" id="uploadedAvatar" />
                                                @else
                                                    <img src="{{ asset('img') }}/unknown.png" alt="user-avatar"
                                                        class="d-block rounded img-preview" height="100" width="100"
                                                        id="uploadedAvatar" />
                                                @endif
                                            </td>
                                            <td>{{ $mahasiswa->user->nomor_induk }}</td>
                                            <td class="text-wrap">{{ $mahasiswa->user->nama }}</td>
                                            <td class="text-wrap">{{ $mahasiswa->angkatan }}</td>
                                            <td class="text-wrap">{{ $mahasiswa->jurusan }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a class="btn btn-outline-success p-1"
                                                        href="/mahasiswa/{{ $mahasiswa->id }}"><i
                                                            class="bx bx-info-circle"></i></a>
                                                    {{-- @if (auth()->user()->id == $kelas->user->id || auth()->user()->role == 'admin')
                                                        <a class="btn btn-outline-warning p-1"
                                                            href="/bahans/{{ $bahan->id }}/edit"><i
                                                                class="bx bx-edit-alt"></i></a>
                                                        <form action="/bahans/{{ $bahan->id }}" method="post">
                                                            @method('delete')
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-danger p-1">
                                                                <i class="bx bx-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif --}}
                                                </div>
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

        {{-- <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-start">
                    @if (auth()->user()->id == $kelas->user->id || auth()->user()->role == 'admin')
                        <a href="/kelas/{{ $kelas->id }}/edit"
                            class="btn btn-outline-warning me-3">Edit</a>
                        @if (auth()->user()->role == 'admin')
                            <form action="/kelas/{{ $kelas->id }}" method="post">
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
