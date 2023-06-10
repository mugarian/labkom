@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">
                <a href="/peminjamanbahan" class="text-secondary">Data Peminjaman bahan</a> /
            </span>Tambah Data Peminjaman bahan
        </h4>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Peminjaman bahan</h5>
                        <small class="text-muted float-end"><a href="/peminjamanbahan">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <form action="/peminjamanbahan" method="POST">
                            @csrf
                            <div class="mb-3">
                                <div class="alert alert-primary">
                                    <h6 class="alert-heading fw-bold mb-1">Pemberitahuan</h6>
                                    <p class="mb-0">Masukkan kode barang pakai bahan yang tertera. peminjaman bahan bisa
                                        dilakukan dengan cara memindai QR Kode yang tertera pada barang untuk pengisian kode
                                        barang secara otomatis
                                    </p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <label class="form-label" for="bahanjurusan_id">Kode Bahan Jurusan</label>
                                <input type="text" class="form-control @error('bahanjurusan_id') is-invalid @enderror"
                                    id="bahanjurusan_id" placeholder="Kode bahan" value="{{ old('bahanjurusan_id') }}"
                                    name="bahanjurusan_id" required />
                                @error('bahanjurusan_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="deskripsi">Deskripsi</label>
                                <textarea id="deskripsi" class="form-control @error('deskripsi')
                                is-invalid @enderror"
                                    placeholder="deskripsi" name="deskripsi" required>{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="jenis">Jenis peminjaman bahan (jurusan MI)</label>
                                <input type="text" class="form-control @error('jenis') is-invalid @enderror"
                                    id="jenis" placeholder="jenis" value="{{ old('jenis', $jenis) }}" name="jenis"
                                    required readonly />
                                @error('jenis')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Pinjam</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Perhatian</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="alert alert-primary">
                            <h6 class="alert-heading fw-bold mb-1">Status Kegiatan</h6>
                            <p class="mb-0">
                                peminjaman bahan bisa dilakukan ketika status sudah disetujui oleh Kepala Lab
                            </p>
                        </div>
                    </div>
                </div>
            </div>
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
                    <h6 class="alert-heading fw-bold mb-1">peminjamanbahan Data peminjamanbahan</h6>
                    <p class="mb-0">Ketika Form Tambah Data peminjamanbahan ditambahkan,<br />
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
