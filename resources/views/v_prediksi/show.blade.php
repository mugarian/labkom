@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">
                <a href="/prediksi" class="text-secondary">Data Prediksi</a>/
            </span> {{ $prediksi->nama }}
        </h4>

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
                        <h5 class="mb-0">Riwayat Prediksi</h5>
                        <small class="text-muted float-end"><a href="/prediksi">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="nama">nama</label>
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
                                    <form action="/prediksi/{{ $prediksi->id }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger"
                                            onclick="if (confirm('Hapus Data')) return true; return false">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
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
