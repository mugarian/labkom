@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Beranda /</a>
                Invetori /
                <a href="/alat" class="text-secondary">Alat /</a>
            </span>
            <span class="text-primary">
                {{ $alat->nama }}
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
        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Alat</h5>
                        <small class="text-muted float-end"><a href="/alat">
                                < Kembali </a></small>
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
                        <div class="mb-3">
                            <label class="form-label" for="kategori">Kategori</label>
                            <p class="form-control">{{ $alat->kategori }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama Barang</label>
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
                            <label class="form-label" for="spesifikasi">Tahun</label>
                            <p class="form-control">{{ $alat->tahun }}</p>
                        </div>
                        @if (auth()->user()->role == 'admin')
                            <div class="mb-3">
                                <label class="form-label" for="spesifikasi">Jumlah Harga</label>
                                <p class="form-control">Rp. {{ number_format($jumlahharga, 2, ',', '.') }}</p>
                            </div>
                        @endif
                        <div class="mb-3">
                            @if (auth()->user()->role == 'admin')
                                <div class="d-flex justify-content-start">
                                    <a href="/alat/{{ $alat->id }}/edit" class="btn btn-outline-warning me-3">Edit</a>
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal{{ $alat->id }}">
                                        Delete
                                    </button>
                                    {{-- <form action="/alat/{{ $alat->id }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger"
                                            onclick="if (confirm('Hapus Data')) return true; return false">
                                            Delete
                                        </button>
                                    </form> --}}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="exampleModal{{ $alat->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-wrap">
                            Apakah Anda Yakin Ingin Menghapus Data {{ $alat->nama }}?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                            <form action="/alat/{{ $alat->id }}" method="post">
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
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Daftar Alat</h5>
                        @if (auth()->user()->role == 'admin')
                            <small class="text-muted float-end">
                                <a href="/barangpakai/create/{{ $alat->id }}"><button
                                        class="btn btn-primary">Tambah</button></a>
                            </small>
                        @endif
                    </div>
                    <div class="card-body pb-2">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-bordered" id="myTable">
                                <thead>
                                    <tr class="text-center">
                                        <th>Foto</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Lokasi</th>
                                        @if (auth()->user()->role == 'admin')
                                            <th>Harga</th>
                                        @endif
                                        <th>Status</th>
                                        <th>Aksi</th>
                                        {{-- <th style="width: 0">Aksi</th> --}}
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr class="text-center">
                                        <th>Foto</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Lokasi</th>
                                        @if (auth()->user()->role == 'admin')
                                            <th>Harga</th>
                                        @endif
                                        <th>Status</th>
                                        <th>Aksi</th>
                                        {{-- <th style="width: 0">Aksi</th> --}}
                                    </tr>
                                </tfoot>
                                <tbody class="text-center">
                                    @foreach ($barangpakai as $bp)
                                        <tr>
                                            <td style="width:10%">
                                                @if ($bp->foto)
                                                    <img src="{{ asset('storage') . '/' . $bp->foto }}" alt="bp-avatar"
                                                        class="d-block rounded img-preview" height="100" width="100"
                                                        id="uploadedAvatar" />
                                                @else
                                                    <img src="{{ asset('img') }}/unknown.png" alt="user-avatar"
                                                        class="d-block rounded img-preview" height="100" width="100"
                                                        id="uploadedAvatar" />
                                                @endif
                                            </td>
                                            <td>{{ $bp->kode }}</td>
                                            <td class="text-wrap">{{ $bp->nama }}</td>
                                            <td class="text-wrap">{{ $bp->laboratorium->nama }}</td>
                                            @if (auth()->user()->role == 'admin')
                                                <td class="text-wrap">Rp. {{ number_format($bp->harga, 2, ',', '.') }}
                                                </td>
                                            @endif
                                            <td class="text-wrap">
                                                {{ $bp->status }}
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a class="btn btn-outline-success p-1"
                                                        href="/barangpakai/{{ $bp->id }}"><i
                                                            class="bx bx-info-circle"></i></a>
                                                    @if (auth()->user()->role == 'admin')
                                                        <a class="btn btn-outline-warning p-1"
                                                            href="/barangpakai/{{ $bp->id }}/edit"><i
                                                                class="bx bx-edit-alt"></i></a>
                                                        <button type="button" class="btn btn-outline-danger p-1"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#exampleModal{{ $bp->id }}">
                                                            <i class="bx bx-trash" data-bs-toggle="tooltip"
                                                                data-bs-placement="top" data-bs-title="Hapus"></i>
                                                        </button>
                                                        {{-- <form action="/barangpakai/{{ $bp->id }}" method="post">
                                                            @method('delete')
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-danger p-1">
                                                                <i class="bx bx-trash"></i>
                                                            </button>
                                                        </form> --}}
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <div class="modal fade" id="exampleModal{{ $bp->id }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-wrap">
                                                        Apakah Anda Yakin Ingin Menghapus Data {{ $bp->nama }}?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Tidak</button>
                                                        {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                                                        <form action="/barangpakai/{{ $bp->id }}" method="post">
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
                            {{ $barangpakai->links() }}
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
