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
                Pemakaian Alat
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
                    <h5 class="mb-0">Kelola Pemakaian Alat</h5>
                @else
                    <h5 class="mb-0">Pemakaian Alat</h5>
                @endif
                <div class="d-flex justify-content-end">
                    <small class="text-muted float-end">
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#filter">
                            <i class="bx bx-filter-alt"></i> Filter
                        </button>
                        @if (auth()->user()->role != 'admin')
                            @if ($selesai)
                                <a href="/pemakaian/create">
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
                                <h5 class="modal-title" id="exampleModalLabel">Filter Tanggal Pemakaian Alat</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('pemakaian.index') }}" method="GET">
                                <div class="modal-body text-wrap">
                                    <div class="mb-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="mulaidari" class="form-label">Mulai Dari</label>
                                                <input type="datetime-local" class="form-control" id="mulaidari"
                                                    name="mulaidari" value="{{ $_GET['mulaidari'] ?? old('mulaidari') }}"
                                                    onchange="mulaiawal()" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="mulaisampai" class="form-label">Mulai Sampai</label>
                                                <input type="datetime-local" class="form-control" id="mulaisampai"
                                                    name="mulaisampai"
                                                    value="{{ $_GET['mulaisampai'] ?? old('mulaisampai') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="selesaidari" class="form-label">Selesai Dari</label>
                                                <input type="datetime-local" class="form-control" id="selesaidari"
                                                    name="selesaidari"
                                                    value="{{ $_GET['selesaidari'] ?? old('selesaidari') }}"
                                                    onchange="selesaiawal()" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="selesaisampai" class="form-label">Selesai Sampai</label>
                                                <input type="datetime-local" class="form-control" id="selesaisampai"
                                                    name="selesaisampai"
                                                    value="{{ $_GET['selesaisampai'] ?? old('selesaisampai') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('pemakaian.index') }}" class="btn btn-secondary">
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
                                <th>barang pakai</th>
                                <th>Kegiatan</th>
                                <th>Oleh</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="text-center">
                                <th style="width: 0">#</th>
                                <th>barang pakai</th>
                                <th>Kegiatan</th>
                                <th>Oleh</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody class="text-center">
                            @foreach ($pemakaians as $pemakaian)
                                @if ($kalab)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-wrap">{{ $pemakaian->namabarangpakai }}
                                            <br>({{ $pemakaian->namalab }})
                                        </td>
                                        <td class="text-wrap">{{ $pemakaian->namakegiatan }}</td>
                                        <td class="text-wrap">{{ $pemakaian->namauser }}</td>
                                        <td>{{ $pemakaian->mulai }}</td>
                                        <td class="text-wrap">
                                            @if ($pemakaian->status == 'mulai')
                                                <div id="todaysDate">

                                                </div>
                                            @else
                                                {{ $pemakaian->selesai }} <br>({{ $pemakaian->status }})
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a class="btn btn-outline-success p-1" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-title="Lihat"
                                                    href="/pemakaian/{{ $pemakaian->id }}"><i
                                                        class="bx bx-info-circle"></i></a>
                                                @if ($pemakaian->iduser == auth()->user()->id && $pemakaian->status == 'mulai')
                                                    <a class="btn btn-outline-primary p-1" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" data-bs-title="Selesai"
                                                        href="/pemakaian/{{ $pemakaian->id }}/edit"><i
                                                            class='bx bx-calendar-check'></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-wrap">{{ $pemakaian->barangpakai->nama }}
                                            <br>({{ $pemakaian->kegiatan->laboratorium->nama }})
                                        </td>
                                        <td class="text-wrap">{{ $pemakaian->kegiatan->nama }}</td>
                                        <td class="text-wrap">{{ $pemakaian->user->nama }}</td>
                                        <td>{{ $pemakaian->mulai }}</td>
                                        <td class="text-wrap">
                                            @if ($pemakaian->status == 'mulai')
                                                <div id="todaysDate">

                                                </div>
                                            @else
                                                {{ $pemakaian->selesai }} <br>({{ $pemakaian->status }})
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a class="btn btn-outline-success p-1" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-title="Lihat"
                                                    href="/pemakaian/{{ $pemakaian->id }}"><i
                                                        class="bx bx-info-circle"></i></a>
                                                @if ($pemakaian->user->id == auth()->user()->id && $pemakaian->status == 'mulai')
                                                    <a class="btn btn-outline-primary p-1" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" data-bs-title="Selesai"
                                                        href="/pemakaian/{{ $pemakaian->id }}/edit">
                                                        <i class='bx bx-calendar-check'></i>
                                                    </a>
                                                    {{-- <form action="/pk/{{ $pemakaian->id }}/done" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-primary p-1">
                                                <i class='bx bx-calendar-check'></i>
                                            </button>
                                        </form> --}}
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                {{-- @empty
                                    <tr>
                                        <td colspan="100%">
                                            <div class="my-5">
                                                <h3 class="text-muted">
                                                    Tidak Ada Data Pemakaian
                                                </h3>
                                            </div>
                                        </td>
                                    </tr> --}}
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- <div class="d-flex align-items-center justify-content-end mt-4 mb-0">
                    {{ $pemakaians->links() }}
                </div> --}}
            </div>
        </div>
        <div class="card mt-4">
            <h5 class="card-header">Perhatian</h5>
            <div class="card-body">
                <div class="mb-3 col-12 mb-0">
                    <div class="alert alert-primary">
                        <h6 class="alert-heading fw-bold mb-1">Pemakaian Alat</h6>
                        <p class="mb-0">
                            Pemakaian alat digunakan ketika praktikum berlangsung. Setelah mahasiswa melaksanakan praktikum
                            dan menggunakan barang alat seperti perangkat PC, <b class="fw-bold">WAJIB</b> untuk mengisi
                            form pemakaian
                            alat
                            tersebut.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Bordered Table -->
    </div>
    <script>
        const mulaidari = document.getElementById('mulaidari');
        const mulaisampai = document.getElementById('mulaisampai');
        const selesaidari = document.getElementById('selesaidari');
        const selesaisampai = document.getElementById('selesaisampai');

        function mulaiawal() {
            mulaisampai.min = mulaidari.value;
            selesaidari.min = mulaidari.value;
        }

        function selesaiawal() {
            selesaisampai.min = selesaidari.value;
        }
    </script>
@endsection
