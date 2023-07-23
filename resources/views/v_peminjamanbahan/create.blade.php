@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Home /</a>
                Logbook /
                <a href="/peminjamanbahan" class="text-secondary">Peminjaman Bahan /</a>
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
                        <h5 class="mb-0">Tambah Peminjaman bahan</h5>
                        <small class="text-muted float-end"><a href="/peminjamanbahan">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <form action="/peminjamanbahan" method="POST">
                            @csrf
                            <div class="mb-3">
                                <div class="alert alert-primary">
                                    <h6 class="alert-heading fw-bold mb-1">Pemberitahuan</h6>
                                    <p class="mb-0">Masukkan kode bahan yang tertera. peminjaman bahan bisa
                                        dilakukan dengan cara memindai QR Kode yang tertera pada barang untuk pengisian kode
                                        barang secara otomatis. Peminjaman bahan bisa dilakukan ketika status sudah
                                        disetujui oleh Kepala Lab
                                    </p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                <label class="form-label" for="bahanjurusan_id">Kode Bahan Jurusan</label>
                                <input list="bahanjurusan"
                                    class="form-control @error('bahanjurusan_id') is-invalid @enderror" id="bahanjurusan_id"
                                    placeholder="Kode Bahan" value="{{ old('bahanjurusan_id') }}" name="bahanjurusan_id"
                                    required autocomplete="off" onkeyup="namabj()" />
                                <datalist id="bahanjurusan">
                                    @foreach ($bahanjurusan as $bj)
                                        <option value="{{ $bj->kode }}">{{ $bj->nama }}
                                            ({{ $bj->laboratorium->nama }})
                                        </option>
                                    @endforeach
                                </datalist>
                                @error('bahanjurusan_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Bahan Jurusan</label>
                                <div>
                                    <input class="form-control mb-3" style="display:block" id="dummybj"
                                        placeholder="nama barang pakai terisi otomatis sesuai kode yang terdata" readonly />
                                    <div id="divbj" style="display:none">
                                        @foreach ($bahanjurusan as $bj)
                                            <input class="form-control mb-3" style="display:none" id="{{ $bj->kode }}"
                                                placeholder="nama barang pakai terisi otomatis sesuai kode yang terdata"
                                                value="{{ $bj->nama }}" readonly />
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
                            <div class="mb-3">
                                <label class="form-label" for="jumlah">Jumlah Bahan</label>
                                <input type="number" class="form-control @error('jumlah') is-invalid @enderror"
                                    id="jumlah" placeholder="Kode bahan" value="{{ old('jumlah') }}" min="0"
                                    name="jumlah" required />
                                @error('jumlah')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label class="form-label" for="jenis">Jenis peminjaman bahan (jurusan MI)</label>
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
    <script>
        const bahanjurusan = document.getElementById('bahanjurusan_id');

        const kodebj = [];

        <?php
        foreach ($bahanjurusan as $bj) {
            echo "kodebj.push('$bj->kode');\n";
        }
        ?>

        function namabj() {
            if (kodebj.includes(bahanjurusan.value)) {
                document.getElementById('divbj').style.display = 'block';
                document.getElementById(bahanjurusan.value).style.display = 'block';
                document.getElementById('dummybj').style.display = 'none';
            } else {
                document.getElementById('divbj').style.display = 'none';
                document.getElementById('dummybj').style.display = 'block';
            }
        }
    </script>
@endsection
