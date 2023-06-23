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
                <h5 class="mb-0">Kelola Pemakaian Alat</h5>
                <div class="d-flex justify-content-end">
                    <small class="text-muted float-end">
                        @if (auth()->user()->role != 'admin')
                            @if ($selesai)
                                <a href="/pemakaian/create">
                                    <button class="btn btn-primary">Tambah</button>
                                </a>
                            @endif
                        @endif
                    </small>
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
                                                        data-bs-placement="top" data-bs-title="Seelesai"
                                                        href="/pemakaian/{{ $pemakaian->id }}/edit"><i
                                                            class='bx bx-calendar-check'></i>
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
        <!--/ Bordered Table -->
    </div>
@endsection
