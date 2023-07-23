@extends('layout.main')
@section('container')
    <!-- Bordered Table -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Beranda /</a>
                Akun /
            </span>
            <span class="text-primary">
                Dosen
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
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Kelola Dosen</h5>
                <small class="text-muted float-end"><a href="/dosen/create"><button
                            class="btn btn-primary">Tambah</button></a></small>
            </div>
            <div class="card-body pb-2">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered" id="myTable">
                        <thead>
                            <tr class="text-center">
                                <th>Foto</th>
                                <th style="width: 0">NIP/NIK</th>
                                <th>Nama Dosen</th>
                                <th>Jurusan</th>
                                <th>Email</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="text-center">
                                <th>Foto</th>
                                <th style="width: 0">NIP/NIK</th>
                                <th>Nama</th>
                                <th>Jurusan</th>
                                <th>Email</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody class="text-center">
                            @foreach ($dosens as $dosen)
                                <tr>
                                    <td style="width:10%">
                                        @if ($dosen->user->foto)
                                            <img src="{{ asset('storage') . '/' . $dosen->user->foto }}" alt="dosen-avatar"
                                                class="d-block rounded img-preview" height="100" width="100"
                                                id="uploadedAvatar" />
                                        @else
                                            <img src="{{ asset('img') }}/unknown.png" alt="user-avatar"
                                                class="d-block rounded img-preview" height="100" width="100"
                                                id="uploadedAvatar" />
                                        @endif
                                    </td>
                                    <td>{{ $dosen->user->nomor_induk }}</td>
                                    <td class="text-wrap">{{ $dosen->user->nama }}</td>
                                    <td>{{ $dosen->jurusan }}</td>
                                    <td class="text-wrap">{{ $dosen->user->email }}</td>
                                    <td>

                                        <div class="d-flex justify-content-center">
                                            <a class="btn btn-outline-success p-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-title="Lihat"
                                                href="/dosen/{{ $dosen->id }}">
                                                <i class="bx bx-info-circle"></i>
                                            </a>
                                            <a class="btn btn-outline-warning p-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-title="Ubah"
                                                href="/dosen/{{ $dosen->id }}/edit">
                                                <i class="bx bx-edit-alt"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger p-1" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal{{ $dosen->id }}">
                                                <i class="bx bx-trash" data-bs-toggle="tooltip" data-bs-placement="top"
                                                    data-bs-title="Hapus"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" id="exampleModal{{ $dosen->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-wrap">
                                                Apakah Anda Yakin Ingin Menghapus Data {{ $dosen->user->nama }}?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tidak</button>
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- <div class="d-flex align-items-center justify-content-end mt-4 mb-0">
                    {{ $dosens->links() }}
                </div> --}}
            </div>
        </div>
        <!--/ Bordered Table -->
    </div>
@endsection
