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
                Pelaksanaan Praktikum
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
                @php
                    $user = App\Models\User::find(auth()->user()->id);
                    $dosen = App\Models\Dosen::where('user_id', $user->id)->first();
                @endphp
                @if ($user->role == 'dosen')
                    <h5 class="mb-0">Kelola Pelaksanaan Praktikum</h5>
                @else
                    <h5 class="mb-0">Pelaksanaan Praktikum</h5>
                @endif
                <div class="d-flex justify-content-end">
                    <small class="text-muted float-end mx-3">
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#filter">
                            <i class="bx bx-filter-alt"></i> Filter
                        </button>
                        @if ($jabatan == 'kalab')
                            <a href="/pelaksanaan/create">
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
                                <h5 class="modal-title" id="exampleModalLabel">Filter Tanggal Pelaksanaan Praktikum</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="{{ route('pelaksanaan.index') }}" method="GET">
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
                                    <a href="{{ route('pelaksanaan.index') }}" class="btn btn-secondary">
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
                                <th>Dospem</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Status</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="text-center">
                                <th style="width: 0">No</th>
                                <th class="text-wrap">Kode Kegiatan</th>
                                <th class="text-wrap">Nama Kegiatan</th>
                                <th>Dospem</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Status</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody class="text-center">
                            <?php $i = 1; ?>
                            @foreach ($pelaksanaans as $pelaksanaan)
                                @if ($pelaksanaan->jenis == 'permohonan')
                                    @continue
                                @endif
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td class="text-wrap">
                                        {{ $pelaksanaan->kode }}
                                    </td>
                                    <td class="text-wrap">
                                        {{ $pelaksanaan->nama }} <br> ({{ $pelaksanaan->laboratorium->nama }})
                                    </td>
                                    <td class="text-wrap">{{ $pelaksanaan->dospem->user->nama }}</td>
                                    <td class="text-wrap">{{ $pelaksanaan->mulai }}</td>
                                    <td class="text-wrap">
                                        {{ $pelaksanaan->selesai }}
                                        @if ($pelaksanaan->status == 'berlangsung')
                                            <br>
                                            (Rencana)
                                        @endif
                                    </td>
                                    <td class="text-wrap">{{ $pelaksanaan->status }} </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a class="btn btn-outline-success p-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-title="Lihat"
                                                href="/pelaksanaan/{{ $pelaksanaan->id }}"><i
                                                    class="bx bx-info-circle"></i></a>
                                            @if ($pelaksanaan->user_id == auth()->user()->id || $pelaksanaan->dospem->user_id == auth()->user()->id)
                                                @if ($pelaksanaan->status == 'berlangsung')
                                                    <form action="/pelaksanaan/{{ $pelaksanaan->id }}" method="post">
                                                        @csrf
                                                        @method('put')
                                                        <input type="hidden" name="status" value="selesai">
                                                        <button type="submit" class="btn btn-outline-primary p-1"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-title="Selesai">
                                                            <i class='bx bx-message-square-check'></i>
                                                        </button>
                                                    </form>
                                                @elseif ($pelaksanaan->status == 'terjadwal')
                                                    <form action="/pelaksanaan/{{ $pelaksanaan->id }}" method="post">
                                                        @csrf
                                                        @method('put')
                                                        <input type="hidden" name="status" value="berlangsung">
                                                        <button type="submit" class="btn btn-outline-primary p-1"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-title="Jadi">
                                                            <i class='bx bx-calendar-check'></i>
                                                        </button>
                                                    </form>
                                                    <form action="/pelaksanaan/{{ $pelaksanaan->id }}" method="post">
                                                        @csrf
                                                        @method('put')
                                                        <input type="hidden" name="status" value="ditolak">
                                                        <button type="submit" class="btn btn-outline-danger p-1"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-title="Tidak Jadi">
                                                            <i class='bx bx-calendar-x'></i>
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
        <div class="card mt-4">
            <h5 class="card-header">Perhatian</h5>
            <div class="card-body">
                <div class="mb-3 col-12 mb-0">
                    <div class="alert alert-primary">
                        <h6 class="alert-heading fw-bold mb-1">Pelaksanaan Praktikum</h6>
                        <p class="mb-0">
                            Kegiatan perkuliahan praktikum maupun non-perkuliahan yang dikelola oleh kalab dalam
                            menjadwalkan pelaksanaan praktikum yang sedang berlangsung.
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
