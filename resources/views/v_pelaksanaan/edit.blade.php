@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><a href="/kegiatan" class="text-secondary">Data
                    Kegiatan</a>
                / <a href="/kegiatan/{{ $kegiatan->id }}" class="text-secondary">{{ $kegiatan->nama }} / </span> Menolak
            Kegiatan</h4>

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
                        <form action="/kegiatan/{{ $kegiatan->id }}" method="POST">
                            @csrf
                            @method('put')
                            <div class="mb-3">
                                <label class="form-label" for="keterangan">Keterangan</label>
                                <textarea id="keterangan" class="form-control @error('keterangan')
                                is-invalid @enderror"
                                    placeholder="keterangan" name="keterangan" required>{{ old('keterangan', $kegiatan->keterangan) }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="kode">Kode</label>
                                <input type="text" class="form-control @error('kode') is-invalid @enderror"
                                    id="kode" placeholder="kode" value="{{ old('kode', $kegiatan->kode) }}"
                                    name="kode" required readonly />
                                @error('kode')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="nama">Nama</label>
                                <input type="text" class="form-control" id="user_id" placeholder="user_id"
                                    value="{{ auth()->user()->id }}" name="user_id" hidden />
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    id="nama" placeholder="Nama" value="{{ old('nama', $kegiatan->nama) }}"
                                    name="nama" required readonly />
                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="jenis">Jenis Kegiatan</label>
                                <input type="text" class="form-control @error('jenis') is-invalid @enderror"
                                    id="jenis" placeholder="jenis" value="{{ $kegiatan->jenis }}" name="jenis"
                                    required readonly />
                                @error('jenis')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="laboratorium_id">laboratorium</label>
                                <input type="text" class="form-control @error('laboratorium_id') is-invalid @enderror"
                                    id="laboratorium_id" placeholder="laboratorium_id"
                                    value="{{ $kegiatan->laboratorium->nama }}" name="laboratorium_id" required readonly />
                                {{-- <select id="organization"
                                    class="select2 form-select @error('laboratorium_id') is-invalid @enderror"
                                    name="laboratorium_id">
                                    <option value="">Pilih Laboratorium</option>
                                    @foreach ($laboratoriums as $laboratorium)
                                        <option value="{{ $laboratorium->id }}" @selected(old('laboratorium_id', $kegiatan->laboratorium_id) == $laboratorium->id)>
                                            {{ $laboratorium->nama }}</option>
                                    @endforeach
                                </select> --}}
                                @error('laboratorium_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            @if ($kegiatan->jenis == 'peminjaman')
                                <div class="mb-3">
                                    <label class="form-label" for="dospem_id">Dosen Pengampu</label>
                                    <input type="text" class="form-control @error('dospem_id') is-invalid @enderror"
                                        id="dospem_id" placeholder="dospem_id" value="{{ $kegiatan->dospem->user->nama }}"
                                        name="dospem_id" required readonly />
                                    {{-- <select id="organization"
                                        class="select2 form-select @error('dospem_id') is-invalid @enderror"
                                        name="dospem_id">
                                        <option value="">Pilih Dosen</option>
                                        @foreach ($dospems as $dospem)
                                            <option value="{{ $dospem->id }}" @selected(old('dospem_id', $kegiatan->dospem_id) == $dospem->id)>
                                                {{ $dospem->user->nama }}</option>
                                        @endforeach
                                    </select> --}}
                                    @error('laboratorium_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            @endif
                            <div class="mb-3">
                                <label class="form-label" for="deskripsi">Deskripsi</label>
                                <textarea id="deskripsi" class="form-control @error('deskripsi')
                                is-invalid @enderror"
                                    placeholder="deskripsi" name="deskripsi" required readonly>{{ old('deskripsi', $kegiatan->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="mulai">Tanggal Mulai</label>
                                <input type="datetime-local" class="form-control @error('mulai') is-invalid @enderror"
                                    id="mulai" placeholder="mulai" name="mulai"
                                    value="{{ old('mulai', $kegiatan->mulai) }}" required readonly />
                                @error('mulai')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Perhatian</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3 col-12 mb-0">
                        <div class="alert alert-primary">
                            <h6 class="alert-heading fw-bold mb-1">Status Ditolak</h6>
                            <p class="mb-0">
                                Masukkan Komentar atau keterangan untuk memberitahukan alasan penolakan kegiatan
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="card">
        <div class="card-header">

        </div>
        <div class="card-body">

        </div>
    </div> --}}
    <script>
        let currentDate = new Date().toISOString().slice(0, -8);
        console.log(currentDate);
        document.querySelector("#mulai").min = currentDate;
    </script>
@endsection
