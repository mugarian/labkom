@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Beranda /</a>
                Logbook /
                <a href="/peminjamanalat" class="text-secondary">Peminjaman Alat /</a>
                <a href="/peminjamanalat/{{ $peminjamanalat->id }}"
                    class="text-secondary">{{ $peminjamanalat->barangpakai->nama }} /</a>
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
                        <small class="text-muted float-end"><a href="/peminjamanalat">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <form action="/peminjamanalat/{{ $peminjamanalat->id }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <div class="alert alert-primary">
                                    <h6 class="alert-heading fw-bold mb-1">Pemberitahuan</h6>
                                    <p class="mb-0">Untuk menyelesaikan Peminjaman Alat Laboratorium, silahkan isi kolom
                                        kolom berikut untuk mengetahui kondisi layak pakai barang pakai
                                    </p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="barangpakai_id">Kode barangpakai</label>
                                <input type="text" class="form-control @error('barangpakai_id') is-invalid @enderror"
                                    id="barangpakai_id" placeholder="barangpakai_id"
                                    value="{{ old('barangpakai_id', $peminjamanalat->barangpakai->kode) }}"
                                    name="barangpakai_id" required readonly />
                                @error('barangpakai_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="deksripsi">Deskripsi</label>
                                <input type="text" class="form-control @error('deksripsi') is-invalid @enderror"
                                    id="deksripsi" placeholder="kode kegiatan"
                                    value="{{ old('deksripsi', $peminjamanalat->deskripsi) }}" name="deksripsi" required
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
                                    value="{{ old('tgl_pinjam', $peminjamanalat->tgl_pinjam) }}" name="tgl_pinjam" required
                                    readonly />
                                @error('tgl_pinjam')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="rencana_tgl_kembali">Rencana Tanggal Pengembalian</label>
                                <input type="text"
                                    class="form-control @error('rencana_tgl_kembali') is-invalid @enderror"
                                    id="rencana_tgl_kembali" placeholder="kode kegiatan"
                                    value="{{ old('rencana_tgl_kembali', $peminjamanalat->rencana_tgl_kembali) }}"
                                    name="rencana_tgl_kembali" required readonly />
                                @error('rencana_tgl_kembali')
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
                            @if ($peminjamanalat->barangpakai->alat->kategori == 'pc')
                                <div class="mb-3">
                                    <label class="form-label" for="cpu">CPU</label>
                                    <select id="organization" class="select2 form-select @error('cpu') is-invalid @enderror"
                                        name="cpu">
                                        <option value="">Pilih Kondisi</option>
                                        <option value="berfungsi" @selected(old('cpu') == 'berfungsi')>
                                            Berfungsi
                                        </option>
                                        <option value="tidak berfungsi" @selected(old('cpu') == 'tidak berfungsi')>
                                            Tidak Berfungsi
                                        </option>
                                    </select>
                                    @error('cpu')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="monitor">Monitor</label>
                                    <select id="organization"
                                        class="select2 form-select @error('monitor') is-invalid @enderror" name="monitor">
                                        <option value="">Pilih Kondisi</option>
                                        <option value="berfungsi" @selected(old('monitor') == 'berfungsi')>
                                            Berfungsi
                                        </option>
                                        <option value="tidak berfungsi" @selected(old('monitor') == 'tidak berfungsi')>
                                            Tidak Berfungsi
                                        </option>
                                    </select>
                                    @error('monitor')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="keyboard">keyboard</label>
                                    <select id="organization"
                                        class="select2 form-select @error('keyboard') is-invalid @enderror"
                                        name="keyboard">
                                        <option value="">Pilih Kondisi</option>
                                        <option value="berfungsi" @selected(old('keyboard') == 'berfungsi')>
                                            Berfungsi
                                        </option>
                                        <option value="tidak berfungsi" @selected(old('keyboard') == 'tidak berfungsi')>
                                            Tidak Berfungsi
                                        </option>
                                    </select>
                                    @error('keyboard')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="mouse">mouse</label>
                                    <select id="organization"
                                        class="select2 form-select @error('mouse') is-invalid @enderror" name="mouse">
                                        <option value="">Pilih Kondisi</option>
                                        <option value="berfungsi" @selected(old('mouse') == 'berfungsi')>
                                            Berfungsi
                                        </option>
                                        <option value="tidak berfungsi" @selected(old('mouse') == 'tidak berfungsi')>
                                            Tidak Berfungsi
                                        </option>
                                    </select>
                                    @error('mouse')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            @endif
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
                        <h5 class="mb-0">Informasi Alat</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex align-items-center align-items-sm-center justify-content-center gap-4">
                                @if ($peminjamanalat->barangpakai->foto)
                                    <img src="{{ asset('storage') . '/' . $peminjamanalat->barangpakai->foto }}"
                                        alt="peminjamanalat-avatar" class="d-block rounded" height="200"
                                        width="200" id="uploadedAvatar" />
                                @else
                                    <img src="{{ asset('img') }}/unknown.png" alt="user-avatar" class="d-block rounded"
                                        height="200" width="200" id="uploadedAvatar" />
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kode">Kode barangpakai</label>
                            <p class="form-control">{{ $peminjamanalat->barangpakai->kode }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">nama barangpakai</label>
                            <p class="form-control">{{ $peminjamanalat->barangpakai->nama }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
