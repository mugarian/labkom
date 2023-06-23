@extends('layout.main')
@section('container')
    <!-- Bordered Table -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Home /</a>
                Invetori /
            </span>
            <span class="text-primary">
                Alat
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
                <h5 class="mb-0">Kelola Alat</h5>
                @if (auth()->user()->role == 'admin')
                    <small class="text-muted float-end">
                        <a href="/alat/create"><button class="btn btn-primary">Tambah</button></a>
                    </small>
                @endif
            </div>
            <div class="card-body pb-2">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered" id="myTable">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 0">No</th>
                                <th>Foto</th>
                                <th>Nama Barang</th>
                                <th>Merk</th>
                                @if (auth()->user()->role == 'admin')
                                    <th>Jumlah Harga</th>
                                @endif
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="text-center">
                                <th style="width: 0">No</th>
                                <th>Foto</th>
                                <th>Nama Barang</th>
                                <th>Merk</th>
                                @if (auth()->user()->role == 'admin')
                                    <th>Jumlah Harga</th>
                                @endif
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody class="text-center">
                            @foreach ($alats as $alat)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td style="width:10%">
                                        @if ($alat->foto)
                                            <img src="{{ asset('storage') . '/' . $alat->foto }}" alt="alat-avatar"
                                                class="d-block rounded img-preview" height="100" width="100"
                                                id="uploadedAvatar" />
                                        @else
                                            <img src="{{ asset('img') }}/unknown.png" alt="user-avatar"
                                                class="d-block rounded img-preview" height="100" width="100"
                                                id="uploadedAvatar" />
                                        @endif
                                    </td>
                                    <td class="text-wrap">{{ $alat->nama }}</td>
                                    <td class="text-wrap">{{ $alat->merk }}</td>
                                    @if (auth()->user()->role == 'admin')
                                        <td class="text-wrap">Rp.
                                            @foreach ($jumlahharga as $jh)
                                                @if ($jh->alat_id == $alat->id)
                                                    {{ number_format($jh->jumlah, 2, ',', '.') }}
                                                @endif
                                            @endforeach
                                        </td>
                                    @endif
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a class="btn btn-outline-success p-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-title="Lihat"
                                                href="/alat/{{ $alat->id }}"><i class="bx bx-info-circle"></i></a>
                                            @if (auth()->user()->role == 'admin')
                                                <a class="btn btn-outline-warning p-1" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-title="Ubah"
                                                    href="/alat/{{ $alat->id }}/edit">
                                                    <i class="bx bx-edit-alt"></i>
                                                </a>
                                                <button type="button" class="btn btn-outline-danger p-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal{{ $alat->id }}">
                                                    <i class="bx bx-trash" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-title="Hapus"></i>
                                                </button>
                                                {{-- <form action="/alat/{{ $alat->id }}" method="post">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-title="Hapus" class="btn btn-outline-danger p-1"
                                                        onclick="if (confirm('Hapus Data')) return true; return false">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </form> --}}
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" id="exampleModal{{ $alat->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-wrap">
                                                Apakah anda yakin ingin Menghapus Data {{ $alat->nama }}?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tidak</button>
                                                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                                                <form action="/alat/{{ $alat->id }}" method="post">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary">
                                                        Ya
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p class="mb-0">Total Harga: {{ $total }}</p>
                {{-- <div class="d-flex align-items-center justify-content-end mt-4 mb-0">
                    {{ $alats->links() }}
                </div> --}}

            </div>
        </div>
        <!--/ Bordered Table -->
    </div>
@endsection
