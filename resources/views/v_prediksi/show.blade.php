@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Home /</a>
                Pengajuan Bahan /
                <a href="/prediksi" class="text-secondary">Prediksi Pengajuan /</a>
            </span>
            <span class="text-primary">
                {{ $prediksi->nama }}
            </span>
        </h5>

        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Prediksi Pengajuan</h5>
                        <small class="text-muted float-end"><a href="/prediksi">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama Bahan</label>
                            <p class="form-control">{{ $prediksi->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jml_pengajuan">Jumlah Pengajuan</label>
                            <p class="form-control">{{ $prediksi->jml_pengajuan }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jml_matkul">Jumlah Matkul</label>
                            <p class="form-control">{{ $prediksi->jml_matkul }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jml_siswa">Jumlah Siswa</label>
                            <p class="form-control">{{ $prediksi->jml_siswa }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jml_kelas">Jumlah Kelas</label>
                            <p class="form-control">{{ $prediksi->jml_kelas }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="harga_barang">Harga Barang</label>
                            <p class="form-control">{{ $prediksi->harga_barang }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="harga_termurah">Harga Termurah</label>
                            <p class="form-control">{{ $prediksi->harga_termurah }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="harga_termahal">Harga Termahal</label>
                            <p class="form-control">{{ $prediksi->harga_termahal }}</p>
                        </div>
                        <div class="mb-3">
                            @if (auth()->user()->id == $prediksi->user_id)
                                <div class="d-flex justify-content-start">
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal{{ $prediksi->id }}">
                                        Delete
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="exampleModal{{ $prediksi->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-wrap">
                            Apakah Anda Yakin Ingin Menghapus Data {{ $prediksi->nama }}?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
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
        </div>
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Keterangan Prediksi</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="pengajuan">Kategori Pengajuan</label>
                            <p class="form-control">
                                @if ($prediksi->pengajuan == 'lebih')
                                    Melebihi Kuota
                                @elseif ($prediksi->pengajuan == 'pas')
                                    Sesuai Kuota
                                @else
                                    Kurang dari Kuota
                                @endif
                            </p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="harga">Kategori Harga</label>
                            <p class="form-control">{{ $prediksi->harga }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="label">Label</label>
                            <p class="form-control">{{ $prediksi->label }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="Riwayat">Riwayat Prediksi</label>
                            <p class="form-control">{{ $prediksi->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="Riwayat">Oleh</label>
                            <p class="form-control">{{ $prediksi->user->nama }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
