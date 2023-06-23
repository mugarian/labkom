@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Home /</a>
                Profil /
            </span>
            <span class="text-primary">
                {{ $user->nama }}
            </span>
        </h5>
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                {{-- <ul class="nav nav-pills flex-column flex-md-row mb-3">
                    <li class="nav-item">
                        <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Account</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="pages-account-settings-notifications.html"><i class="bx bx-bell me-1"></i>
                            Change Password</a>
                    </li>
                </ul> --}}
                <div class="card mb-4">
                    <h5 class="card-header">Detail Profil</h5>
                    <!-- Account -->
                    <div class="card-body">
                        <form action="/akun/{{ $user->id }}" method="POST" enctype="multipart/form-data">
                            @method('put')
                            @csrf
                            <div class="d-flex justify-content-between align-items-start align-items-sm-center gap-4">
                                <div class="">
                                    @if ($user->foto)
                                        <input type="hidden" name="oldImage" value="{{ $user->foto }}">
                                        <img src="{{ asset('storage') . '/' . $user->foto }}" alt="user-avatar"
                                            class="d-block rounded img-preview" height="100" width="100"
                                            id="uploadedAvatar" />
                                    @else
                                        <img src="{{ asset('img') }}/unknown.png" alt="user-avatar"
                                            class="d-block rounded img-preview" height="100" width="100"
                                            id="uploadedAvatar" />
                                    @endif
                                </div>
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

                                    <p class="text-muted mb-0">Hanya JPG atau PNG. Maksimal ukuran 8MB</p>
                                </div>
                            </div>

                            <hr class="my-3" />

                            <div class="container">
                                <div class="row align-items-start">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <h5 class="mt-3">Informasi Profil</h5>
                                            {{-- <small class="">&nbsp;</small> --}}
                                        </div>
                                        <div class="mb-3">
                                            <label for="nama" class="form-label">Nama</label>
                                            <input class="form-control @error('nama') is-invalid @enderror" type="text"
                                                id="nama" name="nama" value="{{ old('nama', $user->nama) }}" />
                                            @error('nama')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="nomor_induk" class="form-label">Nomor Induk</label>
                                            <input class="form-control @error('nomor_induk') is-invalid @enderror"
                                                type="text" id="nomor_induk" name="nomor_induk"
                                                value="{{ old('nomor_induk', $user->nomor_induk) }}" required />
                                            @error('nomor_induk')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        @if ($user->role == 'dosen')
                                            <div class="mb-3">
                                                <label class="form-label" for="jabatan">Jabatan</label>
                                                <select id="organization"
                                                    class="select2 form-select @error('jabatan') is-invalid @enderror"
                                                    name="jabatan">
                                                    <option value="ketua jurusan" @selected(old('jabatan', $dosen->jabatan) == 'Ketua Jurusan')>Ketua Jurusan
                                                    </option>
                                                    <option value="ketua prodi" @selected(old('jabatan', $dosen->jabatan) == 'ketua prodi')>Ketua Prodi
                                                    </option>
                                                    <option value="dosen" @selected(old('jabatan', $dosen->jabatan) == 'dosen pengampu')>Dosen</option>
                                                </select>
                                                @error('jabatan')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="jurusan">jurusan</label>
                                                <select id="organization"
                                                    class="select2 form-select @error('jurusan') is-invalid @enderror"
                                                    name="jurusan">
                                                    <option value="mi" @selected(old('jurusan', $dosen->jurusan) == 'mi')>MI</option>
                                                    <option value="ai" @selected(old('jurusan', $dosen->jurusan) == 'ai')>AI</option>
                                                    <option value="tppm" @selected(old('jurusan', $dosen->jurusan) == 'tppm')>TPPM</option>
                                                    <option value="kesehatan" @selected(old('jurusan', $dosen->jurusan) == 'kesehatan')>Kesehatan
                                                    </option>
                                                </select>
                                                @error('jurusan')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="kepalalab" class="form-label">Kepala Lab</label>
                                                <p class="">
                                                    @if ($dosen->kepalalab == 'true')
                                                        {{ $laboratorium->nama }}
                                                    @else
                                                        ###
                                                    @endif
                                                </p>
                                            </div>
                                        @elseif ($user->role == 'mahasiswa')
                                            <div class="mb-3">
                                                <label for="angkatan" class="form-label">angkatan</label>
                                                <input class="form-control @error('angkatan') is-invalid @enderror"
                                                    type="text" id="angkatan" name="angkatan"
                                                    value="{{ old('angkatan', $mahasiswa->angkatan) }}" required />
                                                @error('angkatan')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        @elseif ($user->role == 'staff')
                                            <div class="mb-3">
                                                <label for="bidang" class="form-label">bidang</label>
                                                <input class="form-control @error('bidang') is-invalid @enderror"
                                                    type="text" id="bidang" name="bidang"
                                                    value="{{ old('bidang', $staff->bidang) }}" required />
                                                @error('bidang')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        @endif
                                        <div class="mb-3">
                                            <label class="form-label" for="password">Email</label>
                                            <input type="email"
                                                class="form-control @error('email') is-invalid @enderror" id="email"
                                                placeholder="email" name="email"
                                                value="{{ old('email', $user->email) }}" required />
                                            @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <h5 class="mb-0">Ubah Password</h5>
                                            <small>(Kosongkan jika tidak mengubah password)</small>
                                        </div>
                                        <div class="mb-3 form-password-toggle">
                                            <div class="d-flex justify-content-between">
                                                <label class="form-label" for="password">Password</label>
                                            </div>
                                            <div class="input-group input-group-merge">
                                                <input type="password"
                                                    class="form-control @if (session()->has('password')) is-invalid @endif"
                                                    id="password" placeholder="Password" name="password"
                                                    value="{{ old('password') }}" />
                                                <span class="input-group-text cursor-pointer"><i
                                                        class="bx bx-hide"></i></span>
                                                @if (session()->has('password'))
                                                    <div class="invalid-feedback">
                                                        {{ session('password') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mb-3 form-password-toggle">
                                            <div class="d-flex justify-content-between">
                                                <label class="form-label" for="new_password">Password Baru</label>
                                            </div>
                                            <div class="input-group input-group-merge">
                                                <input type="password"
                                                    class="form-control @error('new_password') is-invalid @enderror"
                                                    id="new_password" placeholder="Password Baru" name="new_password" />
                                                <span class="input-group-text cursor-pointer"><i
                                                        class="bx bx-hide"></i></span>
                                                @error('new_password')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="mb-3 form-password-toggle">
                                            <div class="d-flex justify-content-between">
                                                <label class="form-label" for="new_password_confirmation">Konfirmasi
                                                    Password Baru</label>
                                            </div>
                                            <div class="input-group input-group-merge">
                                                <input type="password"
                                                    class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                                    id="new_password_confirmation" placeholder="Password Baru"
                                                    name="new_password_confirmation" />
                                                <span class="input-group-text cursor-pointer"><i
                                                        class="bx bx-hide"></i></span>
                                                @error('new_password_confirmation')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Simpan</button>
                                <button type="reset" class="btn btn-secondary me-2">Reset</button>
                            </div>
                        </form>
                    </div>
                    <!-- /Account -->
                </div>
                {{-- <div class="card">
                    <h5 class="card-header">Relasi Akun</h5>
                    <div class="card-body">
                        <div class="mb-3 col-12 mb-0">
                            <div class="alert alert-primary">
                                <h6 class="alert-heading fw-bold mb-1">Wali user SI A 2020</h6>
                                <p class="mb-0">Mensetujui Setiap peminjaman</p>
                            </div>
                        </div>
                    </div>
                </div> --}}
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
