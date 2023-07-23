@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Home /</a>
                Inventory /
                <a href="/alat" class="text-secondary">Alat /</a>
                <a href="/alat/{{ $alat->id }}" class="text-secondary">{{ $alat->nama }} /</a>
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
                        <h5 class="mb-0">Barang Pakai</h5>
                        <small class="text-muted float-end">
                            <a href="/barangpakai">
                                < Kembali </a>
                        </small>
                    </div>
                    <div class="card-body">
                        <form action="/barangpakai" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3 d-flex justify-content-center">
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
                            <div class="mb-3">
                                <label class="form-label" for="kode">kode</label>
                                <input type="text" class="form-control @error('kode') is-invalid @enderror"
                                    id="kode" placeholder="kode" value="{{ old('kode', $kode) }}" name="kode"
                                    required />
                                @error('kode')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="nama">Nama</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    id="nama" placeholder="Nama" value="{{ old('nama') }}" name="nama" required />
                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="harga">harga</label>
                                <input type="number" class="form-control @error('harga') is-invalid @enderror"
                                    id="harga" placeholder="harga" value="{{ old('harga') }}" name="harga"
                                    min="0" required />
                                @error('harga')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="tahun">tahun</label>
                                <input type="number" class="form-control @error('tahun') is-invalid @enderror"
                                    id="tahun" placeholder="tahun" value="{{ old('tahun') }}" name="tahun"
                                    min="1" required />
                                @error('tahun')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="alat_id">Alat</label>
                                <select id="organization" class="select2 form-select @error('alat_id') is-invalid @enderror"
                                    name="alat_id">
                                    <option value="{{ $alat->id }}" @selected(old('alat_id') == $alat->id)>
                                        {{ $alat->nama }}
                                    </option>
                                </select>
                                @error('alat_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="laboratorium_id">Laboratorium</label>
                                @if (auth()->user()->role == 'admin')
                                    <select id="organization"
                                        class="select2 form-select @error('laboratorium_id') is-invalid @enderror"
                                        name="laboratorium_id">
                                        <option value="">Pilih laboratorium</option>
                                        @foreach ($laboratoriums as $laboratorium)
                                            <option value="{{ $laboratorium->id }}" @selected(old('laboratorium_id') == $laboratorium->id)>
                                                {{ $laboratorium->nama }}</option>
                                        @endforeach
                                    </select>
                                @else
                                    <select id="organization"
                                        class="select2 form-select @error('laboratorium_id') is-invalid @enderror"
                                        name="laboratorium_id">
                                        <option value="{{ $kalab->id }}">{{ $kalab->nama }}</option>
                                    </select>
                                @endif
                                @error('laboratorium_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form>
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
                    <h6 class="alert-heading fw-bold mb-1">Penamlaboratorium Data laboratorium</h6>
                    <p class="mb-0">Ketika Form Tambah Data laboratorium ditambahkan,<br />
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
