@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Beranda /</a>
                Kegiatan /
                <a href="/permohonan" class="text-secondary">Permohonan Kegiatan /</a>
                <a href="/permohonan/{{ $permohonan->id }}" class="text-secondary">{{ $permohonan->nama }} /</a>
            </span>
            <span class="text-primary">
                Menolak Permohonan
            </span>
        </h5>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">permohonan</h5>
                        <small class="text-muted float-end"><a href="/permohonan">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <form action="/permohonan/{{ $permohonan->id }}/ditolak" method="POST">
                            @csrf
                            <div class="mb-3">
                                <div class="alert alert-primary">
                                    <h6 class="alert-heading fw-bold mb-1">Status Ditolak</h6>
                                    <p class="mb-0">
                                        Masukkan Komentar atau keterangan untuk memberitahukan alasan penolakan kegiatan
                                    </p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="verif_dospem">Verifikasi Dospem</label>
                                @if ($permohonan->dospem->user->id == auth()->user()->id)
                                    <input type="text" class="form-control @error('verif_dospem') is-invalid @enderror"
                                        id="verif_dospem" placeholder="verif_dospem" value="ditolak" name="verif_dospem"
                                        required readonly />
                                @else
                                    <input type="text" class="form-control @error('verif_dospem') is-invalid @enderror"
                                        id="verif_dospem" placeholder="verif_dospem" value="{{ $permohonan->verif_dospem }}"
                                        name="verif_dospem" required readonly />
                                @endif
                                @error('verif_dospem')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="verif_kalab">Verifikasi Kalab</label>
                                @if ($permohonan->laboratorium->user_id == auth()->user()->id)
                                    <input type="text" class="form-control @error('verif_kalab') is-invalid @enderror"
                                        id="verif_kalab" placeholder="verif_kalab" value="ditolak" name="verif_kalab"
                                        required readonly />
                                @else
                                    <input type="text" class="form-control @error('verif_kalab') is-invalid @enderror"
                                        id="verif_kalab" placeholder="verif_kalab" value="menunggu" name="verif_kalab"
                                        required readonly />
                                @endif
                                @error('verif_kalab')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="status">Status permohonan</label>
                                <input type="text" class="form-control @error('status') is-invalid @enderror"
                                    id="status" placeholder="status" value="ditolak" name="status" required readonly />
                                @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="keterangan">Keterangan</label>
                                <textarea id="keterangan" class="form-control @error('keterangan')
                                is-invalid @enderror"
                                    placeholder="keterangan" name="keterangan" required>{{ old('keterangan', $permohonan->keterangan) }}</textarea>
                                @error('keterangan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="kode">Kode Kegiatan</label>
                                <input type="text" class="form-control @error('kode') is-invalid @enderror"
                                    id="kode" placeholder="kode" value="{{ old('kode', $permohonan->kode) }}"
                                    name="kode" required readonly />
                                @error('kode')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="nama">Nama Kegiatan</label>
                                <input type="text" class="form-control" id="user_id" placeholder="user_id"
                                    value="{{ auth()->user()->id }}" name="user_id" hidden />
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    id="nama" placeholder="Nama" value="{{ old('nama', $permohonan->nama) }}"
                                    name="nama" required readonly />
                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="jenis">Jenis permohonan</label>
                                <input type="text" class="form-control @error('jenis') is-invalid @enderror"
                                    id="jenis" placeholder="jenis" value="{{ $permohonan->jenis }}" name="jenis"
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
                                    value="{{ $permohonan->laboratorium->nama }}" name="laboratorium_id" required
                                    readonly />
                                {{-- <select id="organization"
                                    class="select2 form-select @error('laboratorium_id') is-invalid @enderror"
                                    name="laboratorium_id">
                                    <option value="">Pilih Laboratorium</option>
                                    @foreach ($laboratoriums as $laboratorium)
                                        <option value="{{ $laboratorium->id }}" @selected(old('laboratorium_id', $permohonan->laboratorium_id) == $laboratorium->id)>
                                            {{ $laboratorium->nama }}</option>
                                    @endforeach
                                </select> --}}
                                @error('laboratorium_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            @if ($permohonan->jenis == 'peminjaman')
                                <div class="mb-3">
                                    <label class="form-label" for="dospem_id">Dosen Pengampu</label>
                                    <input type="text" class="form-control @error('dospem_id') is-invalid @enderror"
                                        id="dospem_id" placeholder="dospem_id"
                                        value="{{ $permohonan->dospem->user->nama }}" name="dospem_id" required
                                        readonly />
                                    {{-- <select id="organization"
                                        class="select2 form-select @error('dospem_id') is-invalid @enderror"
                                        name="dospem_id">
                                        <option value="">Pilih Dosen</option>
                                        @foreach ($dospems as $dospem)
                                            <option value="{{ $dospem->id }}" @selected(old('dospem_id', $permohonan->dospem_id) == $dospem->id)>
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
                                <textarea id="deskripsi"
                                    class="form-control @error('deskripsi')
                                is-invalid @enderror"
                                    placeholder="deskripsi" name="deskripsi" required readonly>{{ old('deskripsi', $permohonan->deskripsi) }}</textarea>
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
                                    value="{{ old('mulai', $permohonan->mulai) }}" required readonly />
                                @error('mulai')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="selesai">Tanggal selesai</label>
                                <input type="datetime-local" class="form-control @error('selesai') is-invalid @enderror"
                                    id="selesai" placeholder="Tanggal Selesai" name="selesai"
                                    value="{{ old('selesai', $permohonan->selesai) }}" required readonly />
                                @error('selesai')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-">
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
