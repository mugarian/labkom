@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Home /</a>
                Pengajuan Bahan /
                <a href="/training" class="text-secondary">Data Training /</a>
            </span>
            <span class="text-primary">
                {{ $training->datamentah->nama }}
            </span>
        </h5>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Data Training</h5>
                        <small class="text-muted float-end"><a href="/training">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="nama">nama</label>
                            <p class="form-control">{{ $training->datamentah->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kategori">kategori</label>
                            <p class="form-control">{{ $training->datamentah->kategori }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="satuan">satuan</label>
                            <p class="form-control">{{ $training->datamentah->satuan }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="tahun_pengadaan">tahun pengadaan</label>
                            <p class="form-control">{{ $training->datamentah->tahun_pengadaan }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jumlah_pengadaan">jumlah pengadaan</label>
                            <p class="form-control">{{ $training->datamentah->jumlah_pengadaan }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="isi_barang_persatuan">Isi barang persatuan</label>
                            <p class="form-control">{{ $training->datamentah->isi_barang_persatuan }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jumlah_barang_perpcs">Jumlah Barang Per PCS</label>
                            <p class="form-control">{{ $training->datamentah->jumlah_barang_perpcs }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jumlah_matkul">Jumlah Matkul</label>
                            <p class="form-control">{{ $training->datamentah->jumlah_matkul }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jumlah_siswa_perkelas">Jumlah Siswa Per Kelas</label>
                            <p class="form-control">{{ $training->datamentah->jumlah_siswa_perkelas }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jumlah_kelas">Jumlah Kelas</label>
                            <p class="form-control">{{ $training->datamentah->jumlah_kelas }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jenis_pemegang_barang">Jenis Pemegang Barang</label>
                            <p class="form-control">{{ $training->datamentah->jenis_pemegang_barang }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jumlah_pemegang_barang">Jumlah Pemegang Barang</label>
                            <p class="form-control">{{ $training->datamentah->jumlah_pemegang_barang }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jumlah_kebutuhan_total">Jumlah Kebutuhan Total</label>
                            <p class="form-control">{{ $training->datamentah->jumlah_kebutuhan_total }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="harga_barang_beli">Harga Barang Beli</label>
                            <p class="form-control">{{ $training->datamentah->harga_barang_beli }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="stok_barang">Stok Barang</label>
                            <p class="form-control">{{ $training->datamentah->stok_barang }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jenis_bahan">Jenis Bahan</label>
                            <p class="form-control">{{ $training->datamentah->jenis_bahan }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jenis_pengadaan">Jenis Pengadaan</label>
                            <p class="form-control">{{ $training->jenis_pengadaan }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jenis_harga">Jenis Harga</label>
                            <p class="form-control">{{ $training->jenis_harga }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jenis_stok">Jenis Stok</label>
                            <p class="form-control">{{ $training->jenis_stok }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="label">Label</label>
                            <p class="form-control">{{ $training->datamentah->label }}</p>
                        </div>
                        <div class="mb-3">
                            @if (auth()->user()->role == 'admin')
                                <div class="d-flex justify-content-start">
                                    <a href="/training/{{ $training->id }}/edit"
                                        class="btn btn-outline-warning me-3">Edit</a>
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal{{ $training->id }}">
                                        Delete
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal{{ $training->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-wrap">
                        Apakah Anda Yakin Ingin Menghapus Data {{ $training->datamentah->nama }}?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                        {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                        <form action="/training/{{ $training->datamentah->id }}" method="post">
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
@endsection
