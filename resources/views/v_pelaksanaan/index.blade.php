@extends('layout.main')
@section('container')
    <!-- Bordered Table -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Data pelaksanaan</h4>
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Kelola pelaksanaan</h5>
                <div class="d-flex justify-content-end">
                    @if ($selesai && $jabatan == 'kalab')
                        <small class="text-muted float-end me-3">
                            <a href="/pelaksanaan/create">
                                <button class="btn btn-primary">Tambah</button>
                            </a>
                        </small>
                    @endif
                    {{-- @if ($jabatan != 'admin')
                        <small class="text-muted float-end"><a href="/pelaksanaan/permohonan"><button
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
                                <th>Dospem</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Status</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="text-center">
                                <th style="width: 0">#</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Dospem</th>
                                <th>Tanggal Mulai</th>
                                <th>Status</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody class="text-center">
                            @foreach ($pelaksanaans as $pelaksanaan)
                                @if ($pelaksanaan->jenis == 'permohonan')
                                    @continue
                                @endif
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-wrap">
                                        {{ $pelaksanaan->kode }}
                                    </td>
                                    <td class="text-wrap">
                                        {{ $pelaksanaan->nama }} <br> ({{ $pelaksanaan->laboratorium->nama }})
                                    </td>
                                    <td class="text-wrap">{{ $pelaksanaan->dospem->user->nama }}</td>
                                    <td class="text-wrap">{{ $pelaksanaan->mulai }}</td>
                                    <td class="text-wrap">{{ $pelaksanaan->selesai ?? '-' }}</td>
                                    <td class="text-wrap">{{ $pelaksanaan->status }} </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a class="btn btn-outline-success p-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-title="Lihat"
                                                href="/pelaksanaan/{{ $pelaksanaan->id }}"><i
                                                    class="bx bx-info-circle"></i></a>
                                            @if ($pelaksanaan->user_id == auth()->user()->id && $pelaksanaan->status != 'selesai')
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
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                {{-- @empty
                                <tr>
                                    <td colspan="100%">
                                        <div class="my-5">
                                            <h3 class="text-muted">
                                                Tidak Ada Data pelaksanaan
                                            </h3>
                                        </div>
                                    </td>
                                </tr> --}}
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- <div class="d-flex align-items-center justify-content-end mt-4 mb-0">
                    {{ $pelaksanaans->links() }}
                </div> --}}
            </div>
        </div>
        <!--/ Bordered Table -->
    </div>
@endsection
