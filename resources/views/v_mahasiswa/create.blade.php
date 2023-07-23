@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Beranda /</a>
                Akun /
                <a href="/mahasiswa" class="text-secondary">Mahasiswa /</a>
            </span>
            <span class="text-primary">
                Tambah
            </span>
        </h5>
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
                        <h5 class="mb-0">Tambah Akun mahasiswa</h5>
                        <small class="text-muted float-end"><a href="/mahasiswa">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <form action="/mahasiswa" method="POST" enctype="multipart/form-data">
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
                                <label class="form-label" for="nama">Nama Mahasiswa</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    id="nama" placeholder="Nama" value="{{ old('nama') }}" name="nama" required />
                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="nomor_induk">Nomor Induk</label>
                                <input type="number" class="form-control @error('nomor_induk') is-invalid @enderror"
                                    id="nomor_induk" placeholder="Nomor Induk" value="{{ old('nomor_induk') }}"
                                    name="nomor_induk" required />
                                @error('nomor_induk')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="kelas_id">Kelas</label>
                                <select id="organization"
                                    class="select2 form-select @error('kelas_id') is-invalid @enderror" name="kelas_id">
                                    <option value="">Pilih Kelas</option>
                                    @foreach ($kelas as $kls)
                                        <option value="{{ $kls->id }}" @selected(old('kelas_id') == $kls->id)>
                                            {{ $kls->nama . ' (' . $kls->angkatan . ')' }}</option>
                                    @endforeach
                                </select>
                                @error('kelas_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="angkatan">Angkatan</label>
                                <input type="number" class="form-control @error('angkatan') is-invalid @enderror"
                                    id="angkatan" placeholder="angkatan" name="angkatan"
                                    value="{{ old('angkatan', date('Y')) }}" required />
                                @error('angkatan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="jurusan">jurusan</label>
                                <select id="organization" class="select2 form-select @error('jurusan') is-invalid @enderror"
                                    name="jurusan">
                                    <option value="">Pilih Jurusan</option>
                                    <option value="mi" @selected(old('jurusan') == 'mi')>MI</option>
                                    <option value="ai" @selected(old('jurusan') == 'ai')>AI</option>
                                    <option value="tppm" @selected(old('jurusan') == 'tppm')>TPPM</option>
                                    <option value="kesehatan" @selected(old('jurusan') == 'kesehatan')>Kesehatan</option>
                                </select>
                                @error('jurusan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" placeholder="email" name="email" value="{{ old('email') }}"
                                    required />
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="Password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password_confirmation"
                                        class="form-control @error('password_confirmation') is-invalid @enderror"
                                        name="password_confirmation" placeholder="Konfirmasi Password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
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
                        <h6 class="alert-heading fw-bold mb-1">Penambahan Data mahasiswa</h6>
                        <p class="mb-0">Ketika Form Tambah Data mahasiswa ditambahkan,<br />
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
