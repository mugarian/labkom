@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">
                <a href="/kelas" class="text-secondary">Data kelas</a> /
            </span> Tambah Data kelas
        </h4>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">kelas</h5>
                        <small class="text-muted float-end"><a href="/kelas">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <form action="/kelas" method="POST" enctype="multipart/form-data">
                            @csrf
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
                                <label class="form-label" for="dosen_id">Wali Dosen</label>
                                <select id="organization"
                                    class="select2 form-select @error('dosen_id') is-invalid @enderror" name="dosen_id">
                                    <option value="">Pilih Wali Dosen</option>
                                    @foreach ($dosens as $dosen)
                                        <option value="{{ $dosen->id }}" @selected(old('dosen_id') == $dosen->id)>
                                            {{ $dosen->user->nama }}</option>
                                    @endforeach
                                </select>
                                @error('dosen_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="angkatan">Angkatan</label>
                                <input type="number" class="form-control @error('angkatan') is-invalid @enderror"
                                    id="angkatan" placeholder="angkatan" value="{{ old('angkatan') }}" name="angkatan"
                                    min="2000" required />
                                @error('angkatan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="jurusan">Jurusan</label>
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
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
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
                    <h6 class="alert-heading fw-bold mb-1">Penamkelas Data kelas</h6>
                    <p class="mb-0">Ketika Form Tambah Data kelas ditambahkan,<br />
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
