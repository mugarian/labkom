@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">
                <a href="/staff" class="text-secondary">Data Staff</a> /
                <a href="/staff{{ $staff->id }}" class="text-secondary">{{ $staff->user->nama }}</a> /
            </span> Ubah Data staff
        </h4>
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
                        <h5 class="mb-0">staff</h5>
                        <small class="text-muted float-end"><a href="/staff">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <form action="/staff/{{ $staff->id }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label" for="foto">Foto staff</label>
                                <div class="">
                                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                                        @if ($staff->user->foto)
                                            <input type="hidden" name="oldImage" value="{{ $staff->user->foto }}">
                                            <img src="{{ asset('storage') . '/' . $staff->user->foto }}" alt="user-avatar"
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
                                    id="nama" placeholder="Nama" value="{{ old('nama', $staff->user->nama) }}"
                                    name="nama" required />
                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="nomor_induk">Nomor Induk</label>
                                <input type="number" class="form-control @error('nomor_induk') is-invalid @enderror"
                                    id="nomor_induk" placeholder="Nomor Induk"
                                    value="{{ old('nomor_induk', $staff->user->nomor_induk) }}" name="nomor_induk"
                                    required />
                                @error('nomor_induk')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="bidang">Bidang</label>
                                <input type="text" class="form-control @error('bidang') is-invalid @enderror"
                                    id="bidang" placeholder="bidang" name="bidang"
                                    value="{{ old('bidang', $staff->bidang) }}" required />
                                @error('bidang')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Ubah</button>
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
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                placeholder="email" name="email" value="{{ old('email', $staff->user->email) }}"
                                required />
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
                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">Password</label>
                            </div>
                            <div class="input-group input-group-merge">
                                <input type="password"
                                    class="form-control @if (session()->has('password')) is-invalid @endif"
                                    id="password" placeholder="Password" name="password"
                                    value="{{ old('password') }}" />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
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
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                    id="new_password" placeholder="Password Baru" name="new_password" />
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
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
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
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
            </form>


            {{-- <div class="card">
            <div class="card-header">
                <button type="submit" class="btn btn-primary">Ubah</button>
                </form>
            </div>
            <div class="card-body">
                <div class="mb-3 col-12 mb-0">
                    <div class="alert alert-primary">
                        <h6 class="alert-heading fw-bold mb-1">Penambahan Data staff</h6>
                        <p class="mb-0">Ketika Form Tambah Data staff ditambahkan,<br />
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
