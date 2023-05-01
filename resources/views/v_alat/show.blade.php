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
                        <div class="mb-4">
                            <label class="form-label" for="stok">Stok</label>
                            <p class="form-control">{{ $alat->stok }}</p>
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
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Tracking Barang Pakai (Alat)</h5>
                    </div>
                    <div class="card-body pb-2">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th>Foto</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Lokasi</th>
                                        <th>Deskripsi</th>
                                        <th>Keterangan</th>
                                        {{-- <th style="width: 0">Aksi</th> --}}
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @forelse ($barangpakai as $bp)
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
                                            <td class="text-wrap">{{ $bp->deskripsi }}</td>
                                            <td class="text-wrap">{{ $bp->keterangan }}</td>
                                            {{-- <td>
                                                <div class="d-flex justify-content-center">
                                                    <a class="btn btn-outline-success p-1"
                                                        href="/barangpakai/{{ $bp->id }}"><i
                                                            class="bx bx-info-circle"></i></a>
                                                    @if (auth()->user()->role == 'admin' || $bp->laboratorium->user->id == auth()->user()->id)
                                                        <a class="btn btn-outline-warning p-1"
                                                            href="/barangpakai/{{ $bp->id }}/edit"><i
                                                                class="bx bx-edit-alt"></i></a>
                                                        <form action="/barangpakai/{{ $bp->id }}" method="post">
                                                            @method('delete')
                                                            @csrf
                                                            <button type="submit" class="btn btn-outline-danger p-1">
                                                                <i class="bx bx-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td> --}}
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="100%">
                                                <div class="my-5">
                                                    <h3 class="text-muted">
                                                        Tidak Ada Data Barang Pakai (Alat)
                                                    </h3>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex align-items-center justify-content-end mt-4 mb-0">
                            {{ $barangpakai->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="card mt-4">
            <div class="card-header">
                @if (auth()->user()->role == 'admin')
                    <div class="d-flex justify-content-start">
                        <a href="/alat/{{ $alat->id }}/edit" class="btn btn-outline-warning me-3">Edit</a>
                        <form action="/alat/{{ $alat->id }}" method="post">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-outline-danger">
                                Delete
                            </button>
                        </form>
                    </div>
                @endif
            </div>
            <div class="card-body">
                <div class="mb-3 col-12 mb-0">
                    <div class="alert alert-primary">
                        <h6 class="alert-heading fw-bold mb-1">Kelola Data alat</h6>
                        <p class="mb-0">Ketika Form Tambah Data alat dihapus atau diubah,<br />
                            Maka Secara Otomatis Kode QR akan dihapus atau terubah, <br />
                            Dan Langsung diseusaikan dengan kode qr yang tertera
                        </p>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@endsection
