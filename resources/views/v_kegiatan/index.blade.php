@extends('layout.main')
@section('container')
    <!-- Bordered Table -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Data Kegiatan</h4>
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
                    @if ($jabatan == 'kalab')
                        <small class="text-muted float-end me-3"><a href="/kegiatan/pelaksanaan"><button
                                    class="btn btn-primary">Pelaksanaan</button></a></small>
                    @endif
                    @if ($jabatan != 'admin')
                        <small class="text-muted float-end"><a href="/kegiatan/permohonan"><button
                                    class="btn btn-primary">Permohonan</button></a></small>
                    @endif
                </div>
            </div>
            <div class="card-body pb-2">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered" id="myTable">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 0">#</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Jenis</th>
                                <th>Oleh</th>
                                <th>Tanggal Mulai</th>
                                <th>Status</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="text-center">
                                <th style="width: 0">#</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Jenis</th>
                                <th>Oleh</th>
                                <th>Tanggal Mulai</th>
                                <th>Status</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody class="text-center">
                            @foreach ($kegiatans as $kegiatan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-wrap">
                                        {{ $kegiatan->kode }}
                                    </td>
                                    <td class="text-wrap">
                                        {{ $kegiatan->nama }} <br> ({{ $kegiatan->laboratorium->nama }})
                                    </td>
                                    <td>{{ $kegiatan->jenis }}</td>
                                    <td class="text-wrap">{{ $kegiatan->user->nama }}</td>
                                    <td class="text-wrap">{{ $kegiatan->mulai }}</td>
                                    <td>{{ $kegiatan->status }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a class="btn btn-outline-success p-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-title="Lihat"
                                                href="/kegiatan/{{ $kegiatan->id }}"><i class="bx bx-info-circle"></i></a>
                                            @if ($kegiatan->status == 'menunggu')
                                                @if ($kegiatan->dospem->user->id == auth()->user()->id)
                                                    <form action="/kegiatan/{{ $kegiatan->id }}/status" method="post">
                                                        @csrf
                                                        <input type="hidden" name="status" value="diverifikasi">
                                                        <button type="submit" class="btn btn-warning p-1"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-title="Diverifikasi">
                                                            <i class='bx bx-message-square-check'></i>
                                                        </button>
                                                    </form>
                                                    <a class="btn btn-danger p-1" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" data-bs-title="Ditolak"
                                                        href="/kegiatan/{{ $kegiatan->id }}/edit">
                                                        <i class="bx bx-message-square-x"></i>
                                                    </a>
                                                    {{-- <form action="/kegiatan/{{ $kegiatan->id }}/status" method="post">
                                                        @csrf
                                                        <input type="hidden" name="status" value="ditolak">
                                                        <button type="submit" class="btn btn-danger p-1">
                                                            <i class='bx bx-message-square-x'></i>
                                                        </button>
                                                    </form> --}}
                                                @endif
                                            @elseif ($kegiatan->status == 'diverifikasi')
                                                @if ($kegiatan->laboratorium->user->id == auth()->user()->id)
                                                    <form action="/kegiatan/{{ $kegiatan->id }}/status" method="post">
                                                        @csrf
                                                        <input type="hidden" name="status" value="disetujui">
                                                        <button type="submit" class="btn btn-primary p-1"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-title="Disetujui">
                                                            <i class='bx bx-message-square-check'></i>
                                                        </button>
                                                    </form>
                                                    <a class="btn btn-danger p-1" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" data-bs-title="Ditolak"
                                                        href="/kegiatan/{{ $kegiatan->id }}/edit">
                                                        <i class="bx bx-message-square-x"></i>
                                                    </a>
                                                    {{-- <form action="/kegiatan/{{ $kegiatan->id }}/status" method="post">
                                                        @csrf
                                                        <input type="hidden" name="status" value="ditolak">
                                                        <button type="submit" class="btn btn-danger p-1">
                                                            <i class='bx bx-message-square-x'></i>
                                                        </button>
                                                    </form> --}}
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                {{-- @empty
                                <tr>
                                    <td colspan="100%">
                                        <div class="my-5">
                                            <h3 class="text-muted">
                                                Tidak Ada Data Kegiatan
                                            </h3>
                                        </div>
                                    </td>
                                </tr> --}}
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- <div class="d-flex align-items-center justify-content-end mt-4 mb-0">
                    {{ $kegiatans->links() }}
                </div> --}}
            </div>
        </div>
        <!--/ Bordered Table -->
    </div>
@endsection
