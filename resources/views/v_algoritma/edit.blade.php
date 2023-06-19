@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">
                <a href="/training" class="text-secondary">Data training</a> /
                <a href="/training/{{ $training->id }}" class="text-secondary">{{ $training->nama }}</a> /
            </span> Ubah Data Training
        </h4>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Data Training</h5>
                        <small class="text-muted float-end"><a href="/training">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <form action="/training/{{ $training->id }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label" for="nama">Nama</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    id="nama" placeholder="Nama" value="{{ old('nama', $training->nama) }}"
                                    name="nama" required />
                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="pengajuan">Kategori Pengajuan</label>
                                <select id="organization"
                                    class="select2 form-select @error('pengajuan') is-invalid @enderror" name="pengajuan">
                                    <option value="">Pilih pengajuan</option>
                                    <option value="lebih" @selected(old('pengajuan', $training->pengajuan) == 'lebih')>
                                        Melebihi Kuota
                                    </option>
                                    <option value="pas" @selected(old('pengajuan', $training->pengajuan) == 'pas')>
                                        Sesuai Kuota
                                    </option>
                                    <option value="kurang" @selected(old('pengajuan', $training->pengajuan) == 'kurang')>
                                        Kurang dari Kuota
                                    </option>
                                </select>
                                @error('pengajuan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="harga">Kategori Harga</label>
                                <select id="organization" class="select2 form-select @error('harga') is-invalid @enderror"
                                    name="harga">
                                    <option value="">Pilih Harga</option>
                                    <option value="mahal" @selected(old('harga', $training->harga) == 'mahal')>
                                        Mahal
                                    </option>
                                    <option value="murah" @selected(old('harga', $training->harga) == 'murah')>
                                        Murah
                                    </option>
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
                                    <option value="">Pilih Label</option>
                                    <option value="layak" @selected(old('label', $training->label) == 'layak')>
                                        Layak
                                    </option>
                                    <option value="tidak layak" @selected(old('label', $training->label) == 'tidak layak')>
                                        Tidak Layak
                                    </option>
                                </select>
                                @error('label')
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
            <button type="submit" class="btn btn-primary">Ubah</button>
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
