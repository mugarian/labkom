@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="/bahanjurusan" class="text-secondary">Data
                    Bahan jurusan</a>
                /
            </span> {{ $bahanjurusan->bahanpraktikum->nama }}</h4>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Bahan jurusan</h5>
                        <small class="text-muted float-end"><a href="/bahanjurusan">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="alert alert-primary">
                                <h6 class="alert-heading fw-bold mb-1">Pemberitahuan</h6>
                                <p class="mb-0">Bahan jurusan mempunyai relasi ke bahan praktikum karena jika bahan
                                    praktikum habis atau berkurang, maka data yang berkurang berpindah ke bahan jurusan
                                    menjadi bertambah
                                </p>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex align-items-center align-items-sm-center justify-content-center gap-4">
                                {{ $qrcode }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kode">kode</label>
                            <p class="form-control">{{ $bahanjurusan->kode }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="stok">stok</label>
                            <p class="form-control">{{ $bahanjurusan->stok }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="stok">Laboratorium</label>
                            <p class="form-control">{{ $bahanjurusan->laboratorium->nama }}</p>
                        </div>
                        <div class="mb-3">
                            @if (auth()->user()->role == 'admin')
                                <div class="d-flex justify-content-start">
                                    <a href="/bahanjurusan/{{ $bahanjurusan->id }}/edit"
                                        class="btn btn-outline-warning me-3">Edit</a>
                                    <form action="/bahanjurusan/{{ $bahanjurusan->id }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger"
                                            onclick="if (confirm('Hapus Data')) return true; return false">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            @endif
                            @if (auth()->user()->role != 'admin')
                                <a href="/peminjamanbahan/{{ $bahanjurusan->id }}/pinjam"
                                    class="btn btn-outline-primary mx-1">Pinjam</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Bahan Praktikum</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex align-items-center align-items-sm-center justify-content-center gap-4">
                                @if ($bahanjurusan->foto)
                                    <img src="{{ asset('storage') . '/' . $bahanjurusan->foto }}" alt="bahanjurusan-avatar"
                                        class="d-block rounded" height="200" width="200" id="uploadedAvatar" />
                                @else
                                    <img src="{{ asset('img') }}/unknown.png" alt="user-avatar" class="d-block rounded"
                                        height="200" width="200" id="uploadedAvatar" />
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama</label>
                            <p class="form-control">{{ $bahanjurusan->bahanpraktikum->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="merk">Merk</label>
                            <p class="form-control">{{ $bahanjurusan->bahanpraktikum->merk }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="spesifikasi">Spesifikasi</label>
                            <p class="form-control">{{ $bahanjurusan->bahanpraktikum->spesifikasi }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="harga">Harga</label>
                            <p class="form-control">Rp.
                                {{ number_format($bahanjurusan->bahanpraktikum->harga, 2, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="row">
            <div class="col-xl">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Tracking Barang Habis (bahanjurusan)</h5>
                    </div>
                    <div class="card-body pb-2">
                        <div class="table-responsive text-nowrap">
                            <table class="table table-bordered" id="myTable">
                                <thead>
                                    <tr class="text-center">
                                        <th>Foto</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Lokasi</th>
                                        <th>Deskripsi</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr class="text-center">
                                        <th>Foto</th>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Lokasi</th>
                                        <th>Deskripsi</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </tfoot>
                                <tbody class="text-center">
                                    @foreach ($baranghabis as $bh)
                                        <tr>
                                            <td style="width:10%">
                                                @if ($bh->foto)
                                                    <img src="{{ asset('storage') . '/' . $bh->foto }}" alt="bh-avatar"
                                                        class="d-block rounded img-preview" height="100" width="100"
                                                        id="uploadedAvatar" />
                                                @else
                                                    <img src="{{ asset('img') }}/unknown.png" alt="user-avatar"
                                                        class="d-block rounded img-preview" height="100" width="100"
                                                        id="uploadedAvatar" />
                                                @endif
                                            </td>
                                            <td>{{ $bh->kode }}</td>
                                            <td class="text-wrap">{{ $bh->nama }}</td>
                                            <td class="text-wrap">{{ $bh->laboratorium->nama }}</td>
                                            <td class="text-wrap">{{ $bh->deskripsi }}</td>
                                            <td class="text-wrap">{{ $bh->keterangan }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        {{-- <div class="card mt-4">
            <div class="card-header">
                @if (auth()->user()->role == 'admin')
                    <div class="d-flex justify-content-start">
                        <a href="/bahanjurusan/{{ $bahanjurusan->id }}/edit" class="btn btn-outline-warning me-3">Edit</a>
                        <form action="/bahanjurusan/{{ $bahanjurusan->id }}" method="post">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-outline-danger">
                                Delete
                            </button>
                        </form>
                    </div>
                @endif
            </div>
            <div class="card-body">
                <div class="mb-3 col-12 mb-0">
                    <div class="alert alert-primary">
                        <h6 class="alert-heading fw-bold mb-1">Kelola Data bahanjurusan</h6>
                        <p class="mb-0">Ketika Form Tambah Data bahanjurusan dihapus atau diubah,<br />
                            Maka Secara Otomatis Kode QR akan dihapus atau terubah, <br />
                            Dan Langsung diseusaikan dengan kode qr yang tertera
                        </p>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
@endsection
