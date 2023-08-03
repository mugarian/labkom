@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Beranda /</a>
                <a href="/matakuliah" class="text-secondary">Mata Kuliah /</a>
                <a href="/matakuliah/{{ $matakuliah->id }}" class="text-secondary">{{ $matakuliah->nama }} /</a>
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
                        <h5 class="mb-0">Ubah Mata Kuliahs</h5>
                        <small class="text-muted float-end"><a href="/matakuliah">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <form action="/matakuliah/{{ $matakuliah->id }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label" for="nama">Nama Mata Kuliah</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    id="nama" placeholder="Nama" value="{{ old('nama', $matakuliah->nama) }}"
                                    name="nama" required />
                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="dosen_id">Dosen Pengampu</label>
                                <select id="organization"
                                    class="select2 form-select @error('dosen_id') is-invalid @enderror" name="dosen_id">
                                    <option value="{{ $matakuliah->dosen_id }}">{{ $matakuliah->dosen->user->nama }}
                                    </option>
                                    @foreach ($dosens as $dosen)
                                        <option value="{{ $dosen->id }}" @selected(old('dosen_id', $matakuliah->dosen_id) == $dosen->dosen_id)>
                                            {{ $dosen->user->nama }}</option>
                                    @endforeach
                                </select>
                                @error('dosen_id')
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
                                    <option value="mi" @selected(old('jurusan', $matakuliah->jurusan) == 'mi')>MI</option>
                                    <option value="ai" @selected(old('jurusan', $matakuliah->jurusan) == 'ai')>AI</option>
                                    <option value="tppm" @selected(old('jurusan', $matakuliah->jurusan) == 'tppm')>TPPM</option>
                                    <option value="kesehatan" @selected(old('jurusan', $matakuliah->jurusan) == 'kesehatan')>Kesehatan</option>
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
    </div>

    {{-- <div class="card">
            <div class="card-header">
                <button type="submit" class="btn btn-primary">Ubah</button>
                </form>
            </div>
            <div class="card-body">
                <div class="mb-3 col-12 mb-0">
                    <div class="alert alert-primary">
                        <h6 class="alert-heading fw-bold mb-1">Penammatakuliah Data matakuliah</h6>
                        <p class="mb-0">Ketika Form Tambah Data matakuliah ditambahkan,<br />
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
