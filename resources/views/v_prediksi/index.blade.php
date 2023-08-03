@extends('layout.main')
@section('container')
    <!-- Bordered Table -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Beranda /</a>
                Pengajuan Bahan /
            </span>
            <span class="text-primary">
                Prediksi Pengajuan
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
                <h5 class="mb-0">Kelola Prediksi Pengajuan</h5>
                <small class="text-muted float-end">
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#filter">
                        <i class="bx bx-filter-alt"></i> Filter
                    </button>
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#import">
                        <i class="bx bx-archive-in"></i> Import
                    </button>
                    <a href="/prediksi/create"><button class="btn btn-primary">Tambah</button></a>
                </small>
            </div>
            <div class="modal fade" id="import" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Import File Excel Data Prediksi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('importPrediksi') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body text-wrap">
                                <div class="row mb-4">
                                    <label for="Format" class="col-sm-2 form-label">Format File</label>
                                    <div class="col-sm-10">
                                        <a href="{{ asset('format/format-prediksi.xlsx') }}" download="FormatImportPrediksi"
                                            class="btn btn-primary">Download</a>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label for="Importfile" class="col-sm-2 form-label">Import File</label>
                                    <div class="col-sm-10">
                                        <input class="form-control @error('upload') is-invalid @enderror" type="file"
                                            id="import" accept=".xls, .xlsx" required name="import">
                                        @error('upload')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="filter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Filter Tahun Pengadaan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('prediksi.index') }}" method="GET">
                            <div class="modal-body text-wrap">
                                <div class="mb-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="tahunawal" class="form-label">Tahun Pengadaan Dari</label>
                                            <input type="number" class="form-control" id="tahunawal" name="tahunawal"
                                                value="{{ $_GET['tahunawal'] ?? old('tahunawal', '2000') }}"
                                                onchange="mulaiawal()" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="tahunakhir" class="form-label">Tahun Pengadaan Sampai</label>
                                            <input type="number" class="form-control" id="tahunakhir" name="tahunakhir"
                                                value="{{ $_GET['tahunakhir'] ?? old('tahunakhir', date('Y')) }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="{{ route('prediksi.index') }}" class="btn btn-secondary">
                                    Reset
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @php
                $i = 1;
                $j = 1;
            @endphp
            <div class="card-body pb-2">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered" id="myTable">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 0">#</th>
                                <th>Nama Bahan</th>
                                <th>Oleh</th>
                                <th>Jenis Pengadaan</th>
                                <th>Jenis Harga</th>
                                <th>Jenis Stok</th>
                                <th>Tahun</th>
                                <th>Label</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="text-center">
                                <th style="width: 0">#</th>
                                <th>Nama Bahan</th>
                                <th>Oleh</th>
                                <th>Jenis Pengadaan</th>
                                <th>Jenis Harga</th>
                                <th>Jenis Stok</th>
                                <th>Tahun</th>
                                <th>Label</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody class="text-center">
                            @foreach ($prediksis as $prediksi)
                                @if (auth()->user()->role != 'admin')
                                    @if ($prediksi->datamentah->user_id != auth()->user()->id)
                                        @continue
                                    @endif
                                @endif
                                @if ($prediksi->datamentah->label == 'tidak layak')
                                    @continue
                                @endif
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td class="text-wrap">{{ $prediksi->datamentah->nama }}</td>
                                    <td class="text-wrap">{{ $prediksi->datamentah->user->nama }}</td>
                                    <td class="text-wrap">{{ $prediksi->jenis_pengadaan }}</td>
                                    <td class="text-wrap">{{ $prediksi->jenis_harga }}</td>
                                    <td class="text-wrap">{{ $prediksi->jenis_stok }}</td>
                                    <td class="text-wrap">{{ $prediksi->tahun_pengadaan }}</td>
                                    <td class="text-wrap">{{ $prediksi->datamentah->label }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a class="btn btn-outline-success p-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-title="Lihat"
                                                href="/prediksi/{{ $prediksi->id }}"><i
                                                    class="bx bx-info-circle"></i></a>
                                            @if (auth()->user()->id == $prediksi->user_id)
                                                <button type="button" class="btn btn-outline-danger p-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal{{ $prediksi->id }}">
                                                    <i class="bx bx-trash" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" data-bs-title="Hapus"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" id="exampleModal{{ $prediksi->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda Yakin Ingin Menghapus Data {{ $prediksi->nama }}?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tidak</button>
                                                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                                                <form action="/prediksi/{{ $prediksi->id }}" method="post">
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
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered" id="myTable2">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 0">#</th>
                                <th>Nama Bahan</th>
                                <th>Oleh</th>
                                <th>Jenis Pengadaan</th>
                                <th>Jenis Harga</th>
                                <th>Jenis Stok</th>
                                <th>Tahun</th>
                                <th>Label</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="text-center">
                                <th style="width: 0">#</th>
                                <th>Nama Bahan</th>
                                <th>Oleh</th>
                                <th>Jenis Pengadaan</th>
                                <th>Jenis Harga</th>
                                <th>Jenis Stok</th>
                                <th>Tahun</th>
                                <th>Label</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody class="text-center">
                            @foreach ($prediksis as $prediksi)
                                @if (auth()->user()->role != 'admin')
                                    @if ($prediksi->datamentah->user_id != auth()->user()->id)
                                        @continue
                                    @endif
                                @endif
                                @if ($prediksi->datamentah->label == 'layak')
                                    @continue
                                @endif
                                <tr>
                                    <td>{{ $j++ }}</td>
                                    <td class="text-wrap">{{ $prediksi->datamentah->nama }}</td>
                                    <td class="text-wrap">{{ $prediksi->datamentah->user->nama }}</td>
                                    <td class="text-wrap">{{ $prediksi->jenis_pengadaan }}</td>
                                    <td class="text-wrap">{{ $prediksi->jenis_harga }}</td>
                                    <td class="text-wrap">{{ $prediksi->jenis_stok }}</td>
                                    <td class="text-wrap">{{ $prediksi->tahun_pengadaan }}</td>
                                    <td class="text-wrap">{{ $prediksi->datamentah->label }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a class="btn btn-outline-success p-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-title="Lihat"
                                                href="/prediksi/{{ $prediksi->id }}"><i
                                                    class="bx bx-info-circle"></i></a>
                                            @if (auth()->user()->id == $prediksi->user_id)
                                                <button type="button" class="btn btn-outline-danger p-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal{{ $prediksi->id }}">
                                                    <i class="bx bx-trash" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" data-bs-title="Hapus"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" id="exampleModal{{ $prediksi->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda Yakin Ingin Menghapus Data {{ $prediksi->nama }}?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tidak</button>
                                                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                                                <form action="/prediksi/{{ $prediksi->id }}" method="post">
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
            </div>
        </div>
        <!--/ Bordered Table -->
    </div>
@endsection
