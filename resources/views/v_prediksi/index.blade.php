@extends('layout.main')
@section('container')
    <!-- Bordered Table -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Home /</a>
                Pengajuan Bahan /
            </span>
            <span class="text-primary">
                Prediksi Pengajuan
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
                <h5 class="mb-0">Kelola Prediksi Pengajuan</h5>
                <small class="text-muted float-end">
                    <a href="/prediksi/create"><button class="btn btn-primary">Tambah</button></a>
                </small>
            </div>
            <div class="card-body pb-2">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered" id="myTable">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 0">#</th>
                                <th>Nama Bahan</th>
                                <th class="text-wrap">Pengajuan</th>
                                <th class="text-wrap">Harga</th>
                                <th>Label</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="text-center">
                                <th style="width: 0">#</th>
                                <th>Nama Bahan</th>
                                <th class="text-wrap">Pengajuan</th>
                                <th class="text-wrap">Harga</th>
                                <th>Label</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody class="text-center">
                            @foreach ($prediksis as $prediksi)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-wrap">{{ $prediksi->nama }}</td>
                                    <td class="text-wrap">
                                        @if ($prediksi->pengajuan == 'lebih')
                                            Melebihi Kuota
                                        @elseif ($prediksi->pengajuan == 'pas')
                                            Sesuai Kuota
                                        @else
                                            Kurang dari Kuota
                                        @endif
                                        <br>
                                        <b>Jumlah Pengajuan</b>: {{ $prediksi->jml_pengajuan }} <br>
                                        <b>Jumlah Matkul</b>: {{ $prediksi->jml_matkul }} <br>
                                        <b>Jumlah Siswa</b>: {{ $prediksi->jml_siswa }} <br>
                                        <b>Jumlah Kelas</b>: {{ $prediksi->jml_kelas }} <br>
                                    </td>
                                    <td class="text-wrap">
                                        {{ $prediksi->harga }} <br>
                                        <b>Harga Barang</b>: {{ $prediksi->harga_barang }} <br>
                                        <b>Harga Termurah</b>: {{ $prediksi->harga_termurah }} <br>
                                        <b>Harga Termahal</b>: {{ $prediksi->harga_termahal }} <br>
                                    </td>
                                    <td class="text-wrap">{{ $prediksi->label }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a class="btn btn-outline-success p-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-title="Lihat"
                                                href="/prediksi/{{ $prediksi->id }}"><i class="bx bx-info-circle"></i></a>
                                            @if (auth()->user()->id == $prediksi->user_id)
                                                <button type="button" class="btn btn-outline-danger p-1"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#exampleModal{{ $prediksi->id }}">
                                                    <i class="bx bx-trash" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-title="Hapus"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <div class="modal fade" id="exampleModal{{ $prediksi->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda Yakin Ingin Menghapus Data {{ $prediksi->nama }}?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Tidak</button>
                                                {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                                                <form action="/prediksi/{{ $prediksi->id }}" method="post">
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
                {{-- <div class="d-flex align-items-center justify-content-end mt-4 mb-0">
                    {{ $prediksis->links() }}
                </div> --}}
            </div>
        </div>
        <!--/ Bordered Table -->
    </div>
@endsection
