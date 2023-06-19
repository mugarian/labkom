@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="/prediksi" class="text-secondary">Data
                    prediksi</a> /
            </span> Tambah Data prediksi</h4>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">prediksi</h5>
                        <small class="text-muted float-end"><a href="/prediksi">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <form action="/prediksi" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="nama">Nama Barang</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    id="nama" placeholder="Nama" value="{{ old('nama') }}" name="nama" required />
                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="jml_pengajuan">Jumlah Pengajuan (satuan)</label>
                                <input type="number" class="form-control @error('jml_pengajuan') is-invalid @enderror"
                                    id="jml_pengajuan" placeholder="Jumlah Pengadaan" value="{{ old('jml_pengajuan') }}"
                                    min="0" name="jml_pengajuan" required />
                                @error('jml_pengajuan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="jml_matkul">Jumlah Matkul</label>
                                <input type="number" class="form-control @error('jml_matkul') is-invalid @enderror"
                                    id="jml_matkul" placeholder="Jumlah Matkul" value="{{ old('jml_matkul') }}"
                                    min="0" name="jml_matkul" required />
                                @error('jml_matkul')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="jml_siswa">Jumlah Siswa per kelas</label>
                                <input type="number" class="form-control @error('jml_siswa') is-invalid @enderror"
                                    id="jml_siswa" placeholder="Jumlah Matkul" value="{{ old('jml_siswa') }}" min="0"
                                    name="jml_siswa" required />
                                @error('jml_siswa')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="jml_kelas">Jumlah kelas</label>
                                <input type="number" class="form-control @error('jml_kelas') is-invalid @enderror"
                                    id="jml_kelas" placeholder="Jumlah Matkul" value="{{ old('jml_kelas') }}" min="0"
                                    name="jml_kelas" required />
                                @error('jml_kelas')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="harga_barang">Harga Barang</label>
                                <input type="number" class="form-control @error('harga_barang') is-invalid @enderror"
                                    id="harga_barang" placeholder="harga_barang" name="harga_barang"
                                    value="{{ old('harga_barang') }}" required />
                                @error('harga_barang')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="harga_termurah">Harga Barang Termurah</label>
                                <input type="number" class="form-control @error('harga_termurah') is-invalid @enderror"
                                    id="harga_termurah" placeholder="hargatermurah" name="harga_termurah"
                                    value="{{ old('harga_termurah') }}" required />
                                @error('harga_termurah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="harga_termahal">Harga Barang Termahal</label>
                                <input type="number" class="form-control @error('harga_termahal') is-invalid @enderror"
                                    id="harga_termahal" placeholder="harga termahal" name="harga_termahal"
                                    value="{{ old('harga_termahal') }}" required />
                                @error('harga_termahal')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Tambah</button>
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
                    <h6 class="alert-heading fw-bold mb-1">Penambahan Data prediksi</h6>
                    <p class="mb-0">Ketika Form Tambah Data prediksi ditambahkan,<br />
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
