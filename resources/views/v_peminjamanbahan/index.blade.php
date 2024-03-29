@extends('layout.main')
@section('container')
    <!-- Bordered Table -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Beranda /</a>
                Logbook /
            </span>
            <span class="text-primary">
                Peminjaman Bahan Jurusan
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
                    <h5 class="mb-0">Peminjaman Bahan Jurusan</h5>
                @else
                    <h5 class="mb-0">Kelola Peminjaman Bahan Jurusan</h5>
                @endif
                <div class="d-flex justify-content-end ">
                    <small class="text-muted float-end">
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#filter">
                            <i class="bx bx-filter-alt"></i> Filter
                        </button>
                        @if (auth()->user()->role != 'admin')
                            @if ($selesai)
                                <a href="/peminjamanbahan/create">
                                    <button class="btn btn-primary">Tambah</button>
                                </a>
                            @endif
                        @endif
                    </small>
                </div>
                <div class="modal fade" id="filter" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Filter Tanggal Peminjaman Bahan Jurusan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('peminjamanbahan.index') }}" method="GET">
                                <div class="modal-body text-wrap">
                                    <div class="mb-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="tgl_pinjam_dari" class="form-label">Tanggal Pinjam Dari</label>
                                                <input type="datetime-local" class="form-control" id="tgl_pinjam_dari"
                                                    name="tgl_pinjam_dari"
                                                    value="{{ $_GET['tgl_pinjam_dari'] ?? old('tgl_pinjam_dari') }}"
                                                    onchange="tanggalpinjamawal()" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="tgl_pinjam_sampai" class="form-label">Tanggal Pinjam
                                                    Sampai</label>
                                                <input type="datetime-local" class="form-control" id="tgl_pinjam_sampai"
                                                    name="tgl_pinjam_sampai"
                                                    value="{{ $_GET['tgl_pinjam_sampai'] ?? old('tgl_pinjam_sampai') }}"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="tgl_kembali_dari" class="form-label">Tanggal Kembali
                                                    Dari</label>
                                                <input type="datetime-local" class="form-control" id="tgl_kembali_dari"
                                                    name="tgl_kembali_dari"
                                                    value="{{ $_GET['tgl_kembali_dari'] ?? old('tgl_kembali_dari') }}"
                                                    onchange="tanggalkembaliawal()" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="tgl_kembali_sampai" class="form-label">Tanggal Kembali
                                                    Sampai</label>
                                                <input type="datetime-local" class="form-control" id="tgl_kembali_sampai"
                                                    name="tgl_kembali_sampai"
                                                    value="{{ $_GET['tgl_kembali_sampai'] ?? old('tgl_kembali_sampai') }}"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('peminjamanbahan.index') }}" class="btn btn-secondary">
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
                                <th>Bahan Jurusan</th>
                                <th>Oleh</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="text-center">
                                <th style="width: 0">#</th>
                                <th>Bahan Jurusan</th>
                                <th>Oleh</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody class="text-center">
                            @foreach ($peminjamanbahans as $peminjamanbahan)
                                @if ($kalab)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-wrap">{{ $peminjamanbahan->namabahanjurusan }} <br>
                                            ({{ $peminjamanbahan->namalab }})
                                        </td>
                                        <td class="text-wrap">{{ $peminjamanbahan->namauser }}</td>
                                        <td>
                                            {{ $peminjamanbahan->tgl_pinjam }}
                                        </td>
                                        <td>{{ $peminjamanbahan->tgl_kembali }}</td>
                                        <td>{{ $peminjamanbahan->status }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a class="btn btn-outline-success p-1" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-title="Lihat Detail"
                                                    href="/peminjamanbahan/{{ $peminjamanbahan->id }}"><i
                                                        class="bx bx-info-circle"></i></a>
                                                <a class="btn btn-outline-info p-1" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-title="Form"
                                                    href="/peminjamanbahan/cetak/{{ $peminjamanbahan->id }}">
                                                    <i class="bx bxs-book-content"></i></a>
                                                @if ($peminjamanbahan->status == 'menunggu')
                                                    <form action="/peminjamanbahan/{{ $peminjamanbahan->id }}/status"
                                                        method="post">
                                                        @csrf
                                                        <input type="hidden" name="status" value="disetujui">
                                                        <button type="submit" class="btn btn-outline-primary p-1"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-title="Setuju">
                                                            <i class='bx bx-message-square-check'></i>
                                                        </button>
                                                    </form>
                                                    <a class="btn btn-outline-danger p-1" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" data-bs-title="Tolak"
                                                        href="/peminjamanbahan/{{ $peminjamanbahan->id }}/ditolak">
                                                        <i class="bx bx-message-square-x"></i>
                                                    </a>
                                                @endif
                                                @if (
                                                    ($peminjamanbahan->user_id == auth()->user()->id && $peminjamanbahan->status == 'disetujui') ||
                                                        $peminjamanbahan->status == 'telat')
                                                    <a class="btn btn-outline-primary p-1" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" data-bs-title="Kembalikan"
                                                        href="/peminjamanbahan/{{ $peminjamanbahan->id }}/edit">
                                                        <i class="bx bx-arrow-to-left"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-wrap">{{ $peminjamanbahan->bahanjurusan->bahanpraktikum->nama }}
                                            <br>
                                            ({{ $peminjamanbahan->bahanjurusan->laboratorium->nama }})
                                        </td>
                                        <td class="text-wrap">{{ $peminjamanbahan->user->nama }}</td>
                                        <td>{{ $peminjamanbahan->tgl_pinjam }}</td>
                                        <td>{{ $peminjamanbahan->tgl_kembali }}</td>
                                        <td>{{ $peminjamanbahan->status }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a class="btn btn-outline-success p-1"
                                                    href="/peminjamanbahan/{{ $peminjamanbahan->id }}">
                                                    <i class="bx bx-info-circle"></i>
                                                </a>
                                                <a class="btn btn-outline-info p-1" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-title="Form"
                                                    href="/peminjamanbahan/cetak/{{ $peminjamanbahan->id }}">
                                                    <i class="bx bxs-book-content"></i></a>
                                                @if (
                                                    ($peminjamanbahan->user_id == auth()->user()->id && $peminjamanbahan->status == 'disetujui') ||
                                                        $peminjamanbahan->status == 'telat')
                                                    <a class="btn btn-outline-primary p-1" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" data-bs-title="Kembalikan"
                                                        href="/peminjamanbahan/{{ $peminjamanbahan->id }}/edit">
                                                        <i class="bx bx-arrow-to-left"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <h5 class="card-header">Perhatian</h5>
            <div class="card-body">
                <div class="mb-3 col-12 mb-0">
                    <div class="alert alert-primary">
                        <h6 class="alert-heading fw-bold mb-1">Peminjaman Bahan Jurusan</h6>
                        <p class="mb-0">
                            Peminjaman bahan jurusan dilakukan ketika user akan melakukan peminjaman berupa barang bahan
                            jurusan (bahan tidak habis) seperti motherboard dan sebagainya. Setelah user selesai meminjam
                            bahan jurusan, <b class="fw-bold">WAJIB</b>
                            untuk mengisi kondisi bahan dan memberikan
                            bukti pengembalian berupa foto barang yang dipinjam telah dikembalikan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Bordered Table -->
    </div>
    <div class="modal fade" id="filter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Filter Tanggal Peminjaman Alat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('peminjamanbahan.index') }}" method="GET">
                    <div class="modal-body text-wrap">
                        <div class="mb-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="tgl_pinjam_dari" class="form-label">Tanggal Pinjam Dari</label>
                                    <input type="datetime-local" class="form-control" id="tgl_pinjam_dari"
                                        name="tgl_pinjam_dari"
                                        value="{{ $_GET['tgl_pinjam_dari'] ?? old('tgl_pinjam_dari') }}"
                                        onchange="tanggalpinjamawal()" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="tgl_pinjam_sampai" class="form-label">Tanggal Pinjam
                                        Sampai</label>
                                    <input type="datetime-local" class="form-control" id="tgl_pinjam_sampai"
                                        name="tgl_pinjam_sampai"
                                        value="{{ $_GET['tgl_pinjam_sampai'] ?? old('tgl_pinjam_sampai') }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="tgl_kembali_dari" class="form-label">Tanggal Kembali
                                        Dari</label>
                                    <input type="datetime-local" class="form-control" id="tgl_kembali_dari"
                                        name="tgl_kembali_dari"
                                        value="{{ $_GET['tgl_kembali_dari'] ?? old('tgl_kembali_dari') }}"
                                        onchange="tanggalkembaliawal()" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="tgl_kembali_sampai" class="form-label">Tanggal Kembali
                                        Sampai</label>
                                    <input type="datetime-local" class="form-control" id="tgl_kembali_sampai"
                                        name="tgl_kembali_sampai"
                                        value="{{ $_GET['tgl_kembali_sampai'] ?? old('tgl_kembali_sampai') }}" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('peminjamanbahan.index') }}" class="btn btn-secondary">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const tgl_pinjam_dari = document.getElementById('tgl_pinjam_dari');
        const tgl_pinjam_sampai = document.getElementById('tgl_pinjam_sampai');
        const tgl_kembali_dari = document.getElementById('tgl_kembali_dari');
        const tgl_kembali_sampai = document.getElementById('tgl_kembali_sampai');

        function tanggalpinjamawal() {
            tgl_pinjam_sampai.min = tgl_pinjam_dari.value;
            tgl_kembali_dari.min = tgl_pinjam_dari.value;
        }

        function tanggalkembaliawal() {
            tgl_kembali_sampai.min = tgl_kembali_dari.value;
        }
    </script>
@endsection
