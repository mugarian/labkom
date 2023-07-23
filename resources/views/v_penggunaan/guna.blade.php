@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Beranda /</a>
                Logbook /
                <a href="/penggunaan" class="text-secondary">Penggunaan Bahan Praktikum /</a>
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
                        <h5 class="mb-0">Tambah Penggunaan</h5>
                        <small class="text-muted float-end"><a href="/penggunaan">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <form action="/penggunaan" method="POST">
                            @csrf
                            <div class="mb-3">
                                <div class="alert alert-primary">
                                    <h6 class="alert-heading fw-bold mb-1">Pemberitahuan</h6>
                                    <p class="mb-0">Masukkan kode bahan praktikum yang terdapat di laboratorium pada
                                        kegiatan yang dimaksud. Selanjutnya masukan kode kegiatan yang sedang berlangsung
                                        atau berstatus disetujui. Pemakaian Barang bisa dilakukan dengan cara memindai QR
                                        Kode yang tertera pada barang untuk pengisian kode barang secara otomatis.
                                        Penggunaan Bahan Praktikum bisa dilakukan ketika status sudah disetujui oleh Kepala
                                        Lab
                                    </p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <label class="form-label" for="bahanpraktikum_id">Kode Bahan Praktikum</label>
                                <input type="text" class="form-control @error('bahanpraktikum_id') is-invalid @enderror"
                                    id="bahanpraktikum_id" placeholder="bahanpraktikum_id"
                                    value="{{ old('bahanpraktikum_id', $bahanpraktikum->kode) }}" name="bahanpraktikum_id"
                                    required readonly autocomplete="off" />
                                @error('bahanpraktikum_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Bahan Praktikum</label>
                                <div>
                                    <input class="form-control mb-3" style="display:block" id="dummybp"
                                        placeholder="nama barang pakai terisi otomatis sesuai kode yang terdata"
                                        value="{{ $bahanpraktikum->nama }}" readonly />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="kegiatan_id">Kode Kegiatan</label>
                                <input list="kegiatan" class="form-control @error('kegiatan_id') is-invalid @enderror"
                                    id="kegiatan_id" placeholder="kode kegiatan" value="{{ old('kegiatan_id') }}"
                                    name="kegiatan_id" required autocomplete="off" onkeyup="namakeg()" />
                                <datalist id="kegiatan">
                                    @foreach ($kegiatan as $keg)
                                        <option value="{{ $keg->kode }}">{{ $keg->nama }} ({{ $keg->status }})
                                            ({{ $keg->laboratorium->nama }})
                                        </option>
                                    @endforeach
                                </datalist>
                                @error('kegiatan_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Nama Kegiatan</label>
                                <div>
                                    <input class="form-control mb-3" style="display:block" id="dummykeg"
                                        placeholder="nama Kegiatan terisi otomatis sesuai kode yang terdata" readonly />
                                    <div id="divkeg" style="display:none">
                                        @foreach ($kegiatan as $keg)
                                            <input class="form-control mb-3" style="display:none" id="{{ $keg->kode }}"
                                                placeholder="nama kegiatan terisi otomatis sesuai kode yang terdata"
                                                value="{{ $keg->nama }}" readonly />
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="deskripsi">Deskripsi</label>
                                <input type="text" class="form-control @error('deskripsi') is-invalid @enderror"
                                    id="deskripsi" placeholder="Deskripsi" value="{{ old('deskripsi') }}" name="deskripsi"
                                    required />
                                @error('deskripsi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="jumlah">Jumlah Bahan Praktikum</label>
                                <input type="number" class="form-control @error('jumlah') is-invalid @enderror"
                                    id="jumlah" placeholder="jumlah" value="{{ old('jumlah') }}" name="jumlah"
                                    min="0" max="{{ $bahanpraktikum->stok }}" required />
                                @error('jumlah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Gunakan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Informasi Bahan Jurusan</h5>
                </div>
                <div class="card-body">
                    @if ($bahanpraktikum)
                        <div class="mb-3">
                            <div class="d-flex align-items-center align-items-sm-center justify-content-center gap-4">
                                @if ($bahanpraktikum->foto)
                                    <img src="{{ asset('storage') . '/' . $bahanpraktikum->foto }}"
                                        alt="pemakaian-avatar" class="d-block rounded" height="200" width="200"
                                        id="uploadedAvatar" />
                                @else
                                    <img src="{{ asset('img') }}/unknown.png" alt="user-avatar" class="d-block rounded"
                                        height="200" width="200" id="uploadedAvatar" />
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="jenis">jenis Bahan Praktikum</label>
                            <p class="form-control">{{ $bahanpraktikum->jenis }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="kode">Kode Bahan Praktikum</label>
                            <p class="form-control">{{ $bahanpraktikum->kode }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama Bahan Praktikum</label>
                            <p class="form-control">{{ $bahanpraktikum->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="laboratorium">Lokasi</label>
                            <p class="form-control">{{ $bahanpraktikum->laboratorium->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="stok">Stok Bahan Praktikum</label>
                            <p class="form-control">{{ $bahanpraktikum->stok }}</p>
                        </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <script>
        const kegiatan = document.getElementById('kegiatan_id');

        const kodekeg = [];

        <?php
        foreach ($kegiatan as $keg) {
            echo "kodekeg.push('$keg->kode');\n";
        }
        ?>

        function namakeg() {
            if (kodekeg.includes(kegiatan.value)) {
                document.getElementById('divkeg').style.display = 'block';
                document.getElementById(kegiatan.value).style.display = 'block';
                document.getElementById('dummykeg').style.display = 'none';
            } else {
                document.getElementById('divkeg').style.display = 'none';
                document.getElementById('dummykeg').style.display = 'block';
            }
        }
    </script>
@endsection
