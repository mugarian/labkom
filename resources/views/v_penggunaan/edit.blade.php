@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">
                <a href="/penggunaan" class="text-secondary">Data Penggunaan</a> /
                <a href="/penggunaan/{{ $penggunaan->id }}" class="text-secondary">{{ $penggunaan->baranghabis->nama }}</a> /
            </span> Menolak Penggunaan
        </h4>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Penggunaan</h5>
                        <small class="text-muted float-end"><a href="/penggunaan">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <form action="/penggunaan/{{ $penggunaan->id }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <div class="alert alert-primary">
                                    <h6 class="alert-heading fw-bold mb-1">Status Ditolak</h6>
                                    <p class="mb-0">
                                        Masukkan Komentar atau keterangan untuk memberitahukan alasan penolakan kegiatan
                                    </p>
                                </div>
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
                            <div class="mb-3">
                                <label class="form-label" for="baranghabis_id">Kode Barang</label>
                                <input type="text" class="form-control @error('baranghabis_id') is-invalid @enderror"
                                    id="baranghabis_id" placeholder="baranghabis_id"
                                    value="{{ old('baranghabis_id', $penggunaan->baranghabis->kode) }}"
                                    name="baranghabis_id" required readonly />
                                @error('baranghabis_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="kegiatan_id">Kode Kegiatan</label>
                                <input type="text" class="form-control @error('kegiatan_id') is-invalid @enderror"
                                    id="kegiatan_id" placeholder="kode kegiatan"
                                    value="{{ old('kegiatan_id', $penggunaan->kegiatan->kode) }}" name="kegiatan_id"
                                    required readonly />
                                @error('kegiatan_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="tanggal">tanggal Kegiatan</label>
                                <input type="text" class="form-control @error('tanggal') is-invalid @enderror"
                                    id="tanggal" placeholder="kode kegiatan"
                                    value="{{ old('tanggal', $penggunaan->tanggal) }}" name="tanggal" required readonly />
                                @error('tanggal')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Selesai</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Barang</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex align-items-center align-items-sm-center justify-content-center gap-4">
                            @if ($penggunaan->baranghabis->foto)
                                <img src="{{ asset('storage') . '/' . $penggunaan->foto }}" alt="penggunaan-avatar"
                                    class="d-block rounded" height="200" width="200" id="uploadedAvatar" />
                            @else
                                <img src="{{ asset('img') }}/unknown.png" alt="user-avatar" class="d-block rounded"
                                    height="200" width="200" id="uploadedAvatar" />
                            @endif
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="kode">Kode Barang</label>
                        <p class="form-control">{{ $penggunaan->baranghabis->kode }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="nama">nama Barang</label>
                        <p class="form-control">{{ $penggunaan->baranghabis->nama }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="keterangan">keterangan Barang</label>
                        <p class="form-control">{{ $penggunaan->baranghabis->keterangan }}</p>
                    </div>
                    <div class="mt-5 mb-3">
                        <h5 class="mb-0">Kegiatan</h5>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="kode">kode kegiatan</label>
                        <p class="form-control">{{ $penggunaan->kegiatan->kode }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="jenis">jenis kegiatan</label>
                        <p class="form-control">{{ $penggunaan->kegiatan->jenis }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="nama">Oleh</label>
                        <p class="form-control">{{ $penggunaan->kegiatan->user->nama }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="nama">nama kegiatan</label>
                        <p class="form-control">{{ $penggunaan->kegiatan->nama }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="deskripsi">deskripsi kegiatan</label>
                        <p class="form-control">{{ $penggunaan->kegiatan->deskripsi }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="tanggal">Tanggal Mulai</label>
                        <p class="form-control">{{ $penggunaan->kegiatan->mulai }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <button type="submit" class="btn btn-primary">Selesai</button>
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
        function padTo2Digits(num) {
            return num.toString().padStart(2, '0');
        }

        function formatDate(date) {
            return (
                [
                    date.getFullYear(),
                    padTo2Digits(date.getMonth() + 1),
                    padTo2Digits(date.getDate()),
                ].join('-') +
                ' ' + [
                    padTo2Digits(date.getHours()),
                    padTo2Digits(date.getMinutes()),
                    padTo2Digits(date.getSeconds()),
                ].join(':')
            );
        }

        function showDate() {
            document.getElementById("selesai").value = formatDate(new Date());
        }

        setInterval(showDate, 1000);
    </script>
@endsection
