@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Home /</a>
                Pengajuan Bahan /
                <a href="/training" class="text-secondary">Data Training /</a>
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
                        <h5 class="mb-0">Tambah Training</h5>
                        <small class="text-muted float-end"><a href="/training">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <form action="/training" method="POST" enctype="multipart/form-data">
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
                                <label class="form-label" for="pengadaan">Kategori pengadaan</label>
                                <select id="organization"
                                    class="select2 form-select @error('pengadaan') is-invalid @enderror" name="pengadaan">
                                    <option value="">Pilih Kategori pengadaan</option>
                                    <option value="lebih" @selected(old('pengadaan') == 'murah')>Melebihi Kuota</option>
                                    <option value="pas" @selected(old('pengadaan') == 'mahal')>Sesuai Kuota</option>
                                    <option value="kurang" @selected(old('pengadaan') == 'mahal')>Tidak Memenuhi Kuota</option>
                                </select>
                                @error('pengadaan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="harga">Kategori Harga</label>
                                <select id="organization" class="select2 form-select @error('harga') is-invalid @enderror"
                                    name="harga">
                                    <option value="">Pilih Kategori Harga</option>
                                    <option value="murah" @selected(old('harga') == 'murah')> Murah</option>
                                    <option value="mahal" @selected(old('harga') == 'mahal')>Mahal</option>
                                </select>
                                @error('harga')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="label">Label</label>
                                <select id="organization" class="select2 form-select @error('label') is-invalid @enderror"
                                    name="label">
                                    <option value="">Pilih Label Pengdaan</option>
                                    <option value="layak" @selected(old('label') == 'layak')>Layak</option>
                                    <option value="tidak layak" @selected(old('label') == 'tidak layak')> Tidak Layak</option>
                                </select>
                                @error('label')
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
    </div>

    {{-- <div class="card">
        <div class="card-header">
            <button type="submit" class="btn btn-primary">Tambah</button>
            </form>
        </div>
        <div class="card-body">
            <div class="mb-3 col-12 mb-0">
                <div class="alert alert-primary">
                    <h6 class="alert-heading fw-bold mb-1">Penambahan Data training</h6>
                    <p class="mb-0">Ketika Form Tambah Data training ditambahkan,<br />
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
