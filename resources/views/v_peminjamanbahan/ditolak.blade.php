@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Home /</a>
                Akun /
                <a href="/mahasiswa" class="text-secondary">Mahasiswa /</a>
                <a href="/mahasiswa/{{ $mahasiwa->id }}" class="text-secondary">Mahasiswa /</a>
            </span>
            <span class="text-primary">
                {{ $mahasiswa->user->nama }}
            </span>
        </h5>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">peminjaman bahan</h5>
                        <small class="text-muted float-end"><a href="/peminjamanbahan">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <form action="/peminjamanbahan/{{ $peminjamanbahan->id }}/ditolak" method="POST">
                            @csrf
                            <div class="mb-3">
                                <div class="alert alert-primary">
                                    <h6 class="alert-heading fw-bold mb-1">Status Ditolak</h6>
                                    <p class="mb-0">
                                        Masukkan Komentar atau keterangan untuk memberitahukan alasan penolakan kegiatan
                                    </p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="status">Status</label>
                                <input type="text" class="form-control @error('status') is-invalid @enderror"
                                    id="status" placeholder="status" value="ditolak" name="status" required readonly />
                                @error('status')
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
                            <div class="mb-3">
                                <label class="form-label" for="bahanjurusan_id">Kode Bahan Jurusan</label>
                                <input type="text" class="form-control @error('bahanjurusan_id') is-invalid @enderror"
                                    id="bahanjurusan_id" placeholder="bahanjurusan_id"
                                    value="{{ old('bahanjurusan_id', $peminjamanbahan->bahanjurusan->kode) }}"
                                    name="bahanjurusan_id" required readonly />
                                @error('bahanjurusan_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="deskripsi">deskripsi</label>
                                <textarea id="deskripsi" class="form-control @error('deskripsi')
                                is-invalid @enderror"
                                    placeholder="deskripsi" name="deskripsi" required readonly>{{ old('deskripsi', $peminjamanbahan->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="tgl_pinjam">Tanggal Peminajaman</label>
                                <input type="text" class="form-control @error('tgl_pinjam') is-invalid @enderror"
                                    id="tgl_pinjam" placeholder="kode kegiatan"
                                    value="{{ old('tgl_pinjam', $peminjamanbahan->tgl_pinjam) }}" name="tgl_pinjam"
                                    required readonly />
                                @error('tgl_pinjam')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="tgl_kembali">Tanggal Pengembalian</label>
                                <input type="text" class="form-control @error('tgl_kembali') is-invalid @enderror"
                                    id="tgl_kembali" placeholder="kode kegiatan"
                                    value="{{ old('tgl_kembali', $peminjamanbahan->tgl_kembali) }}" name="tgl_kembali"
                                    required readonly />
                                @error('tgl_kembali')
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
                    <h5 class="mb-0">Bahan Jurusan</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex align-items-center align-items-sm-center justify-content-center gap-4">
                            @if ($peminjamanbahan->bahanjurusan->foto)
                                <img src="{{ asset('storage') . '/' . $peminjamanbahan->bahanjurusan->bahanpraktikum->foto }}"
                                    alt="peminjamanbahan-avatar" class="d-block rounded" height="200" width="200"
                                    id="uploadedAvatar" />
                            @else
                                <img src="{{ asset('img') }}/unknown.png" alt="user-avatar" class="d-block rounded"
                                    height="200" width="200" id="uploadedAvatar" />
                            @endif
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="kode">Kode bahan jurusan</label>
                        <p class="form-control">{{ $peminjamanbahan->bahanjurusan->kode }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="nama">nama bahan jurusan</label>
                        <p class="form-control">{{ $peminjamanbahan->bahanjurusan->bahanpraktikum->nama }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="merk">Merk bahan jurusan</label>
                        <p class="form-control">{{ $peminjamanbahan->bahanjurusan->bahanpraktikum->merk }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="spesifikasi">spesifikasi bahan jurusan</label>
                        <p class="form-control">{{ $peminjamanbahan->bahanjurusan->bahanpraktikum->spesifikasi }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="card">
        <div class="card-header">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
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
