@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Beranda /</a>
                Pengajuan Bahan /
                <a href="/prediksi" class="text-secondary">Prediksi Pengajuan /</a>
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
                        <h5 class="mb-0">Tambah Prediksi Pengajuan</h5>
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
                                <label class="form-label" for="kategori">Kategori Barang</label>
                                <select id="organization"
                                    class="select2 form-select @error('kategori') is-invalid @enderror" name="kategori">
                                    <option value="">Pilih Kategori Barang</option>
                                    <option value="hardware cpu" @selected(old('kategori') == 'hardware cpu')>hardware cpu</option>
                                    <option value="komponen cpu" @selected(old('kategori') == 'komponen cpu')>komponen cpu</option>
                                    <option value="komponen elektronik" @selected(old('kategori') == 'komponen elektronik')>komponen elektronik
                                    </option>
                                    <option value="komponen internet" @selected(old('kategori') == 'komponen internet')>komponen internet
                                    </option>
                                    <option value="komponen kabel" @selected(old('kategori') == 'komponen kabel')>komponen kabel
                                    </option>
                                    <option value="komponen material" @selected(old('kategori') == 'komponen material')>komponen material
                                    </option>
                                </select>
                                @error('kategori')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="satuan">Satuan Pengajuan</label>
                                <select id="organization" class="select2 form-select @error('satuan') is-invalid @enderror"
                                    name="satuan">
                                    <option value="">Pilih satuan pengajuan</option>
                                    <option value="non pcs" @selected(old('satuan') == 'non pcs')>NON PCS</option>
                                    <option value="pcs" @selected(old('satuan') == 'pcs')>PCS</option>
                                </select>
                                @error('satuan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="tahun_pengadaan">Tahun Pengajuan</label>
                                <input type="number" class="form-control @error('tahun_pengadaan') is-invalid @enderror"
                                    id="tahun_pengadaan" placeholder="tahun_pengadaan" value="{{ old('tahun_pengadaan') }}"
                                    name="tahun_pengadaan" required min="1" />
                                @error('tahun_pengadaan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="jumlah_pengadaan">Jumlah Pengajuan</label>
                                <input type="number" class="form-control @error('jumlah_pengadaan') is-invalid @enderror"
                                    id="jumlah_pengadaan" placeholder="jumlah_pengadaan"
                                    value="{{ old('jumlah_pengadaan') }}" name="jumlah_pengadaan" required min="0" />
                                @error('jumlah_pengadaan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="isi_barang_persatuan">Isi Barang Persatuan</label>
                                <input type="number"
                                    class="form-control @error('isi_barang_persatuan') is-invalid @enderror"
                                    id="isi_barang_persatuan" placeholder="isi_barang_persatuan"
                                    value="{{ old('isi_barang_persatuan') }}" name="isi_barang_persatuan" required
                                    min="0" />
                                @error('isi_barang_persatuan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="jumlah_matkul">Jumlah Matkul</label>
                                <input type="number" class="form-control @error('jumlah_matkul') is-invalid @enderror"
                                    id="jumlah_matkul" placeholder="jumlah_matkul" value="{{ old('jumlah_matkul') }}"
                                    name="jumlah_matkul" required min="0" />
                                @error('jumlah_matkul')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="jumlah_siswa_perkelas">Jumlah Siswa Per Kelas</label>
                                <input type="number"
                                    class="form-control @error('jumlah_siswa_perkelas') is-invalid @enderror"
                                    id="jumlah_siswa_perkelas" placeholder="jumlah_siswa_perkelas"
                                    value="{{ old('jumlah_siswa_perkelas') }}" name="jumlah_siswa_perkelas" required
                                    min="0" />
                                @error('jumlah_siswa_perkelas')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="jumlah_kelas">Jumlah Kelas</label>
                                <input type="number" class="form-control @error('jumlah_kelas') is-invalid @enderror"
                                    id="jumlah_kelas" placeholder="jumlah_kelas" value="{{ old('jumlah_kelas') }}"
                                    name="jumlah_kelas" required min="0" />
                                @error('jumlah_kelas')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="jenis_pemegang_barang">Jenis Pemegang Barang</label>
                                <select id="organization"
                                    class="select2 form-select @error('jenis_pemegang_barang') is-invalid @enderror"
                                    name="jenis_pemegang_barang">
                                    <option value="">Pilih Jenis Pemegang Barang</option>
                                    <option value="orang" @selected(old('jenis_pemegang_barang') == 'orang')> Orang</option>
                                    <option value="kelas" @selected(old('jenis_pemegang_barang') == 'kelas')>Kelas</option>
                                </select>
                                @error('jenis_pemegang_barang')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="jumlah_pemegang_barang">Jumlah Pemegang Barang</label>
                                <input type="number"
                                    class="form-control @error('jumlah_pemegang_barang') is-invalid @enderror"
                                    id="jumlah_pemegang_barang" placeholder="jumlah_pemegang_barang"
                                    value="{{ old('jumlah_pemegang_barang') }}" name="jumlah_pemegang_barang" required
                                    min="0" />
                                @error('jumlah_pemegang_barang')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="harga_barang_beli">Harga Barang Beli</label>
                                <input type="number"
                                    class="form-control @error('harga_barang_beli') is-invalid @enderror"
                                    id="harga_barang_beli" placeholder="harga_barang_beli"
                                    value="{{ old('harga_barang_beli') }}" name="harga_barang_beli" required
                                    min="0" />
                                @error('harga_barang_beli')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="stok_barang">Stok Barang</label>
                                <input type="number" class="form-control @error('stok_barang') is-invalid @enderror"
                                    id="stok_barang" placeholder="stok_barang" value="{{ old('stok_barang') }}"
                                    name="stok_barang" required min="0" />
                                @error('stok_barang')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="jenis_bahan">Jenis Bahan</label>
                                <select id="organization"
                                    class="select2 form-select @error('jenis_bahan') is-invalid @enderror"
                                    name="jenis_bahan">
                                    <option value="">Pilih Jenis Bahan</option>
                                    <option value="habis" @selected(old('jenis_bahan') == 'habis')>Habis</option>
                                    <option value="tidak habis" @selected(old('jenis_bahan') == 'tidak habis')>Tidak Habis</option>
                                </select>
                                @error('jenis_bahan')
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
