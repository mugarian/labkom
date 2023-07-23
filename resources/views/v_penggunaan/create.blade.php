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
                        <h5 class="mb-0">Penggunaan</h5>
                        <small class="text-muted float-end"><a href="/penggunaan">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <form action="/penggunaan" method="POST">
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
                                <label class="form-label" for="bahanpraktikum_id">Kode Bahan</label>
                                <input list="bahanpraktikum"
                                    class="form-control @error('bahanpraktikum_id') is-invalid @enderror"
                                    id="bahanpraktikum_id" placeholder="Kode Bahan" value="{{ old('bahanpraktikum_id') }}"
                                    name="bahanpraktikum_id" required autocomplete="off" onkeyup="namabp()" />
                                <datalist id="bahanpraktikum">
                                    @foreach ($bahanpraktikum as $bp)
                                        <option value="{{ $bp->kode }}">{{ $bp->nama }}
                                            ({{ $bp->laboratorium->nama }})
                                        </option>
                                    @endforeach
                                </datalist>
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
                                        placeholder="nama barang pakai terisi otomatis sesuai kode yang terdata" readonly />
                                    <div id="divbp" style="display:none">
                                        @foreach ($bahanpraktikum as $bp)
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
                                <label class="form-label" for="jumlah">Jumlah Barang</label>
                                <input type="number" class="form-control @error('jumlah') is-invalid @enderror"
                                    id="jumlah" placeholder="jumlah" value="{{ old('jumlah') }}" name="jumlah"
                                    required />
                                @error('jumlah')
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
    <script>
        const bahanpraktikum = document.getElementById('bahanpraktikum_id');
        const kegiatan = document.getElementById('kegiatan_id');

        const kodebp = [];

        <?php
        foreach ($bahanpraktikum as $bp) {
            echo "kodebp.push('$bp->kode');\n";
        }
        ?>

        function namabp() {
            if (kodebp.includes(bahanpraktikum.value)) {
                document.getElementById('divbp').style.display = 'block';
                document.getElementById(bahanpraktikum.value).style.display = 'block';
                document.getElementById('dummybp').style.display = 'none';
            } else {
                document.getElementById('divbp').style.display = 'none';
                document.getElementById('dummybp').style.display = 'block';
            }
        }

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
