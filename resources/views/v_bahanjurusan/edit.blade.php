@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Home /</a>
                Invetori /
                <a href="/bahanjurusan" class="text-secondary">Bahan Jurusan /</a>
                <a href="/bahanjurusan/{{ $bahanjurusan->id }}"
                    class="text-secondary">{{ $bahanjurusan->bahanpraktikum->nama }} /</a>
            </span>
            <span class="text-primary">
                {{ $bahanjurusan->nama }}
            </span>
        </h5>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Bahan Jurusan</h5>
                        <small class="text-muted float-end"><a href="/bahanjurusan">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <form action="/bahanjurusan/{{ $bahanjurusan->id }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="d-flex justify-content-center">
                                <div class="d-flex align-items-start align-items-sm-center gap-4">
                                    @if ($bahanjurusan->foto)
                                        <input type="hidden" name="oldImage" value="{{ $bahanjurusan->foto }}">
                                        <img src="{{ asset('storage') . '/' . $bahanjurusan->foto }}" alt="user-avatar"
                                            class="d-block rounded img-preview" height="100" width="100"
                                            id="uploadedAvatar" />
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
                            <div class="mb-3">
                                <label class="form-label" for="nama">Nama Bahan Jurusan</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    id="nama" placeholder="nama" value="{{ old('nama', $bahanjurusan->nama) }}"
                                    name="nama" required />
                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="kode">kode</label>
                                <input type="text" class="form-control @error('kode') is-invalid @enderror"
                                    id="kode" placeholder="kode" value="{{ old('kode', $bahanjurusan->kode) }}"
                                    name="kode" required />
                                @error('kode')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="laboratorium_id">Laboratorium</label>
                                <select id="organization"
                                    class="select2 form-select @error('laboratorium_id') is-invalid @enderror"
                                    name="laboratorium_id">
                                    <option value="{{ $bahanjurusan->laboratorium->id }}" @selected(old('laboratorium_id', $bahanjurusan->laboratorium->id) == $bahanjurusan->laboratorium->id)>
                                        {{ $bahanjurusan->laboratorium->nama }}</option>
                                    @forelse ($laboratoriums as $laboratorium)
                                        <option value="{{ $laboratorium->id }}" @selected(old('laboratorium_id', $bahanjurusan->laboratorium->id) == $laboratorium->id)>
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
                        <h5 class="mb-0">Bahan Praktikum</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex align-items-center align-items-sm-center justify-content-center gap-4">
                                @if ($bahanjurusan->foto)
                                    <img src="{{ asset('storage') . '/' . $bahanjurusan->foto }}" alt="bahanjurusan-avatar"
                                        class="d-block rounded" height="200" width="200" id="uploadedAvatar" />
                                @else
                                    <img src="{{ asset('img') }}/unknown.png" alt="user-avatar" class="d-block rounded"
                                        height="200" width="200" id="uploadedAvatar" />
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama Bahan Praktikum</label>
                            <p class="form-control">{{ $bahanjurusan->bahanpraktikum->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="merk">Merk</label>
                            <p class="form-control">{{ $bahanjurusan->bahanpraktikum->merk }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="spesifikasi">Spesifikasi</label>
                            <p class="form-control">{{ $bahanjurusan->bahanpraktikum->spesifikasi }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="harga">Harga</label>
                            <p class="form-control">Rp.
                                {{ number_format($bahanjurusan->bahanpraktikum->harga, 2, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="card">
            <div class="card-header">
                <button type="submit" class="btn btn-primary">Ubah</button>
                </form>
            </div>
            <div class="card-body">
                <div class="mb-3 col-12 mb-0">
                    <div class="alert alert-primary">
                        <h6 class="alert-heading fw-bold mb-1">Penambahanjurusan Data bahanjurusan</h6>
                        <p class="mb-0">Ketika Form Tambah Data bahanjurusan ditambahkan,<br />
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
