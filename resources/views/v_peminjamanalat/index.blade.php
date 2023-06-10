@extends('layout.main')
@section('container')
    <!-- Bordered Table -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Data Peminjaman Alat
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
                <h5 class="mb-0">Kelola Peminjaman Alat</h5>
                <div class="d-flex justify-content-end ">
                    @if (auth()->user()->role != 'admin')
                        {{-- @if ($selesai) --}}
                        <small class="text-muted float-end">
                            <a href="/peminjamanalat/create">
                                <button class="btn btn-primary">Tambah</button>
                            </a>
                        </small>
                        {{-- @endif --}}
                    @endif
                </div>
            </div>
            <div class="card-body pb-2">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered" id="myTable">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 0">#</th>
                                <th>Barang Pakai</th>
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
                                <th>Barang Pakai</th>
                                <th>Oleh</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody class="text-center">
                            @foreach ($peminjamanalats as $peminjamanalat)
                                @if ($kalab)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-wrap">{{ $peminjamanalat->namabarangpakai }} <br>
                                            ({{ $peminjamanalat->namalab }})
                                        </td>
                                        <td class="text-wrap">{{ $peminjamanalat->namauser }}</td>
                                        <td>
                                            @if ($peminjamanalat->status == 'disetujui' || $peminjamanalat->status == 'selesai')
                                                {{ $peminjamanalat->tgl_pinjam }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $peminjamanalat->tgl_kembali }}</td>
                                        <td>{{ $peminjamanalat->status }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a class="btn btn-outline-success p-1" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-title="Lihat"
                                                    href="/peminjamanalat/{{ $peminjamanalat->id }}"><i
                                                        class="bx bx-info-circle"></i></a>
                                                @if ($peminjamanalat->status == 'menunggu')
                                                    <form action="/peminjamanalat/{{ $peminjamanalat->id }}"
                                                        method="post">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="disetujui">
                                                        <button type="submit" class="btn btn-outline-primary p-1"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-title="Setuju">
                                                            <i class='bx bx-message-square-check'></i>
                                                        </button>
                                                    </form>
                                                    <a class="btn btn-outline-danger p-1" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" data-bs-title="Tolak"
                                                        href="/peminjamanalat/{{ $peminjamanalat->id }}/ditolak">
                                                        <i class="bx bx-message-square-x"></i>
                                                    </a>
                                                @endif
                                                @if ($peminjamanalat->user_id == auth()->user()->id && $peminjamanalat->status == 'disetujui')
                                                    <form action="/peminjamanalat/{{ $peminjamanalat->id }}"
                                                        method="post">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="selesai">
                                                        <input type="hidden" name="tgl_kembali"
                                                            value="{{ Date('Y-m-d H:i:s') }}">
                                                        <button type="submit" class="btn btn-outline-primary p-1"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-title="Kembalikan">
                                                            <i class='bx bx-arrow-to-left'></i> </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-wrap">{{ $peminjamanalat->barangpakai->nama }} <br>
                                            ({{ $peminjamanalat->barangpakai->laboratorium->nama }})
                                        </td>
                                        <td class="text-wrap">{{ $peminjamanalat->user->nama }}</td>
                                        <td>{{ $peminjamanalat->tgl_pinjam }}</td>
                                        <td>{{ $peminjamanalat->tgl_kembali }}</td>
                                        <td>{{ $peminjamanalat->status }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a class="btn btn-outline-success p-1"
                                                    href="/peminjamanalat/{{ $peminjamanalat->id }}">
                                                    <i class="bx bx-info-circle"></i>
                                                </a>
                                                @if ($peminjamanalat->user_id == auth()->user()->id && $peminjamanalat->status == 'disetujui')
                                                    <form action="/peminjamanalat/{{ $peminjamanalat->id }}"
                                                        method="post">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="selesai">
                                                        <input type="hidden" name="tgl_kembali"
                                                            value="{{ Date('Y-m-d H:i:s') }}">
                                                        <button type="submit" class="btn btn-outline-primary p-1"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-title="Kembalikan">
                                                            <i class='bx bx-arrow-to-left'></i> </button>
                                                    </form>
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
                                                    Tidak Ada Data peminjamanalat
                                                </h3>
                                            </div>
                                        </td>
                                    </tr> --}}
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- <div class="d-flex align-items-center justify-content-end mt-4 mb-0">
                    {{ $peminjamanalats->links() }}
                </div> --}}
            </div>
        </div>
        <!--/ Bordered Table -->
    </div>
@endsection
