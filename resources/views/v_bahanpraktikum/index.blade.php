@extends('layout.main')
@section('container')
    <!-- Bordered Table -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Home /</a>
                Invetori /
            </span>
            <span class="text-primary">
                Bahan Praktikum
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
                    <h5 class="mb-0">Kelola Bahan Praktikum</h5>
                @else
                    <h5 class="mb-0">Daftar Bahan Praktikum</h5>
                @endif
                @if (auth()->user()->role == 'admin')
                    <p class="mb-0">Total Harga: {{ $total }}</p>
                @endif
                <div class="d-flex justify-content-end">
                    <small class="text-muted float-end">
                        @if (auth()->user()->role == 'admin')
                            <a href="/bahanpraktikum/create">
                                <button class="btn btn-primary">Tambah</button>
                            </a>
                        @endif
                    </small>
                </div>
            </div>
            <div class="card-body pb-2">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered" id="myTable">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 0">No</th>
                                <th>Foto</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>stok</th>
                                <th>tahun</th>
                                @if (auth()->user()->role == 'admin')
                                    <th>Harga</th>
                                @endif
                                <th>Laboratorium</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="text-center">
                                <th style="width: 0">No</th>
                                <th>Foto</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>stok</th>
                                <th>tahun</th>
                                @if (auth()->user()->role == 'admin')
                                    <th>Harga</th>
                                @endif
                                <th>Laboratorium</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody class="text-center">
                            @foreach ($bahanpraktikums as $bahanpraktikum)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td style="width:10%">
                                        @if ($bahanpraktikum->foto)
                                            <img src="{{ asset('storage') . '/' . $bahanpraktikum->foto }}"
                                                alt="bahanpraktikum-avatar" class="d-block rounded img-preview"
                                                height="100" width="100" id="uploadedAvatar" />
                                        @else
                                            <img src="{{ asset('img') }}/unknown.png" alt="user-avatar"
                                                class="d-block rounded img-preview" height="100" width="100"
                                                id="uploadedAvatar" />
                                        @endif
                                    </td>
                                    <td class="text-wrap">{{ $bahanpraktikum->kode }}</td>
                                    <td class="text-wrap">{{ $bahanpraktikum->nama }}</td>
                                    <td class="text-wrap">{{ $bahanpraktikum->stok }}</td>
                                    <td class="text-wrap">{{ $bahanpraktikum->tahun }}</td>
                                    @if (auth()->user()->role == 'admin')
                                        <td class="text-wrap">Rp. {{ number_format($bahanpraktikum->harga, 2, ',', '.') }}
                                        </td>
                                    @endif
                                    <td class="text-wrap">{{ $bahanpraktikum->laboratorium->nama }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a class="btn btn-outline-success p-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-title="Lihat"
                                                href="/bahanpraktikum/{{ $bahanpraktikum->id }}"><i
                                                    class="bx bx-info-circle"></i></a>
                                            @if (auth()->user()->role == 'admin')
                                                <a class="btn btn-outline-warning p-1" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-title="Ubah"
                                                    href="/bahanpraktikum/{{ $bahanpraktikum->id }}/edit"><i
                                                        class="bx bx-edit-alt"></i></a>
                                                <button type="button" class="btn btn-outline-danger p-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal{{ $bahanpraktikum->id }}">
                                                    <i class="bx bx-trash" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-title="Hapus"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" id="exampleModal{{ $bahanpraktikum->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-wrap">
                                                Apakah Anda yakin Ingin Menghapus Data {{ $bahanpraktikum->nama }}?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tidak</button>
                                                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                                                <form action="/bahanpraktikum/{{ $bahanpraktikum->id }}" method="post">
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
                    {{ $bahanpraktikums->links() }}
                </div> --}}
            </div>
        </div>
        <!--/ Bordered Table -->
    </div>
@endsection
