@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Home /</a>
                Logbook /
                <a href="/penggunaan" class="text-secondary">Penggunaan Bahan /</a>
            </span>
            <span class="text-primary">
                Tambah
            </span>
        </h5>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Tambah Penggunaan</h5>
                        <small class="text-muted float-end"><a href="/penggunaan">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <form action="/penggunaan" method="POST">
                            @csrf
                            <div class="mb-3">
                                <div class="alert alert-primary">
                                    <h6 class="alert-heading fw-bold mb-1">Pemberitahuan</h6>
                                    <p class="mb-0">Masukkan kode bahan praktikum yang terdapat di laboratorium pada
                                        kegiatan yang dimaksud. Selanjutnya masukan kode kegiatan yang sedang berlangsung
                                        atau berstatus disetujui. Pemakaian Barang bisa dilakukan dengan cara memindai QR
                                        Kode yang tertera pada barang untuk pengisian kode barang secara otomatis.
                                        Penggunaan Bahan Praktikum bisa dilakukan ketika status sudah disetujui oleh Kepala
                                        Lab
                                    </p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <label class="form-label" for="bahanpraktikum_id">Kode Bahan Praktikum</label>
                                <input type="text" class="form-control @error('bahanpraktikum_id') is-invalid @enderror"
                                    id="bahanpraktikum_id" placeholder="bahanpraktikum_id"
                                    value="{{ old('bahanpraktikum_id', $bahanpraktikum->kode) }}" name="bahanpraktikum_id"
                                    required readonly />
                                @error('bahanpraktikum_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="kegiatan_id">Kode Kegiatan</label>
                                <input type="text" class="form-control @error('kegiatan_id') is-invalid @enderror"
                                    id="kegiatan_id" placeholder="kode kegiatan" value="{{ old('kegiatan_id') }}"
                                    name="kegiatan_id" required />
                                @error('kegiatan_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="deskripsi">Deskripsi</label>
                                <input type="text" class="form-control @error('deskripsi') is-invalid @enderror"
                                    id="deskripsi" placeholder="Deskripsi" value="{{ old('deskripsi') }}" name="deskripsi"
                                    required />
                                @error('deskripsi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="jumlah">Jumlah Bahan Praktikum</label>
                                <input type="number" class="form-control @error('jumlah') is-invalid @enderror"
                                    id="jumlah" placeholder="jumlah" value="{{ old('jumlah') }}" name="jumlah"
                                    min="0" max="{{ $bahanpraktikum->stok }}" required />
                                @error('jumlah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Gunakan</button>
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
                    <h5 class="mb-0">Informasi Bahan Jurusan</h5>
                </div>
                <div class="card-body">
                    @if ($bahanpraktikum)
                        <div class="mb-3">
                            <div class="d-flex align-items-center align-items-sm-center justify-content-center gap-4">
                                @if ($bahanpraktikum->foto)
                                    <img src="{{ asset('storage') . '/' . $bahanpraktikum->foto }}" alt="pemakaian-avatar"
                                        class="d-block rounded" height="200" width="200" id="uploadedAvatar" />
                                @else
                                    <img src="{{ asset('img') }}/unknown.png" alt="user-avatar" class="d-block rounded"
                                        height="200" width="200" id="uploadedAvatar" />
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jenis">jenis Bahan Praktikum</label>
                            <p class="form-control">{{ $bahanpraktikum->jenis }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kode">Kode Bahan Praktikum</label>
                            <p class="form-control">{{ $bahanpraktikum->kode }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama Bahan Praktikum</label>
                            <p class="form-control">{{ $bahanpraktikum->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="laboratorium">Lokasi</label>
                            <p class="form-control">{{ $bahanpraktikum->laboratorium->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="stok">Stok Bahan Praktikum</label>
                            <p class="form-control">{{ $bahanpraktikum->stok }}</p>
                        </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    {{-- <div class="card">
        <div class="card-header">
            <button type="submit" class="btn btn-primary">Tambah</button>
            </form>
        </div>
        <div class="card-body">
            <div class="mb-3 col-12 mb-0">
                <div class="alert alert-primary">
                    <h6 class="alert-heading fw-bold mb-1">penggunaan Data penggunaan</h6>
                    <p class="mb-0">Ketika Form Tambah Data penggunaan ditambahkan,<br />
                        Maka Secara Otomatis Kode QR akan menambahkan data Kode QR baru, <br />
                        Dan Langsung Disambungkan sesuai kode qr yang tertera
                    </p>
                </div>
            </div>
        </div>
    </div> --}}
    </div>
    <script>
        let currentDate = new Date().toISOString().slice(0, -8);
        console.log(currentDate);
        document.querySelector("#mulai").min = currentDate;
    </script>
@endsection
