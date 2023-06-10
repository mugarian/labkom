@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">
                <a href="/pemakaian" class="text-secondary">Data Pemakaian</a> /
                <a href="/pemakaian/{{ $pemakaian->id }}" class="text-secondary">{{ $pemakaian->barangpakai->nama }}</a> /
            </span> Cek Kondisi
        </h4>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Pemakaian</h5>
                        <small class="text-muted float-end"><a href="/pemakaian">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <form action="/pemakaian/{{ $pemakaian->id }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <div class="alert alert-primary">
                                    <h6 class="alert-heading fw-bold mb-1">Pemberitahuan</h6>
                                    <p class="mb-0">Untuk menyelesaikan peakaian barang laboratorium, silahkan isi kolom
                                        kolom berikut untuk mengetahui kondisi layak pakai barangpakai
                                    </p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="barangpakai_id">Kode barangpakai</label>
                                <input type="text" class="form-control @error('barangpakai_id') is-invalid @enderror"
                                    id="barangpakai_id" placeholder="barangpakai_id"
                                    value="{{ old('barangpakai_id', $pemakaian->barangpakai->kode) }}" name="barangpakai_id"
                                    required readonly />
                                @error('barangpakai_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="kegiatan_id">Kode Kegiatan</label>
                                <input type="text" class="form-control @error('kegiatan_id') is-invalid @enderror"
                                    id="kegiatan_id" placeholder="kode kegiatan"
                                    value="{{ old('kegiatan_id', $pemakaian->kegiatan->kode) }}" name="kegiatan_id" required
                                    readonly />
                                @error('kegiatan_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="mulai">Mulai Kegiatan</label>
                                <input type="text" class="form-control @error('mulai') is-invalid @enderror"
                                    id="mulai" placeholder="kode kegiatan" value="{{ old('mulai', $pemakaian->mulai) }}"
                                    name="mulai" required readonly />
                                @error('mulai')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="selesai">Selesai Kegiatan</label>
                                <input type="text" class="form-control @error('selesai') is-invalid @enderror"
                                    id="selesai" placeholder="kode kegiatan"
                                    value="{{ old('selesai', $pemakaian->selesai) }}" name="selesai" required readonly />
                                @error('selesai')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            @if ($pemakaian->barangpakai->alat->kategori == 'pc')
                                <div class="mb-3">
                                    <label class="form-label" for="cpu">CPU</label>
                                    <select id="organization" class="select2 form-select @error('cpu') is-invalid @enderror"
                                        name="cpu">
                                        <option value="">Pilih Kondisi</option>
                                        <option value="berfungsi" @selected(old('cpu') == 'berfungsi')>
                                            Berfungsi
                                        </option>
                                        <option value="tidak berfungsi" @selected(old('cpu') == 'tidak berfungsi')>
                                            Tidak Berfungsi
                                        </option>
                                    </select>
                                    @error('cpu')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="monitor">Monitor</label>
                                    <select id="organization"
                                        class="select2 form-select @error('monitor') is-invalid @enderror" name="monitor">
                                        <option value="">Pilih Kondisi</option>
                                        <option value="berfungsi" @selected(old('monitor') == 'berfungsi')>
                                            Berfungsi
                                        </option>
                                        <option value="tidak berfungsi" @selected(old('monitor') == 'tidak berfungsi')>
                                            Tidak Berfungsi
                                        </option>
                                    </select>
                                    @error('monitor')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="keyboard">keyboard</label>
                                    <select id="organization"
                                        class="select2 form-select @error('keyboard') is-invalid @enderror" name="keyboard">
                                        <option value="">Pilih Kondisi</option>
                                        <option value="berfungsi" @selected(old('keyboard') == 'berfungsi')>
                                            Berfungsi
                                        </option>
                                        <option value="tidak berfungsi" @selected(old('keyboard') == 'tidak berfungsi')>
                                            Tidak Berfungsi
                                        </option>
                                    </select>
                                    @error('keyboard')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="mouse">mouse</label>
                                    <select id="organization"
                                        class="select2 form-select @error('mouse') is-invalid @enderror" name="mouse">
                                        <option value="">Pilih Kondisi</option>
                                        <option value="berfungsi" @selected(old('mouse') == 'berfungsi')>
                                            Berfungsi
                                        </option>
                                        <option value="tidak berfungsi" @selected(old('mouse') == 'tidak berfungsi')>
                                            Tidak Berfungsi
                                        </option>
                                    </select>
                                    @error('mouse')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            @endif
                            <div class="mb-4">
                                <label class="form-label" for="keterangan">Keterangan</label>
                                <textarea id="keterangan"
                                    class="form-control @error('keterangan')
                                is-invalid @enderror"
                                    placeholder="keterangan" name="keterangan" required>{{ old('keterangan') }}</textarea>
                                @error('keterangan')
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
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">barangpakai</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex align-items-center align-items-sm-center justify-content-center gap-4">
                            @if ($pemakaian->barangpakai->foto)
                                <img src="{{ asset('storage') . '/' . $pemakaian->foto }}" alt="pemakaian-avatar"
                                    class="d-block rounded" height="200" width="200" id="uploadedAvatar" />
                            @else
                                <img src="{{ asset('img') }}/unknown.png" alt="user-avatar" class="d-block rounded"
                                    height="200" width="200" id="uploadedAvatar" />
                            @endif
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="kode">Kode barangpakai</label>
                        <p class="form-control">{{ $pemakaian->barangpakai->kode }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="nama">nama barangpakai</label>
                        <p class="form-control">{{ $pemakaian->barangpakai->nama }}</p>
                    </div>
                    <div class="mt-5 mb-3">
                        <h5 class="mb-0">Kegiatan</h5>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="kode">kode kegiatan</label>
                        <p class="form-control">{{ $pemakaian->kegiatan->kode }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="jenis">jenis kegiatan</label>
                        <p class="form-control">{{ $pemakaian->kegiatan->jenis }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="nama">Oleh</label>
                        <p class="form-control">{{ $pemakaian->kegiatan->user->nama }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="nama">nama kegiatan</label>
                        <p class="form-control">{{ $pemakaian->kegiatan->nama }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="deskripsi">deskripsi kegiatan</label>
                        <p class="form-control">{{ $pemakaian->kegiatan->deskripsi }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="tanggal">Tanggal Mulai</label>
                        <p class="form-control">{{ $pemakaian->kegiatan->mulai }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="card">
            <div class="card-header">
                <button type="submit" class="btn btn-primary">Selesai</button>
                </form>
            </div>
            <div class="card-body">
                <div class="mb-3 col-12 mb-0">
                    <div class="alert alert-primary">
                        <h6 class="alert-heading fw-bold mb-1">pemakaian Data pemakaian</h6>
                        <p class="mb-0">Ketika Form Tambah Data pemakaian ditambahkan,<br />
                            Maka Secara Otomatis Kode QR akan menambahkan data Kode QR baru, <br />
                            Dan Langsung Disambungkan sesuai kode qr yang tertera
                        </p>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
    <script>
        function padTo2Digits(num) {
            return num.toString().padStart(2, '0');
        }

        function formatDate(date) {
            return (
                [
                    date.getFullYear(),
                    padTo2Digits(date.getMonth() + 1),
                    padTo2Digits(date.getDate()),
                ].join('-') +
                ' ' + [
                    padTo2Digits(date.getHours()),
                    padTo2Digits(date.getMinutes()),
                    padTo2Digits(date.getSeconds()),
                ].join(':')
            );
        }

        function showDate() {
            document.getElementById("selesai").value = formatDate(new Date());
        }

        setInterval(showDate, 1000);
    </script>
@endsection
