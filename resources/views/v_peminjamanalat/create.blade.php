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
                        <h5 class="mb-0">Peminjaman Alat</h5>
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
                                        barang secara otomatis. Peminjaman alat bisa dilakukan ketika status sudah disetujui
                                        oleh Kepala Lab.
                                    </p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <label class="form-label" for="barangpakai_id">Nama Barang Pakai</label>
                                <input list="barangpakai" class="form-control @error('barangpakai_id') is-invalid @enderror"
                                    id="barangpakai_id" placeholder="Nama barang pakai" value="{{ old('barangpakai_id') }}"
                                    name="barangpakai_id" required autocomplete="off" />
                                <datalist id="barangpakai">
                                    @foreach ($barangpakai as $bp)
                                        <option value="{{ $bp->nama . ' ## ' . $bp->kode }}">
                                            {{ $bp->laboratorium->nama }}
                                        </option>
                                    @endforeach
                                </datalist>
                                @error('barangpakai_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            {{-- <div class="mb-3">
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
                            </div> --}}
                            {{-- <div class="mb-3">
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
                            </div> --}}
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
    </div>
    {{-- <script>
        const barangpakai = document.getElementById('barangpakai_id');

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
    </script> --}}
@endsection
