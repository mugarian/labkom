@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">
                <a href="/laboratorium/{{ $laboratorium->id }}" class="text-secondary">{{ $laboratorium->nama }}</a> /
            </span> Tambah Data Barang Habis
        </h4>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Barang Habis</h5>
                        <small class="text-muted float-end"><a href="/baranghabis">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <form action="/baranghabis" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="foto">Foto Barang Habis</label>
                                <div class="">
                                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                                        <img src="{{ asset('img') }}/unknown.png" alt="user-avatar"
                                            class="d-block rounded img-preview" height="100" width="100"
                                            id="uploadedAvatar" />
                                        <div class="button-wrapper">
                                            <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                                <span class="d-none d-sm-block">
                                                    Upload new photo
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

                                            <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 8MB</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="text" hidden class="form-control" id="laboratorium_id"
                                placeholder="laboratorium_id" value="{{ $laboratorium->id }}" name="laboratorium_id"
                                required />
                            <div class="mb-3">
                                <label class="form-label" for="kode">kode</label>
                                <input type="text" class="form-control @error('kode') is-invalid @enderror"
                                    id="kode" placeholder="kode" value="{{ old('kode') }}" name="kode" required />
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
                                <label class="form-label" for="bahan_id">Bahan</label>
                                <select id="organization"
                                    class="select2 form-select @error('bahan_id') is-invalid @enderror" name="bahan_id">
                                    <option value="">Pilih bahan</option>
                                    @foreach ($bahans as $bahan)
                                        <option value="{{ $bahan->id }}" @selected(old('bahan_id') == $bahan->id)>
                                            {{ $bahan->nama }}</option>
                                    @endforeach
                                </select>
                                @error('bahan_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="deskripsi">Deskripsi</label>
                                <textarea id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" placeholder="deskripsi"
                                    name="deskripsi" required>{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="keterangan">Keterangan</label>
                                <textarea id="keterangan" class="form-control @error('keterangan') is-invalid @enderror" placeholder="keterangan"
                                    name="keterangan" required>{{ old('keterangan') }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl">
            {{-- <div class="card mb-4">
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
                </div> --}}
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
