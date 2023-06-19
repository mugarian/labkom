@extends('layout.main')
@section('container')
    <!-- Bordered Table -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">Data Peminjaman bahan
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
                <h5 class="mb-0">Kelola Peminjaman bahan</h5>
                <div class="d-flex justify-content-end ">
                    @if (auth()->user()->role != 'admin')
                        {{-- @if ($selesai) --}}
                        <small class="text-muted float-end">
                            <a href="/peminjamanbahan/create">
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
                                <th>Bahan Jurusan</th>
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
                                <th>Bahan Jurusan</th>
                                <th>Oleh</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody class="text-center">
                            @foreach ($peminjamanbahans as $peminjamanbahan)
                                @if ($kalab)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-wrap">{{ $peminjamanbahan->namabahanjurusan }} <br>
                                            ({{ $peminjamanbahan->namalab }})
                                        </td>
                                        <td class="text-wrap">{{ $peminjamanbahan->namauser }}</td>
                                        <td>
                                            @if ($peminjamanbahan->status == 'disetujui' || $peminjamanbahan->status == 'selesai')
                                                {{ $peminjamanbahan->tgl_pinjam }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $peminjamanbahan->tgl_kembali }}</td>
                                        <td>{{ $peminjamanbahan->status }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a class="btn btn-outline-success p-1" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-title="Lihat"
                                                    href="/peminjamanbahan/{{ $peminjamanbahan->id }}"><i
                                                        class="bx bx-info-circle"></i></a>
                                                @if ($peminjamanbahan->status == 'menunggu')
                                                    <form action="/peminjamanbahan/{{ $peminjamanbahan->id }}"
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
                                                        href="/peminjamanbahan/{{ $peminjamanbahan->id }}/ditolak">
                                                        <i class="bx bx-message-square-x"></i>
                                                    </a>
                                                @endif
                                                @if ($peminjamanbahan->user_id == auth()->user()->id && $peminjamanbahan->status == 'disetujui')
                                                    <form action="/peminjamanbahan/{{ $peminjamanbahan->id }}"
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
                                        <td class="text-wrap">{{ $peminjamanbahan->bahanjurusan->bahanpraktikum->nama }}
                                            <br>
                                            ({{ $peminjamanbahan->bahanjurusan->laboratorium->nama }})
                                        </td>
                                        <td class="text-wrap">{{ $peminjamanbahan->user->nama }}</td>
                                        <td>{{ $peminjamanbahan->tgl_pinjam }}</td>
                                        <td>{{ $peminjamanbahan->tgl_kembali }}</td>
                                        <td>{{ $peminjamanbahan->status }}</td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a class="btn btn-outline-success p-1"
                                                    href="/peminjamanbahan/{{ $peminjamanbahan->id }}">
                                                    <i class="bx bx-info-circle"></i>
                                                </a>
                                                @if ($peminjamanbahan->user_id == auth()->user()->id && $peminjamanbahan->status == 'disetujui')
                                                    <form action="/peminjamanbahan/{{ $peminjamanbahan->id }}"
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
                                                    Tidak Ada Data peminjamanbahan
                                                </h3>
                                            </div>
                                        </td>
                                    </tr> --}}
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- <div class="d-flex align-items-center justify-content-end mt-4 mb-0">
                    {{ $peminjamanbahans->links() }}
                </div> --}}
            </div>
        </div>
        <!--/ Bordered Table -->
    </div>
@endsection
