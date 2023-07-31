@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Beranda /</a>
                Logbook /
            </span>
            <span class="text-primary">
                Peminjaman Alat
            </span>
        </h5>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Tambah Peminjaman Alat</h5>
                        <small class="text-muted float-end"><a href="/peminjamanalat">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <form action="/peminjamanalat" method="POST">
                            @csrf
                            <div class="mb-3">
                                <div class="alert alert-primary">
                                    <h6 class="alert-heading fw-bold mb-1">Pemberitahuan</h6>
                                    <p class="mb-0">Masukkan kode barang pakai alat yang tertera. peminjaman alat bisa
                                        dilakukan dengan cara memindai QR Kode yang tertera pada barang untuk pengisian kode
                                        barang secara otomatis
                                    </p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <label class="form-label" for="barangpakai_id">Nama Barang Pakai</label>
                                <input type="text" class="form-control @error('barangpakai_id') is-invalid @enderror"
                                    id="barangpakai_id" placeholder="Kode Alat"
                                    value="{{ old('barangpakai_id', $barangpakai->nama . ' ## ' . $barangpakai->kode) }}"
                                    name="barangpakai_id" required readonly autocomplete="off" />
                                @error('barangpakai_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="deskripsi">Deskripsi</label>
                                <textarea id="deskripsi" class="form-control @error('deskripsi')
                                is-invalid @enderror"
                                    placeholder="deskripsi" name="deskripsi" required>{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="rencana_tgl_kembali">Rencana Tanggal Pengembalian</label>
                                <input type="datetime-local"
                                    class="form-control @error('rencana_tgl_kembali') is-invalid @enderror"
                                    id="rencana_tgl_kembali" placeholder="rencana_tgl_kembali" name="rencana_tgl_kembali"
                                    value="{{ old('rencana_tgl_kembali') }}" min="{{ date('Y-m-d') . 'T' . date('H:i') }}"
                                    onchange="akhir()" required />
                                @error('rencana_tgl_kembali')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="jenis">Jurusan Peminjam</label>
                                <input type="text" class="form-control @error('jenis') is-invalid @enderror"
                                    id="jenis" placeholder="jenis" value="{{ old('jenis', $jenis) }}" name="jenis"
                                    required readonly />
                                @error('jenis')
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
        <div class="row">
            <div class="col-xl">
                @if ($barangpakai)
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Informasi Barang Pakai</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="d-flex align-items-center align-items-sm-center justify-content-center gap-4">
                                    @if ($barangpakai->foto)
                                        <img src="{{ asset('storage') . '/' . $barangpakai->foto }}" alt="pemakaian-avatar"
                                            class="d-block rounded" height="200" width="200" id="uploadedAvatar" />
                                    @else
                                        <img src="{{ asset('img') }}/unknown.png" alt="user-avatar"
                                            class="d-block rounded" height="200" width="200" id="uploadedAvatar" />
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="kode">Kode barang pakai</label>
                                <p class="form-control">{{ $barangpakai->kode }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="nama">nama barang pakai</label>
                                <p class="form-control">{{ $barangpakai->nama }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="nama">Lokasi barang pakai</label>
                                <p class="form-control">{{ $barangpakai->laboratorium->nama }}</p>
                            </div>
                        </div>
                    </div>
                @endif
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
                    <h6 class="alert-heading fw-bold mb-1">peminjamanalat Data peminjamanalat</h6>
                    <p class="mb-0">Ketika Form Tambah Data peminjamanalat ditambahkan,<br />
                        Maka Secara Otomatis Kode QR akan menambahkan data Kode QR baru, <br />
                        Dan Langsung Disambungkan sesuai kode qr yang tertera
                    </p>
                </div>
            </div>
        </div>
    </div> --}}
    </div>
    <script>
        let currentDate = new Date().toISOString().slice(0, -8);
        console.log(currentDate);
        document.querySelector("#mulai").min = currentDate;
    </script>
@endsection
