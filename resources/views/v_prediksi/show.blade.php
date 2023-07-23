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
                {{ $prediksi->datamentah->nama }}
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
                            <label class="form-label" for="nama">nama</label>
                            <p class="form-control">{{ $prediksi->datamentah->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kategori">kategori</label>
                            <p class="form-control">{{ $prediksi->datamentah->kategori }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="satuan">satuan</label>
                            <p class="form-control">{{ $prediksi->datamentah->satuan }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tahun_pengadaan">tahun pengadaan</label>
                            <p class="form-control">{{ $prediksi->datamentah->tahun_pengadaan }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jumlah_pengadaan">jumlah pengadaan</label>
                            <p class="form-control">{{ $prediksi->datamentah->jumlah_pengadaan }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="isi_barang_persatuan">Isi barang persatuan</label>
                            <p class="form-control">{{ $prediksi->datamentah->isi_barang_persatuan }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jumlah_barang_perpcs">Jumlah Barang Per PCS</label>
                            <p class="form-control">{{ $prediksi->datamentah->jumlah_barang_perpcs }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jumlah_matkul">Jumlah Matkul</label>
                            <p class="form-control">{{ $prediksi->datamentah->jumlah_matkul }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jumlah_siswa_perkelas">Jumlah Siswa Per Kelas</label>
                            <p class="form-control">{{ $prediksi->datamentah->jumlah_siswa_perkelas }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jumlah_kelas">Jumlah Kelas</label>
                            <p class="form-control">{{ $prediksi->datamentah->jumlah_kelas }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jenis_pemegang_barang">Jenis Pemegang Barang</label>
                            <p class="form-control">{{ $prediksi->datamentah->jenis_pemegang_barang }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jumlah_pemegang_barang">Jumlah Pemegang Barang</label>
                            <p class="form-control">{{ $prediksi->datamentah->jumlah_pemegang_barang }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jumlah_kebutuhan_total">Jumlah Kebutuhan Total</label>
                            <p class="form-control">{{ $prediksi->datamentah->jumlah_kebutuhan_total }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="harga_barang_beli">Harga Barang Beli</label>
                            <p class="form-control">{{ $prediksi->datamentah->harga_barang_beli }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="stok_barang">Stok Barang</label>
                            <p class="form-control">{{ $prediksi->datamentah->stok_barang }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jenis_bahan">Jenis Bahan</label>
                            <p class="form-control">{{ $prediksi->datamentah->jenis_bahan }}</p>
                        </div>
                        <div class="mb-3">
                            @if (auth()->user()->id == $prediksi->datamentah->user_id)
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
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-wrap">
                            Apakah Anda Yakin Ingin Menghapus Data {{ $prediksi->datamentah->nama }}?
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
                            <label class="form-label" for="jenis_pengadaan">Jenis Pengadaan</label>
                            <p class="form-control">{{ $prediksi->jenis_pengadaan }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jenis_harga">Jenis Harga</label>
                            <p class="form-control">{{ $prediksi->jenis_harga }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jenis_stok">Jenis Stok</label>
                            <p class="form-control">{{ $prediksi->jenis_stok }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="label">Label</label>
                            <p class="form-control">{{ $prediksi->datamentah->label }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="Riwayat">Riwayat Prediksi</label>
                            <p class="form-control">{{ $prediksi->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="Riwayat">Oleh</label>
                            <p class="form-control">{{ $prediksi->datamentah->user->nama }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
