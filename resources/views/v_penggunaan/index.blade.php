@extends('layout.main')
@section('container')
    <!-- Bordered Table -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Data Penggunaan
        </h4>
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
                <h5 class="mb-0">Kelola penggunaan</h5>
                <div class="d-flex justify-content-end ">
                    @if (auth()->user()->role != 'admin')
                        <small class="text-muted float-end">
                            <a href="/penggunaan/create">
                                <button class="btn btn-primary">penggunaan</button>
                            </a>
                        </small>
                    @endif
                </div>
            </div>
            <div class="card-body pb-2">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 0">#</th>
                                <th>Barang</th>
                                <th>Kegiatan</th>
                                <th>Oleh</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @forelse ($penggunaans as $penggunaan)
                                @if ($kalab)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-wrap">{{ $penggunaan->namabarang }} <br>
                                            ({{ $penggunaan->namalab }})
                                        </td>
                                        <td class="text-wrap">{{ $penggunaan->namakegiatan }}</td>
                                        <td class="text-wrap">{{ $penggunaan->namauser }}</td>
                                        <td>{{ $penggunaan->tanggal }}</td>
                                        <td>{{ $penggunaan->status }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a class="btn btn-outline-success p-1"
                                                    href="/penggunaan/{{ $penggunaan->id }}"><i
                                                        class="bx bx-info-circle"></i></a>
                                                @if ($penggunaan->status == 'menunggu')
                                                    <form action="/penggunaan/{{ $penggunaan->id }}/status" method="post">
                                                        @csrf
                                                        <input type="hidden" name="status" value="disetujui">
                                                        <button type="submit" class="btn btn-primary p-1">
                                                            <i class='bx bx-message-square-check'></i>
                                                        </button>
                                                    </form>
                                                    <a
                                                        class="btn btn-danger p-1"href="/penggunaan/{{ $penggunaan->id }}/edit">
                                                        <i class="bx bx-message-square-x"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-wrap">{{ $penggunaan->baranghabis->nama }} <br>
                                            ({{ $penggunaan->kegiatan->laboratorium->nama }})
                                        </td>
                                        <td class="text-wrap">{{ $penggunaan->kegiatan->nama }}</td>
                                        <td class="text-wrap">{{ $penggunaan->user->nama }}</td>
                                        <td>{{ $penggunaan->tanggal }}</td>
                                        <td>{{ $penggunaan->status }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a class="btn btn-outline-success p-1"
                                                    href="/penggunaan/{{ $penggunaan->id }}"><i
                                                        class="bx bx-info-circle"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="100%">
                                        <div class="my-5">
                                            <h3 class="text-muted">
                                                Tidak Ada Data Penggunaan
                                            </h3>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex align-items-center justify-content-end mt-4 mb-0">
                    {{ $penggunaans->links() }}
                </div>
            </div>
        </div>
        <!--/ Bordered Table -->
    </div>
@endsection
