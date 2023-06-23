@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Home /</a>
                Invetori /
                <a href="/bahanpraktikum" class="text-secondary">Bahan Praktikum /</a>
                <a href="/bahanpraktikum/{{ $bahanpraktikum->id }}" class="text-secondary">{{ $bahanpraktikum->nama }} /</a>
            </span>
            <span class="text-primary">
                Ubah
            </span>
        </h5>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Ubah Bahan Praktikum</h5>
                        <small class="text-muted float-end"><a href="/bahanpraktikum">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <form action="/bahanpraktikum/{{ $bahanpraktikum->id }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <div class="d-flex justify-content-center">
                                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                                        @if ($bahanpraktikum->foto)
                                            <input type="hidden" name="oldImage" value="{{ $bahanpraktikum->foto }}">
                                            <img src="{{ asset('storage') . '/' . $bahanpraktikum->foto }}"
                                                alt="user-avatar" class="d-block rounded img-preview" height="100"
                                                width="100" id="uploadedAvatar" />
                                        @else
                                            <img src="{{ asset('img') }}/unknown.png" alt="user-avatar"
                                                class="d-block rounded img-preview" height="100" width="100"
                                                id="uploadedAvatar" />
                                        @endif
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
                            <div class="mb-3">
                                <label class="form-label" for="jenis">Jenis Bahan Praktikum</label>
                                <select id="organization" class="select2 form-select @error('jenis') is-invalid @enderror"
                                    name="jenis">
                                    <option value="habis" @selected(old('jenis', $bahanpraktikum->jenis) == 'habis')>Habis</option>
                                    <option value="tidak habis" @selected(old('jenis', $bahanpraktikum->jenis) == 'tidak habis')>Tidak Habis</option>
                                </select>
                                @error('jenis')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="kode">kode barang</label>
                                <input type="text" class="form-control @error('kode') is-invalid @enderror"
                                    id="kode" placeholder="kode" value="{{ old('kode', $bahanpraktikum->kode) }}"
                                    name="kode" required />
                                @error('kode')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="laboratorium_id">Lokasi</label>
                                <select id="organization"
                                    class="select2 form-select @error('laboratorium_id') is-invalid @enderror"
                                    name="laboratorium_id">
                                    <option value="{{ $bahanpraktikum->laboratorium->id }}" @selected(old('laboratorium_id', $bahanpraktikum->laboratorium->id) == $bahanpraktikum->laboratorium->id)>
                                        {{ $bahanpraktikum->laboratorium->nama }}</option>
                                    @forelse ($laboratoriums as $laboratorium)
                                        <option value="{{ $laboratorium->id }}" @selected(old('laboratorium_id', $bahanpraktikum->laboratorium->id) == $laboratorium->id)>
                                            {{ $laboratorium->nama }}</option>
                                    @empty
                                        <option value="">Tidak Ada Data Laboratorium</option>
                                    @endforelse
                                </select>
                                @error('laboratorium_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="nama">Nama barang</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    id="nama" placeholder="Nama" value="{{ old('nama', $bahanpraktikum->nama) }}"
                                    name="nama" required />
                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="merk">Merk</label>
                                <input type="text" class="form-control @error('merk') is-invalid @enderror"
                                    id="merk" placeholder="Merk" value="{{ old('merk', $bahanpraktikum->merk) }}"
                                    name="merk" required />
                                @error('merk')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="spesifikasi">Spesifikasi</label>
                                <textarea id="spesifikasi" class="form-control @error('spesifikasi') is-invalid @enderror" placeholder="Spesifikasi"
                                    name="spesifikasi" required>{{ old('spesifikasi', $bahanpraktikum->spesifikasi) }}
                                 </textarea>
                                @error('spesifikasi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="harga">Harga</label>
                                <input type="number" class="form-control @error('harga') is-invalid @enderror"
                                    id="harga" placeholder="harga" name="harga"
                                    value="{{ old('harga', $bahanpraktikum->harga) }}" min="0" required />
                                @error('harga')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="stok">stok</label>
                                <input type="number" class="form-control @error('stok') is-invalid @enderror"
                                    id="stok" placeholder="stok" name="stok" min="0"
                                    value="{{ old('stok', $bahanpraktikum->stok) }}" required />
                                @error('stok')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="tahun">tahun</label>
                                <input type="number" class="form-control @error('tahun') is-invalid @enderror"
                                    id="tahun" placeholder="tahun" name="tahun" min="0"
                                    value="{{ old('tahun', $bahanpraktikum->tahun) }}" required />
                                @error('tahun')
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
        {{-- <div class="col-xl">
            <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Kode QR</h5>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="mb-3">
                                <div class="d-flex align-items-center align-items-sm-center justify-content-center gap-4">
                                    <img src="{{ asset('img') }}/qr.png" alt="user-avatar" class="d-block rounded"
                                        height="190" width="190" id="uploadedAvatar" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-fullname">Kode</label>
                                <input type="text" class="form-control" id="basic-default-fullname"
                                    placeholder="4HBT6IKL" readonly="readonly" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="basic-default-message">Keterangan</label>
                                <textarea id="basic-default-message" class="form-control" placeholder="Hi, Do you have a moment to talk Joe?"
                                    aria-label="Hi, Do you have a moment to talk Joe?" aria-describedby="basic-icon-default-message2"></textarea>
                            </div>
                        </form>
                    </div>
                </div>
        </div> --}}
    </div>

    {{-- <div class="card">
            <div class="card-header">
                <button type="submit" class="btn btn-primary">Ubah</button>
                </form>
            </div>
            <div class="card-body">
                <div class="mb-3 col-12 mb-0">
                    <div class="alert alert-primary">
                        <h6 class="alert-heading fw-bold mb-1">Penambahanpraktikum Data bahanpraktikum</h6>
                        <p class="mb-0">Ketika Form Tambah Data bahanpraktikum ditambahkan,<br />
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
