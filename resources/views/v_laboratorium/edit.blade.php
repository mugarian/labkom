@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Beranda /</a>
                <a href="/laboratorium" class="text-secondary">Laboratorium /</a>
                <a href="/laboratorium/{{ $laboratorium->id }}" class="text-secondary">{{ $laboratorium->nama }} /</a>
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
                        <h5 class="mb-0">Ubah Laboratorium</h5>
                        <small class="text-muted float-end"><a href="/laboratorium">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <form action="/laboratorium/{{ $laboratorium->id }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <div class="d-flex justify-content-center">
                                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                                        @if ($laboratorium->foto)
                                            <input type="hidden" name="oldImage" value="{{ $laboratorium->foto }}">
                                            <img src="{{ asset('storage') . '/' . $laboratorium->foto }}" alt="user-avatar"
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
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="nama">Nama Lab</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    id="nama" placeholder="Nama" value="{{ old('nama', $laboratorium->nama) }}"
                                    name="nama" required />
                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="user_id">Kepala Lab</label>
                                <input type="hidden" name="olduser_id" value="{{ $laboratorium->user_id }}"
                                    id="olduser_id">
                                <select id="organization" class="select2 form-select @error('user_id') is-invalid @enderror"
                                    name="user_id">
                                    <option value="{{ $laboratorium->user_id }}">{{ $laboratorium->user->nama }}
                                    </option>
                                    @foreach ($kepalalab as $kalab)
                                        <option value="{{ $kalab->user->id }}" @selected(old('user_id', $laboratorium->user_id) == $kalab->user_id)>
                                            {{ $kalab->user->nama }}</option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="deskripsi">deskripsi</label>
                                <textarea id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" placeholder="deskripsi"
                                    name="deskripsi" required>{{ old('deskripsi', $laboratorium->deskripsi) }}</textarea>
                                @error('deskripsi')
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
    </div>

    {{-- <div class="card">
            <div class="card-header">
                <button type="submit" class="btn btn-primary">Ubah</button>
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
