@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="/dosen" class="text-secondary">Data Dosen</a>
                /</span> Ubah Data Dosen</h4>
        @if (session()->has('fail'))
            <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                {{ session('fail') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Dosen</h5>
                        <small class="text-muted float-end"><a href="/dosen">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <form action="/dosen/{{ $dosen->id }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label" for="foto">Foto Dosen</label>
                                <div class="">
                                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                                        @if ($dosen->foto)
                                            <input type="hidden" name="oldImage" value="{{ $dosen->foto }}">
                                            <img src="{{ asset('storage') . '/' . $dosen->foto }}" alt="user-avatar"
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
                            <div class="mb-3">
                                <label class="form-label" for="nama">Nama</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    id="nama" placeholder="Nama" value="{{ old('nama', $dosen->user->nama) }}"
                                    name="nama" required />
                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="nomor_induk">Nomor Induk</label>
                                <input type="text" class="form-control @error('nomor_induk') is-invalid @enderror"
                                    id="nomor_induk" placeholder="nomor_induk"
                                    value="{{ old('nomor_induk', $dosen->user->nomor_induk) }}" name="nomor_induk"
                                    required />
                                @error('nomor_induk')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="jabatan">Jabatan</label>
                                <input type="text" class="form-control @error('jabatan') is-invalid @enderror"
                                    id="jabatan" placeholder="jabatan" name="jabatan"
                                    value="{{ old('jabatan', $dosen->jabatan) }}" required />
                                @error('jabatan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="jurusan">Jurusan</label>
                                <input type="text" class="form-control @error('jurusan') is-invalid @enderror"
                                    id="jurusan" placeholder="jurusan" name="jurusan"
                                    value="{{ old('jurusan', $dosen->jurusan) }}" required />
                                @error('jurusan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                    </div>
                </div>
            </div>
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Data Akun</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="password">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="email" placeholder="email" name="email"
                                value="{{ old('email', $dosen->user->email) }}" required />
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3 mt-5">
                            <h5 class="mb-0">Ubah Password</h5>
                            <small>(Kosongkan jika tidak mengubah password)</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="lama">Password Lama</label>
                            <input type="password" class="form-control @error('lama') is-invalid @enderror"
                                id="lama" placeholder="Password Lama" name="lama"
                                value="{{ old('lama') }}" />
                            @error('lama')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="baru">Password Baru</label>
                            <input type="password" class="form-control @error('baru') is-invalid @enderror"
                                id="baru" placeholder="Password baru" name="baru"
                                value="{{ old('baru') }}" />
                            @error('baru')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="konfir">Konfirmasi Password</label>
                            <input type="password" class="form-control @error('konfir') is-invalid @enderror"
                                id="konfir" placeholder="konfirmasi password" name="konfir"
                                value="{{ old('konfir') }}" />
                            @error('konfir')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <button type="submit" class="btn btn-primary">Ubah</button>
                </form>
            </div>
            <div class="card-body">
                <div class="mb-3 col-12 mb-0">
                    <div class="alert alert-primary">
                        <h6 class="alert-heading fw-bold mb-1">Penambahan Data dosen</h6>
                        <p class="mb-0">Ketika Form Tambah Data dosen ditambahkan,<br />
                            Maka Secara Otomatis Kode QR akan menambahkan data Kode QR baru, <br />
                            Dan Langsung Disambungkan sesuai kode qr yang tertera
                        </p>
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
