@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">
                <a href="/penggunaan" class="text-secondary">penggunaan</a> /
            </span>Tambah Data penggunaan
        </h4>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">penggunaan</h5>
                        <small class="text-muted float-end"><a href="/penggunaan">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <form action="/penggunaan" method="POST">
                            @csrf
                            <div class="mb-3">
                                <div class="alert alert-primary">
                                    <h6 class="alert-heading fw-bold mb-1">Pemberitahuan</h6>
                                    <p class="mb-0">Masukkan kode barang yang telah tertera di barang secara manual,atau
                                        lakukan pemindaian kode qr untuk menambah data penggunaan secara otomatis.
                                        selanjutnya masukan kode kegiatan yang sedang berlangsung
                                    </p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <label class="form-label" for="baranghabis_id">Kode Barang</label>
                                <input type="text" class="form-control @error('baranghabis_id') is-invalid @enderror"
                                    id="baranghabis_id" placeholder="baranghabis_id"
                                    value="{{ old('baranghabis_id', $baranghabis->kode) }}" name="baranghabis_id" required
                                    readonly />
                                @error('baranghabis_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="kegiatan_id">Kode Kegiatan</label>
                                <input type="text" class="form-control @error('kegiatan_id') is-invalid @enderror"
                                    id="kegiatan_id" placeholder="kegiatan_id" value="{{ old('kegiatan_id') }}"
                                    name="kegiatan_id" required />
                                @error('kegiatan_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="jumlah">Jumlah Barang</label>
                                <input type="number" class="form-control @error('jumlah') is-invalid @enderror"
                                    id="jumlah" placeholder="jumlah" value="{{ old('jumlah') }}" name="jumlah"
                                    required />
                                @error('jumlah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="keterangan">keterangan</label>
                                <textarea id="keterangan" class="form-control @error('keterangan')
                                is-invalid @enderror"
                                    placeholder="keterangan" name="keterangan" required>{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                    </div>
                </div>
            </div>
            <div class="col-xl">
            </div>
        </div>

        <div class="card">
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
        </div>
    </div>
    <script>
        let currentDate = new Date().toISOString().slice(0, -8);
        console.log(currentDate);
        document.querySelector("#mulai").min = currentDate;
    </script>
@endsection
