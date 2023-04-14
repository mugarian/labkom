@extends('layout.main')
@section('container')
    <!-- Bordered Table -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="/kegiatan" class="text-secondary">kegiatan</a>
                /</span> Kelola kegiatan</h4>
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Kelola kegiatan</h5>
                <div class="d-flex justify-content-end">
                    @if (auth()->user()->role == 'dosen')
                        <small class="text-muted float-end me-3"><a href="/kegiatan/pelaksanaan"><button
                                    class="btn btn-primary">Pelaksanaan</button></a></small>
                    @elseif (auth()->user()->role != 'admin')
                        <small class="text-muted float-end"><a href="/kegiatan/permohonan"><button
                                    class="btn btn-primary">Permohonan</button></a></small>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 0">#</th>
                                <th>Nama</th>
                                <th>Jenis</th>
                                <th>Oleh</th>
                                <th>Tanggal Mulai</th>
                                <th>Status</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($kegiatans as $kegiatan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $kegiatan->nama }}</td>
                                    <td>{{ $kegiatan->jenis }}</td>
                                    <td>{{ $kegiatan->user->nama }}</td>
                                    <td>{{ $kegiatan->mulai }}</td>
                                    <td>{{ $kegiatan->status }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a class="btn btn-outline-success p-1" href="/kegiatan/{{ $kegiatan->id }}"><i
                                                    class="bx bx-info-circle"></i></a>
                                            @if (auth()->user()->role == 'dosen')
                                                @if ($kegiatan->status == 'menunggu')
                                                    <form action="/kegiatan/{{ $kegiatan->id }}/status" method="post">
                                                        @csrf
                                                        <input type="hidden" name="status" value="diverifikasi">
                                                        <button type="submit" class="btn btn-warning p-1">
                                                            <i class='bx bx-message-square-check'></i>
                                                        </button>
                                                    </form>
                                                    <form action="/kegiatan/{{ $kegiatan->id }}/status" method="post">
                                                        @csrf
                                                        <input type="hidden" name="status" value="ditolak">
                                                        <button type="submit" class="btn btn-danger p-1">
                                                            <i class='bx bx-message-square-x'></i>
                                                        </button>
                                                    </form>
                                                @elseif ($kegiatan->status == 'diverifikasi')
                                                    <form action="/kegiatan/{{ $kegiatan->id }}/status" method="post">
                                                        @csrf
                                                        <input type="hidden" name="status" value="disetujui">
                                                        <button type="submit" class="btn btn-primary p-1">
                                                            <i class='bx bx-message-square-check'></i>
                                                        </button>
                                                    </form>
                                                    <form action="/kegiatan/{{ $kegiatan->id }}/status" method="post">
                                                        @csrf
                                                        <input type="hidden" name="status" value="ditolak">
                                                        <button type="submit" class="btn btn-danger p-1">
                                                            <i class='bx bx-message-square-x'></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--/ Bordered Table -->
    </div>
@endsection
