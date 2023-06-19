@extends('layout.main')
@section('container')
    <!-- Bordered Table -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Data Permohonan Kegiatan</h4>
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
                <h5 class="mb-0">Kelola Permohonan</h5>
                <div class="d-flex justify-content-end">
                    @if (auth()->user()->role != 'admin' && $selesai)
                        <small class="text-muted float-end me-3">
                            <a href="/permohonan/create">
                                <button class="btn btn-primary">Tambah</button>
                            </a>
                        </small>
                    @endif
                    {{-- @if ($jabatan != 'admin')
                        <small class="text-muted float-end"><a href="/permohonan/permohonan"><button
                                    class="btn btn-primary">Permohonan</button></a></small>
                    @endif --}}
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
                                <th>Oleh</th>
                                <th>Dospem</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="text-center">
                                <th style="width: 0">#</th>
                                <th>Kode</th>
                                <th>Nama</th>
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
                                                @if ($permohonan->verif_dospem == 'menunggu')
                                                    <form action="/permohonan/{{ $permohonan->id }}" method="post">
                                                        @csrf
                                                        @method('put')
                                                        <input type="hidden" name="verif_dospem" value="disetujui">
                                                        <input type="hidden" name="verif_kalab" value="menunggu">
                                                        <input type="hidden" name="status" value="menunggu">
                                                        <button type="submit" class="btn btn-outline-primary p-1"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-title="Setuju">
                                                            <i class='bx bx-message-square-check'></i>
                                                        </button>
                                                    </form>
                                                    <a href="/permohonan/{{ $permohonan->id }}/ditolak"
                                                        class="btn btn-outline-danger p-1" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" data-bs-title="Tolak">
                                                        <i class='bx bx-message-square-error'></i>
                                                    </a>
                                                    {{-- <form action="/permohonan/{{ $permohonan->id }}" method="post">
                                                        @csrf
                                                        @method('put')
                                                        <input type="hidden" name="verif_dospem" value="ditolak">
                                                        <input type="hidden" name="verif_kalab" value="menunggu">
                                                        <input type="hidden" name="status" value="ditolak">
                                                        <button type="submit" class="btn btn-outline-danger p-1"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-title="Tolak">
                                                            <i class='bx bx-message-square-error'></i>

                                                        </button>
                                                    </form> --}}
                                                @endif
                                                {{-- Kalab --}}
                                            @elseif ($permohonan->laboratorium->user_id == auth()->user()->id)
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
                                                        <i class='bx bx-message-square-error'></i>
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
        <!--/ Bordered Table -->
    </div>
@endsection
