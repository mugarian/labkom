@extends('layout.main')
@section('container')
    <!-- Bordered Table -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Beranda /</a>
            </span>
            <span class="text-primary">
                Mata Kuliah
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
                @if (auth()->user()->role == 'admin')
                    <h5 class="mb-0">Kelola Mata Kuliah</h5>
                    <small class="text-muted float-end"><a href="/matakuliah/create"><button
                                class="btn btn-primary">Tambah</button></a></small>
                @else
                    <h5 class="mb-0">Daftar Mata Kuliah</h5>
                @endif
            </div>
            <div class="card-body pb-2">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered" id="myTable">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 0">#</th>
                                <th>Nama Matkul</th>
                                <th>Dosen Pengampu</th>
                                <th>Jurusan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="text-center">
                                <th style="width: 0">#</th>
                                <th>Nama Matkul</th>
                                <th>Dosen Pengampu</th>
                                <th>Jurusan</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody class="text-center">
                            @foreach ($matkuls as $matkul)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-wrap">{{ $matkul->nama }}</td>
                                    <td class="text-wrap">{{ $matkul->dosen->user->nama }}</td>
                                    <td class="text-wrap">{{ $matkul->jurusan }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a class="btn btn-outline-success p-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-title="Lihat"
                                                href="/matakuliah/{{ $matkul->id }}">
                                                <i class="bx bx-info-circle"></i>
                                            </a>
                                            @if (auth()->user()->role == 'admin')
                                                <a class="btn btn-outline-warning p-1" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-title="Ubah"
                                                    href="/matakuliah/{{ $matkul->id }}/edit">
                                                    <i class="bx bx-edit-alt"></i>
                                                </a>
                                                @if (auth()->user()->role == 'admin')
                                                    <button type="button" class="btn btn-outline-danger p-1"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal{{ $matkul->id }}">
                                                        <i class="bx bx-trash" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" data-bs-title="Hapus"></i>
                                                    </button>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" id="exampleModal{{ $matkul->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-wrap">
                                                Apakah Anda Yakin Ingin Menghapus Data {{ $matkul->nama }}?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tidak</button>
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- <div class="d-flex align-items-center justify-content-end mt-4 mb-0">
                    {{ $kelass->links() }}
                </div> --}}
            </div>
        </div>
        <!--/ Bordered Table -->
    </div>
@endsection
