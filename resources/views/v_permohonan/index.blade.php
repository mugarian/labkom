@extends('layout.main')
@section('container')
    <!-- Bordered Table -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Beranda /</a>
                Kegiatan /
            </span>
            <span class="text-primary">
                Permohonan Kegiatan
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
                    <h5 class="mb-0">Permohonan Kegiatan</h5>
                @else
                    <h5 class="mb-0">Kelola Permohonan Kegiatan</h5>
                @endif
                <div class="d-flex justify-content-end">
                    <small class="text-muted float-end me-3">
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#filter">
                            <i class="bx bx-filter-alt"></i> Filter
                        </button>
                        @if (auth()->user()->role != 'admin')
                            <a href="/permohonan/create">
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
                                <h5 class="modal-title" id="exampleModalLabel">Filter Tanggal Permohonan Kegiatan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('permohonan.index') }}" method="GET">
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
                                    <a href="{{ route('permohonan.index') }}" class="btn btn-secondary">
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
                                <th style="width: 0">No</th>
                                <th class="text-wrap">Kode Kegiatan</th>
                                <th class="text-wrap">Nama Kegiatan</th>
                                <th>Oleh</th>
                                <th>Dospem</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="text-center">
                                <th style="width: 0">No</th>
                                <th class="text-wrap">Kode Kegiatan</th>
                                <th class="text-wrap">Nama Kegiatan</th>
                                <th>Oleh</th>
                                <th>Dospem</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody class="text-center">
                            @foreach ($permohonans as $permohonan)
                                @if ($permohonan->jenis == 'pelaksanaan')
                                    @continue
                                @endif
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-wrap">
                                        {{ $permohonan->kode }}
                                    </td>
                                    <td class="text-wrap">
                                        {{ $permohonan->nama }} <br> ({{ $permohonan->laboratorium->nama }})
                                    </td>
                                    <td class="text-wrap">{{ $permohonan->user->nama }}</td>
                                    <td class="text-wrap">{{ $permohonan->dospem->user->nama }}</td>
                                    <td class="text-wrap">
                                        @if ($permohonan->status == 'berlangsung' || $permohonan->status == 'selesai')
                                            <b>Mulai:</b> <br>
                                        @else
                                            <b>Rencana Mulai:</b> <br>
                                        @endif
                                        {{ $permohonan->mulai }} <br>
                                        @if ($permohonan->status == 'selesai')
                                            <b>Selesai:</b> <br>
                                        @else
                                            <b>Rencana Selesai:</b> <br>
                                        @endif
                                        {{ $permohonan->selesai ?? '-' }}
                                    </td>
                                    <td class="text-wrap">
                                        <b>Dospem:</b> <br> {{ $permohonan->verif_dospem }} <br>
                                        <b>Kalab:</b> <br> {{ $permohonan->verif_kalab }} <br>
                                        <b>Status:</b> <br> {{ $permohonan->status }}
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a class="btn btn-outline-success p-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-title="Lihat"
                                                href="/permohonan/{{ $permohonan->id }}">
                                                <i class="bx bx-info-circle"></i>
                                            </a>
                                            {{-- User/Pembuat --}}
                                            @if ($permohonan->user_id == auth()->user()->id)
                                                @if ($permohonan->status == 'disetujui')
                                                    <form action="/permohonan/{{ $permohonan->id }}" method="post">
                                                        @csrf
                                                        @method('put')
                                                        <input type="hidden" name="status" value="berlangsung">
                                                        <input type="hidden" name="mulai"
                                                            value="{{ Date('Y-m-d H:i:s') }}">
                                                        <button type="submit" class="btn btn-outline-primary p-1"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-title="Mulai">
                                                            <i class='bx bx-message-square-check'></i> </button>
                                                    </form>
                                                @elseif ($permohonan->status == 'berlangsung')
                                                    <form action="/permohonan/{{ $permohonan->id }}" method="post">
                                                        @csrf
                                                        @method('put')
                                                        <input type="hidden" name="status" value="selesai">
                                                        <input type="hidden" name="selesai"
                                                            value="{{ Date('Y-m-d H:i:s') }}">
                                                        <button type="submit" class="btn btn-primary p-1"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-title="Mulai">
                                                            <i class='bx bx-message-square-check'></i> </button>
                                                    </form>
                                                @endif
                                                {{-- Dospem --}}
                                            @elseif ($permohonan->dospem->user_id == auth()->user()->id)
                                                @if ($permohonan->verif_dospem == 'menunggu' && $permohonan->status == 'menunggu')
                                                    <form action="/permohonan/{{ $permohonan->id }}" method="post">
                                                        @csrf
                                                        @method('put')
                                                        <input type="hidden" name="verif_dospem" value="disetujui">
                                                        @if ($permohonan->laboratorium->user_id == auth()->user()->id)
                                                            <input type="hidden" name="verif_kalab" value="disetujui">
                                                            <input type="hidden" name="status" value="disetujui">
                                                        @else
                                                            <input type="hidden" name="status" value="menunggu">
                                                            <input type="hidden" name="verif_kalab" value="menunggu">
                                                        @endif
                                                        <button type="submit" class="btn btn-outline-primary p-1"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-title="Dospem Setuju">
                                                            <i class='bx bx-message-square-check'></i>
                                                        </button>
                                                    </form>
                                                    <a href="/permohonan/{{ $permohonan->id }}/ditolak"
                                                        class="btn btn-outline-danger p-1" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" data-bs-title="Menolak">
                                                        <i class='bx bx-message-square-x'></i>
                                                    </a>
                                                @endif
                                            @endif
                                            {{-- Kalab --}}
                                            @if ($permohonan->laboratorium->user_id == auth()->user()->id)
                                                @if ($permohonan->verif_dospem == 'disetujui' && $permohonan->verif_kalab == 'menunggu')
                                                    <form action="/permohonan/{{ $permohonan->id }}" method="post">
                                                        @csrf
                                                        @method('put')
                                                        <input type="hidden" name="verif_dospem" value="disetujui">
                                                        <input type="hidden" name="verif_kalab" value="disetujui">
                                                        <input type="hidden" name="status" value="disetujui">
                                                        <button type="submit" class="btn btn-outline-primary p-1"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-title="Setuju">
                                                            <i class='bx bx-message-square-check'></i>
                                                        </button>
                                                    </form>
                                                    <a href="/permohonan/{{ $permohonan->id }}/ditolak"
                                                        class="btn btn-outline-danger p-1" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" data-bs-title="Tolak">
                                                        <i class='bx bx-message-square-x'></i>
                                                    </a>
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
                                                Tidak Ada Data permohonan
                                            </h3>
                                        </div>
                                    </td>
                                </tr> --}}
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- <div class="d-flex align-items-center justify-content-end mt-4 mb-0">
                    {{ $permohonans->links() }}
                </div> --}}
            </div>
        </div>
        <div class="card mt-4">
            <h5 class="card-header">Perhatian</h5>
            <div class="card-body">
                <div class="mb-3 col-12 mb-0">
                    <div class="alert alert-primary">
                        <h6 class="alert-heading fw-bold mb-1">Permohonan Praktikum</h6>
                        <p class="mb-0">
                            Kegiatan yang dilakukan oleh user yang akan melakukan peminjaman laboratorium untuk kegiatan
                            perkuliahan praktikum atau non-perkuliahan.
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
