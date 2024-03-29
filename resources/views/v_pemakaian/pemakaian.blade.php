@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Beranda /</a>
                Logbook /
                <a href="/pemakaian" class="text-secondary">Pemakaian Alat /</a>
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
                        <h5 class="mb-0">Tambah Pemakaian</h5>
                        <small class="text-muted float-end"><a href="/pemakaian">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <form action="/pemakaian" method="POST">
                            @csrf
                            <div class="mb-3">
                                <div class="alert alert-primary">
                                    <h6 class="alert-heading fw-bold mb-1">Pemberitahuan</h6>
                                    <p class="mb-0">Masukkan kode Barang Pakai yang terdapat di laboratorium pada
                                        kegiatan yang dimaksud. Selanjutnya masukan kode kegiatan yang sedang berlangsung
                                        atau berstatus disetujui. Pemakaian Barang bisa dilakukan dengan cara memindai QR
                                        Kode yang tertera pada barang untuk pengisian kode barang secara otomatis.
                                        Penggunaan Barang Pakai bisa dilakukan ketika status sudah disetujui oleh Kepala
                                        Lab
                                    </p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <label class="form-label" for="barangpakai_id">Kode Barang Pakai</label>
                                <input list="barangpakai" class="form-control @error('barangpakai_id') is-invalid @enderror"
                                    id="barangpakai_id" placeholder="kode barang pakai" value="{{ old('barangpakai_id') }}"
                                    name="barangpakai_id" required autocomplete="off" onkeyup="namabp()" />
                                <datalist id="barangpakai">
                                    @foreach ($barangpakai as $bp)
                                        <option value="{{ $bp->kode }}">{{ $bp->nama }}
                                            ({{ $bp->laboratorium->nama }})
                                        </option>
                                    @endforeach
                                </datalist>
                                @error('barangpakai_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Barang Pakai</label>
                                <div>
                                    <input class="form-control mb-3" style="display:block" id="dummybp"
                                        placeholder="nama barang pakai terisi otomatis sesuai kode yang terdata" readonly />
                                    <div id="divbp" style="display:none">
                                        @foreach ($barangpakai as $bp)
                                            <input class="form-control mb-3" style="display:none" id="{{ $bp->kode }}"
                                                placeholder="nama barang pakai terisi otomatis sesuai kode yang terdata"
                                                value="{{ $bp->nama }}" readonly />
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="kegiatan_id">Kode Kegiatan</label>
                                <input list="kegiatan" class="form-control @error('kegiatan_id') is-invalid @enderror"
                                    id="kegiatan_id" placeholder="kode kegiatan"
                                    value="{{ old('kegiatan_id', $kegiatan->kode) }}" name="kegiatan_id" required
                                    autocomplete="off" readonly />
                                @error('kegiatan_id')
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
    </div>
    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Informasi Kegiatan</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="kode">Kode Kegiatan</label>
                        <p class="form-control">{{ $kegiatan->kode }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="nama">Nama Kegiatan</label>
                        <p class="form-control">{{ $kegiatan->nama }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="laboratorium">Lokasi</label>
                        <p class="form-control">{{ $kegiatan->laboratorium->nama }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="oleh">Oleh</label>
                        <p class="form-control">{{ $kegiatan->user->nama }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="Dospem">Dospem</label>
                        <p class="form-control">{{ $kegiatan->dospem->user->nama }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="mulai">Tanggal Mulai</label>
                        <p class="form-control">{{ $kegiatan->mulai }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="selesai">Rencana Selesai</label>
                        <p class="form-control">{{ $kegiatan->selesai }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const barangpakai = document.getElementById('barangpakai_id');
        const kegiatan = document.getElementById('kegiatan_id');

        const kodebp = [];

        <?php
        foreach ($barangpakai as $bp) {
            echo "kodebp.push('$bp->kode');\n";
        }
        ?>

        function namabp() {
            if (kodebp.includes(barangpakai.value)) {
                document.getElementById('divbp').style.display = 'block';
                document.getElementById(barangpakai.value).style.display = 'block';
                document.getElementById('dummybp').style.display = 'none';
            } else {
                document.getElementById('divbp').style.display = 'none';
                document.getElementById('dummybp').style.display = 'block';
            }
        }
    </script>
@endsection
