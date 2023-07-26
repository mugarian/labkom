@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Beranda /</a>
                Logbook /
                <a href="/peminjamanbahan" class="text-secondary">Peminjaman Bahan Jurusan/</a>
                <a href="/peminjamanbahan/{{ $peminjamanbahan->id }}"
                    class="text-secondary">{{ $peminjamanbahan->bahanjurusan->nama }} /</a>
            </span>
            <span class="text-primary">
                Cek Kondisi
            </span>
        </h5>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Kondisi Peminjaman Alat</h5>
                        <small class="text-muted float-end"><a href="/peminjamanbahan">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <form action="/peminjamanbahan/{{ $peminjamanbahan->id }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <div class="alert alert-primary">
                                    <h6 class="alert-heading fw-bold mb-1">Pemberitahuan</h6>
                                    <p class="mb-0">Untuk menyelesaikan Peminjaman bahan laboratorium, silahkan isi kolom
                                        kolom berikut untuk mengetahui kondisi layak pakai bahan jurusan
                                    </p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="bahanjurusan_id">Kode bahan jurusan</label>
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
                                <label class="form-label" for="deksripsi">Deskripsi</label>
                                <input type="text" class="form-control @error('deksripsi') is-invalid @enderror"
                                    id="deksripsi" placeholder="kode kegiatan"
                                    value="{{ old('deksripsi', $peminjamanbahan->deskripsi) }}" name="deksripsi" required
                                    readonly />
                                @error('deksripsi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="tgl_pinjam">Tanggal peminjaman</label>
                                <input type="text" class="form-control @error('tgl_pinjam') is-invalid @enderror"
                                    id="tgl_pinjam" placeholder="kode kegiatan"
                                    value="{{ old('tgl_pinjam', $peminjamanbahan->tgl_pinjam) }}" name="tgl_pinjam" required
                                    readonly />
                                @error('tgl_pinjam')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="bukti">Bukti Pengembalian</label>
                                <div class="">
                                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                                        <img src="{{ asset('img') }}/unknown.png" alt="user-avatar"
                                            class="d-block rounded img-preview" height="100" width="100"
                                            id="uploadedAvatar" />
                                        <div class="button-wrapper">
                                            <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                                <span class="d-none d-sm-block">
                                                    Unggah Foto
                                                </span>
                                                <i class="bx bx-upload d-block d-sm-none"></i>
                                                <input type="file" id="upload" name="upload"
                                                    class="account-file-input @error('upload') is-invalid @enderror" hidden
                                                    accept="image/png, image/jpeg" onchange="previewImage()" />
                                                @error('upload')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </label>

                                            <p class="text-muted mb-0">Hanya JPG atau PNG. Maksimal ukuran of 8MB</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="kondisi">Kondisi Keterangan</label>
                                <textarea id="kondisi" class="form-control @error('kondisi')
                                is-invalid @enderror"
                                    placeholder="kondisi" name="kondisi" required>{{ old('kondisi') }}</textarea>
                                @error('kondisi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Informais Bahan Jurusan</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex align-items-center align-items-sm-center justify-content-center gap-4">
                                @if ($peminjamanbahan->bahanjurusan->foto)
                                    <img src="{{ asset('storage') . '/' . $peminjamanbahan->bahanjurusan->foto }}"
                                        alt="peminjamanbahan-avatar" class="d-block rounded" height="200"
                                        width="200" id="uploadedAvatar" />
                                @else
                                    <img src="{{ asset('img') }}/unknown.png" alt="user-avatar" class="d-block rounded"
                                        height="200" width="200" id="uploadedAvatar" />
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kode">Kode bahanjurusan</label>
                            <p class="form-control">{{ $peminjamanbahan->bahanjurusan->kode }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">nama bahanjurusan</label>
                            <p class="form-control">{{ $peminjamanbahan->bahanjurusan->bahanpraktikum->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">stok bahanjurusan</label>
                            <p class="form-control">{{ $peminjamanbahan->bahanjurusan->stok }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="card">
            <div class="card-header">
                <button type="submit" class="btn btn-primary">Selesai</button>
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
        function previewImage() {
            const upload = document.querySelector('#upload');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(upload.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>
@endsection
