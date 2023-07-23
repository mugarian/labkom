@extends('layout.main')
@section('container')
    <!-- Bordered Table -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Home /</a>
                Logbook /
            </span>
            <span class="text-primary">
                Pengunaan Bahan Praktikum
            </span>
        </h5>
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif (session()->has('fail'))
            <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                {{ session('fail') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                @if (auth()->user()->role == 'admin')
                    <h5 class="mb-0">Kelola Penggunaan Bahan Praktikum</h5>
                @else
                    <h5 class="mb-0">Penggunaan Bahan Praktikum</h5>
                @endif
                <div class="d-flex justify-content-end ">
                    <small class="text-muted float-end">
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#filter">
                            <i class="bx bx-filter-alt"></i> Filter
                        </button>
                        @if (auth()->user()->role != 'admin')
                            <a href="/penggunaan/create">
                                <button class="btn btn-primary">Tambah</button>
                            </a>
                        @endif
                    </small>
                </div>
                <div class="modal fade" id="filter" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Filter Tanggal Penggunaan Bahan Praktikum
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('penggunaan.index') }}" method="GET">
                                <div class="modal-body text-wrap">
                                    <div class="mb-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="tanggaldari" class="form-label">Dari</label>
                                                <input type="datetime-local" class="form-control" id="tanggaldari"
                                                    name="tanggaldari"
                                                    value="{{ $_GET['tanggaldari'] ?? old('tanggaldari') }}"
                                                    onchange="tanggalawal()" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="tanggalsampai" class="form-label">Sampai</label>
                                                <input type="datetime-local" class="form-control" id="tanggalsampai"
                                                    name="tanggalsampai"
                                                    value="{{ $_GET['tanggalsampai'] ?? old('tanggalsampai') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('penggunaan.index') }}" class="btn btn-secondary">
                                        Reset
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body pb-2">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered" id="myTable">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 0">#</th>
                                <th>Bahan Praktikum</th>
                                <th>Kegiatan</th>
                                <th>Oleh</th>
                                <th>Tanggal</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="text-center">
                                <th style="width: 0">#</th>
                                <th>Bahan Praktikum</th>
                                <th>Kegiatan</th>
                                <th>Oleh</th>
                                <th>Tanggal</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody class="text-center">
                            @foreach ($penggunaans as $penggunaan)
                                @if ($kalab)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-wrap">{{ $penggunaan->namabahanpraktikum }} <br>
                                            ({{ $penggunaan->namalab }})
                                        </td>
                                        <td class="text-wrap">{{ $penggunaan->namakegiatan }}</td>
                                        <td class="text-wrap">{{ $penggunaan->namauser }}</td>
                                        <td>{{ $penggunaan->tanggal }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a class="btn btn-outline-success p-1" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-title="Lihat"
                                                    href="/penggunaan/{{ $penggunaan->id }}"><i
                                                        class="bx bx-info-circle"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-wrap">{{ $penggunaan->bahanpraktikum->nama }} <br>
                                            ({{ $penggunaan->kegiatan->laboratorium->nama }})
                                        </td>
                                        <td class="text-wrap">{{ $penggunaan->kegiatan->nama }}</td>
                                        <td class="text-wrap">{{ $penggunaan->user->nama }}</td>
                                        <td>{{ $penggunaan->tanggal }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a class="btn btn-outline-success p-1"
                                                    href="/penggunaan/{{ $penggunaan->id }}"><i
                                                        class="bx bx-info-circle"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                {{-- @empty
                                    <tr>
                                        <td colspan="100%">
                                            <div class="my-5">
                                                <h3 class="text-muted">
                                                    Tidak Ada Data Penggunaan
                                                </h3>
                                            </div>
                                        </td>
                                    </tr> --}}
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- <div class="d-flex align-items-center justify-content-end mt-4 mb-0">
                    {{ $penggunaans->links() }}
                </div> --}}
            </div>
        </div>
        <div class="card mt-4">
            <h5 class="card-header">Perhatian</h5>
            <div class="card-body">
                <div class="mb-3 col-12 mb-0">
                    <div class="alert alert-primary">
                        <h6 class="alert-heading fw-bold mb-1">Penggunaan Bahan Praktikum</h6>
                        <p class="mb-0">
                            Penggunaan bahan digunakan ketika praktikum berlangsung. Setelah mahasiswa melaksanakan
                            praktikum dan menggunakan barang jenis bahan (perangkat yang tidak bisa berdiri sendiri) seperti
                            kabel rj45, kertas, baterai dan sebagainya, <b class="fw-bold">WAJIB</b> untuk mengisi form
                            penggunaan bahan tersebut.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Bordered Table -->
    </div>
    <script>
        const tanggaldari = document.getElementById('tanggaldari');
        const tanggalsampai = document.getElementById('tanggalsampai');

        function tanggalawal() {
            tanggalsampai.min = tanggaldari.value;
        }
    </script>
@endsection
