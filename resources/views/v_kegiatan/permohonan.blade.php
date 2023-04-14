@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="/kegiatan" class="text-secondary">kegiatan</a>
                /</span> Tambah Kegiatan permohonan</h4>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">kegiatan</h5>
                        <small class="text-muted float-end"><a href="/kegiatan">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <form action="/permohonan" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label" for="kode">Kode</label>
                                <input type="text" class="form-control @error('kode') is-invalid @enderror"
                                    id="kode" placeholder="kode" value="{{ bin2hex(random_bytes(4)) }}" name="kode"
                                    required />
                                @error('kode')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
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
                                <label class="form-label" for="jenis">Jenis Kegiatan</label>
                                <input type="text" class="form-control @error('jenis') is-invalid @enderror"
                                    id="jenis" placeholder="jenis" value="permohonan" name="jenis" required
                                    readonly />
                                @error('jenis')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="tipe">Tipe Kegiatan</label>
                                <select id="organization" class="select2 form-select @error('tipe') is-invalid @enderror"
                                    name="tipe">
                                    <option value="">Pilih Tipe Kegiatan</option>
                                    <option value="perkuliahan" @selected(old('tipe') == 'perkuliahan')>
                                        Perkuliahan</option>
                                    <option value="non perkuliahan" @selected(old('tipe') == 'non perkuliahan')>
                                        Non Perkuliahan</option>
                                </select>
                                @error('tipe')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="laboratorium_id">laboratorium</label>
                                <select id="organization"
                                    class="select2 form-select @error('laboratorium_id') is-invalid @enderror"
                                    name="laboratorium_id">
                                    <option value="">Pilih Laboratorium</option>
                                    @foreach ($laboratoriums as $laboratorium)
                                        @if ($laboratorium->user_id == auth()->user()->id)
                                            @continue
                                        @endif
                                        <option value="{{ $laboratorium->id }}" @selected(old('laboratorium_id') == $laboratorium->id)>
                                            {{ $laboratorium->nama }}</option>
                                    @endforeach
                                </select>
                                @error('laboratorium_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="dospem_id">Dosen Pengampu</label>
                                <select id="organization"
                                    class="select2 form-select @error('dospem_id') is-invalid @enderror" name="dospem_id">
                                    @if (auth()->user()->role == 'dosen')
                                        <option value="{{ $dosen->id }}" @selected(old('dospem_id') == $dosen->id)>
                                            {{ $dosen->user->nama }}</option>
                                    @else
                                        <option value="">Pilih Dosen</option>
                                        @foreach ($dospems as $dospem)
                                            <option value="{{ $dospem->id }}" @selected(old('dospem_id') == $dospem->id)>
                                                {{ $dospem->user->nama }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('laboratorium_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="deskripsi">deskripsi</label>
                                <textarea id="deskripsi" class="form-control @error('deskripsi')
                                is-invalid @enderror"
                                    placeholder="deskripsi" name="deskripsi" required>{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="mulai">Tanggal Mulai</label>
                                <input type="datetime-local" class="form-control @error('mulai') is-invalid @enderror"
                                    id="mulai" placeholder="mulai" name="mulai" value="{{ old('mulai') }}"
                                    required />
                                @error('mulai')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
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

        <div class="card">
            <div class="card-header">
                <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
            <div class="card-body">
                <div class="mb-3 col-12 mb-0">
                    <div class="alert alert-primary">
                        <h6 class="alert-heading fw-bold mb-1">Penamkegiatan Data kegiatan</h6>
                        <p class="mb-0">Ketika Form Tambah Data kegiatan ditambahkan,<br />
                            Maka Secara Otomatis Kode QR akan menambahkan data Kode QR baru, <br />
                            Dan Langsung Disambungkan sesuai kode qr yang tertera
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        let currentDate = new Date().toISOString().slice(0, -8);
        console.log(currentDate);
        document.querySelector("#mulai").min = currentDate;
    </script>
@endsection
