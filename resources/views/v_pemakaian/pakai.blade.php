@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">
                <a href="/pemakaian" class="text-secondary">Data Pemakaian</a> /
            </span>
            @if ($barangpakai)
                {{ $barangpakai->nama }}
            @else
                Tambah Data Pemakaian
            @endif
        </h4>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">pemakaian</h5>
                        <small class="text-muted float-end"><a href="/pemakaian">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <form action="/pemakaian" method="POST">
                            @csrf
                            <div class="mb-3">
                                <div class="alert alert-primary">
                                    <h6 class="alert-heading fw-bold mb-1">Pemberitahuan</h6>
                                    <p class="mb-0">Masukkan kode barang yang terdapat di laboratorium pada kegiatan yang
                                        dimaksud. Selanjutnya masukan kode kegiatan yang sedang berlangsung atau berstatus
                                        disetujui. Pemakaian Barang bisa dilakukan dengan cara memindai QR Kode
                                        yang tertera pada barang untuk pengisian kode barang secara otomatis
                                    </p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <label class="form-label" for="barangpakai_id">Kode Barang</label>
                                <input type="text" class="form-control @error('barangpakai_id') is-invalid @enderror"
                                    id="barangpakai_id" placeholder="barangpakai_id"
                                    value="{{ old('barangpakai_id', $barangpakai->kode) }}" name="barangpakai_id" required
                                    readonly />
                                @error('barangpakai_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="kegiatan_id">Kode Kegiatan</label>
                                <input type="text" class="form-control @error('kegiatan_id') is-invalid @enderror"
                                    id="kegiatan_id" placeholder="kode kegiatan" value="{{ old('kegiatan_id') }}"
                                    name="kegiatan_id" required />
                                @error('kegiatan_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl">
            @if ($barangpakai)
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Data Barang</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex align-items-center align-items-sm-center justify-content-center gap-4">
                                @if ($barangpakai->foto)
                                    <img src="{{ asset('storage') . '/' . $barangpakai->foto }}" alt="pemakaian-avatar"
                                        class="d-block rounded" height="200" width="200" id="uploadedAvatar" />
                                @else
                                    <img src="{{ asset('img') }}/unknown.png" alt="user-avatar" class="d-block rounded"
                                        height="200" width="200" id="uploadedAvatar" />
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kode">Kode Barang</label>
                            <p class="form-control">{{ $barangpakai->kode }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">nama Barang</label>
                            <p class="form-control">{{ $barangpakai->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">Lokasi Barang</label>
                            <p class="form-control">{{ $barangpakai->laboratorium->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="keterangan">keterangan Barang</label>
                            <p class="form-control">{{ $barangpakai->keterangan }}</p>
                        </div>
                    </div>
                </div>
            @endif
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
        let currentDate = new Date().toISOString().slice(0, -8);
        console.log(currentDate);
        document.querySelector("#mulai").min = currentDate;
    </script>
@endsection
