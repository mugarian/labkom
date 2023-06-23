@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">

        {{-- FASILITAS --}}
        {{-- <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                <a href="/laboratorium">
                    <div class="card">
                        <center>
                            <div class="card-body">
                                <div class="card-title d-flex align-items-center justify-content-center">
                                    <div class="avatar flex-shrink-0">
                                        <i class='fs-1 text-primary bx bx-door-open'></i>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block text-black mb-1">Laboratorium</span>
                                <h3 class="card-title mb-2">{{ $laboratorium->count() }}</h3>
                            </div>
                        </center>
                    </div>
                </a>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                <a href="/kelas">
                    <div class="card">
                        <center>
                            <div class="card-body">
                                <div class="card-title d-flex align-items-center justify-content-center">
                                    <div class="avatar flex-shrink-0">
                                        <i class='fs-1 text-primary bx bx-chalkboard'></i>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block text-black mb-1">Kelas</span>
                                <h3 class="card-title mb-2">{{ $kelas->count() }}</h3>
                            </div>
                        </center>
                    </div>
                </a>
            </div>
        </div> --}}

        {{-- INVENTORI --}}
        {{-- <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12 mb-3">
                <a href="/alat">
                    <div class="card">
                        <center>
                            <div class="card-body">
                                <div class="card-title d-flex align-items-center justify-content-center">
                                    <div class="avatar flex-shrink-0">
                                        <i class='fs-1 text-primary bx bx-wrench'></i>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block text-black mb-1">Alat</span>
                                <h3 class="card-title mb-2">{{ $alat->count() }}</h3>
                                <div class="d-flex justify-content-evenly">
                                </div>
                            </div>
                        </center>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 mb-3">
                <a href="#">
                    <div class="card">
                        <center>
                            <div class="card-body">
                                <div class="card-title d-flex align-items-center justify-content-center">
                                    <div class="avatar flex-shrink-0">
                                        <i class='fs-1 text-primary bx bx-desktop'></i>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block text-black mb-1">Barang Pakai</span>
                                <h3 class="card-title mb-2">{{ $barangpakai->count() }}</h3>
                                <div class="d-flex justify-content-evenly">
                                </div>
                            </div>
                        </center>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 mb-4">
                <a href="/bahanpraktikum">
                    <div class="card">
                        <center>
                            <div class="card-body">
                                <div class="card-title d-flex align-items-center justify-content-center">
                                    <div class="avatar flex-shrink-0">
                                        <i class='fs-1 text-primary bx bx-archive'></i>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block text-black mb-1">Bahan Praktikum</span>
                                <h3 class="card-title mb-2">
                                    {{ $bahanpraktikum->count() }}
                                </h3>
                            </div>
                        </center>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 mb-4">
                <a href="/bahanjurusan">
                    <div class="card">
                        <center>
                            <div class="card-body">
                                <div class="card-title d-flex align-items-center justify-content-center">
                                    <div class="avatar flex-shrink-0">
                                        <i class='fs-1 text-primary bx bx-package'></i>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block text-black mb-1">Bahan Jurusan</span>
                                <h3 class="card-title mb-2">
                                    {{ $bahanjurusan->count() }}
                                </h3>
                            </div>
                        </center>
                    </div>
                </a>
            </div>
        </div> --}}

        {{-- KEGIATAN --}}
        {{-- <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                <a href="/pelaksanaan">
                    <div class="card">
                        <center>
                            <div class="card-body">
                                <div class="card-title d-flex align-items-center justify-content-center">
                                    <div class="avatar flex-shrink-0">
                                        <i class='fs-1 text-primary bx bx-calendar-week'></i>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block text-black mb-1">Pelaksanaan Kegiatan</span>
                                <h3 class="card-title mb-2">{{ $pelaksanaan }}</h3>
                                <div class="d-flex justify-content-evenly">
                                    <small class="text-success fw-semibold" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="Selesai">
                                        <i class="bx bx-check-double"></i> {{ $plselesai }}
                                    </small>
                                    <small class="text-warning fw-semibold" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="Berlangsung">
                                        <i class="bx bx-time"></i> {{ $plberlangsung }}
                                    </small>
                                    <small class="text-primary fw-semibold" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="Disetujui">
                                        <i class="bx bx-check"></i> {{ $pldisetujui }}
                                    </small>
                                    <small class="text-danger fw-semibold" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="Ditolak">
                                        <i class="bx bx-x"></i> {{ $plditolak }}
                                    </small>
                                    <small class="text-secondary fw-semibold" data-bs-toggle="tooltip"
                                        data-bs-placement="top" data-bs-title="Menunggu">
                                        <i class="bx bx-question-mark"></i> {{ $plmenunggu }}
                                    </small>
                                </div>
                            </div>
                        </center>
                    </div>
                </a>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                <a href="/permohonan">
                    <div class="card">
                        <center>
                            <div class="card-body">
                                <div class="card-title d-flex align-items-center justify-content-center">
                                    <div class="avatar flex-shrink-0">
                                        <i class='fs-1 text-primary bx bx-calendar-event'></i>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block text-black mb-1">Permohonan Kegiatan</span>
                                <h3 class="card-title mb-2">{{ $permohonan }}</h3>
                                <div class="d-flex justify-content-evenly">
                                    <small class="text-success fw-semibold" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="Selesai">
                                        <i class="bx bx-check-double"></i> {{ $prselesai }}
                                    </small>
                                    <small class="text-warning fw-semibold" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="Berlangsung">
                                        <i class="bx bx-time"></i> {{ $prberlangsung }}
                                    </small>

                                    <small class="text-primary fw-semibold" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="Disetujui">
                                        <i class="bx bx-check"></i> {{ $prdisetujui }}
                                    </small>
                                    <small class="text-danger fw-semibold" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="Ditolak">
                                        <i class="bx bx-x"></i> {{ $prditolak }}
                                    </small>
                                    <small class="text-secondary fw-semibold" data-bs-toggle="tooltip"
                                        data-bs-placement="top" data-bs-title="Menunggu">
                                        <i class="bx bx-question-mark"></i> {{ $prmenunggu }}
                                    </small>
                                </div>
                            </div>
                        </center>
                    </div>
                </a>
            </div>
        </div> --}}
        {{-- LOGBOOK --}}
        {{-- <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12 mb-4">
                <a href="/pemakaian">
                    <div class="card">
                        <center>
                            <div class="card-body">
                                <div class="card-title d-flex align-items-center justify-content-center">
                                    <div class="avatar flex-shrink-0">
                                        <i class='fs-1 text-primary bx bx-calendar-minus'></i>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block text-black mb-1">Pemakaian Alat</span>
                                <h3 class="card-title mb-2">{{ $pemakaian }}</h3>
                                <div class="d-flex justify-content-evenly">
                                    <small class="text-success fw-semibold" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="Selesai">
                                        <i class="bx bx-check-circle"></i> {{ $pkselesai }}
                                    </small>
                                    <small class="text-secondary fw-semibold" data-bs-toggle="tooltip"
                                        data-bs-placement="top" data-bs-title="Dimulai">
                                        <i class="bx bx-check"></i> {{ $pkmulai }}
                                    </small>
                                </div>
                            </div>
                        </center>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 mb-4">
                <a href="/peminjamanalat">
                    <div class="card">
                        <center>
                            <div class="card-body">
                                <div class="card-title d-flex align-items-center justify-content-center">
                                    <div class="avatar flex-shrink-0">
                                        <i class='fs-1 text-primary bx bx-calendar-minus'></i>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block text-black mb-1">Peminjaman Alat</span>
                                <h3 class="card-title mb-2">{{ $pakailat }}</h3>
                                <div class="d-flex justify-content-evenly">
                                    <small class="text-success fw-semibold" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="Selesai">
                                        <i class="bx bx-check-double"></i> {{ $pakaiselesai }}
                                    </small>
                                    <small class="text-primary fw-semibold" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="Disetujui">
                                        <i class="bx bx-check"></i> {{ $pakaidisetujui }}
                                    </small>
                                    <small class="text-danger fw-semibold" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="Ditolak">
                                        <i class="bx bx-x"></i> {{ $pakaiditolak }}
                                    </small>
                                    <small class="text-secondary fw-semibold" data-bs-toggle="tooltip"
                                        data-bs-placement="top" data-bs-title="Menunggu">
                                        <i class="bx bx-question-mark"></i> {{ $pakaimenunggu }}
                                    </small>
                                </div>
                            </div>
                        </center>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 mb-4">
                <a href="/penggunaan">
                    <div class="card">
                        <center>
                            <div class="card-body">
                                <div class="card-title d-flex align-items-center justify-content-center">
                                    <div class="avatar flex-shrink-0">
                                        <i class='fs-1 text-primary bx bx-calendar-minus'></i>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block text-black mb-1">Penggunaan Bahan</span>
                                <h3 class="card-title mb-2">
                                    {{ $penggunaan }}
                                </h3>
                                <div class="d-flex justify-content-evenly">
                                    &nbsp;
                                </div>
                            </div>
                        </center>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 mb-4">
                <a href="/peminjamanbahan">
                    <div class="card">
                        <center>
                            <div class="card-body">
                                <div class="card-title d-flex align-items-center justify-content-center">
                                    <div class="avatar flex-shrink-0">
                                        <i class='fs-1 text-primary bx bx-calendar-minus'></i>
                                    </div>
                                </div>
                                <span class="fw-semibold d-block text-black mb-1">Peminjaman Bahan</span>
                                <h3 class="card-title mb-2">{{ $pbahan }}</h3>
                                <div class="d-flex justify-content-evenly">
                                    <small class="text-success fw-semibold" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="Selesai">
                                        <i class="bx bx-check-double"></i> {{ $pbselesai }}
                                    </small>
                                    <small class="text-primary fw-semibold" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="Disetujui">
                                        <i class="bx bx-check"></i> {{ $pbdisetujui }}
                                    </small>
                                    <small class="text-danger fw-semibold" data-bs-toggle="tooltip" data-bs-placement="top"
                                        data-bs-title="Ditolak">
                                        <i class="bx bx-x"></i> {{ $pbditolak }}
                                    </small>
                                    <small class="text-secondary fw-semibold" data-bs-toggle="tooltip"
                                        data-bs-placement="top" data-bs-title="Menunggu">
                                        <i class="bx bx-question-mark"></i> {{ $pbmenunggu }}
                                    </small>
                                </div>
                            </div>
                        </center>
                    </div>
                </a>
            </div>
        </div> --}}

        {{-- AKUN --}}
        {{-- @if (auth()->user()->role == 'admin')
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                    <a href="/dosen">
                        <div class="card">
                            <center>
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-center justify-content-center">
                                        <div class="avatar flex-shrink-0">
                                            <i class='fs-1 text-primary bx bx-group'></i>
                                        </div>
                                    </div>
                                    <span class="fw-semibold d-block text-black mb-1">Dosen</span>
                                    <h3 class="card-title mb-2">{{ $dosen->count() }}</h3>
                                </div>
                            </center>
                        </div>
                    </a>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                    <a href="/mahasiswa">
                        <div class="card">
                            <center>
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-center justify-content-center">
                                        <div class="avatar flex-shrink-0">
                                            <i class='fs-1 text-primary bx bx-group'></i>
                                        </div>
                                    </div>
                                    <span class="fw-semibold d-block text-black mb-1">Mahasiswa</span>
                                    <h3 class="card-title mb-2">{{ $mahasiswa->count() }}</h3>
                                </div>
                            </center>
                        </div>
                    </a>
                </div>
            </div>
        @endif --}}

        {{-- BANNER --}}
        <div class="row">
            <div class="col-lg-12 mb-4 order-0">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-sm-7">
                            <div class="card-body">
                                @if ($role == 'kalab')
                                    <h5 class="card-title text-primary">Selamat Datang Kalab di {{ $lab }} </h5>
                                @else
                                    <h5 class="card-title text-primary">Selamat Datang di Simalakom </h5>
                                @endif
                                <p class="">
                                    Simalakom merupakan website administrasi laboratorium komputer Jurusan Manajemen
                                    Informatika
                                    Politeknik Negeri Subang
                                </p>

                                {{-- <a href="/scan" class="btn btn-sm btn-outline-primary">Scan QR</a> --}}
                            </div>
                        </div>
                        <div class="col-sm-5 text-center text-sm-left">
                            <div class="card-body">
                                <img src="{{ asset('img') }}/politeknik-subang.jpg" height="140" alt="View Badge User"
                                    data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- JUMLAH DATA --}}
        <div class="row">
            {{-- LABORATORIUM --}}
            <div class="col-lg-2 col-md-3 order-1">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12 mb-4">
                        <div class="card">
                            <center>
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-center justify-content-center">
                                        <div class="avatar flex-shrink-0">
                                            <i class='fs-1 text-primary bx bx-door-open'></i>
                                        </div>
                                    </div>
                                    <span class="fw-semibold d-block text-black mb-1">Laboratorium</span>
                                    <h3 class="card-title mb-2">{{ $laboratorium->count() }}</h3>
                                </div>
                            </center>
                        </div>
                    </div>

                </div>
            </div>
            {{-- KELAS --}}
            <div class="col-lg-2 col-md-3 order-2">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12 mb-4">
                        <div class="card">
                            <center>
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-center justify-content-center">
                                        <div class="avatar flex-shrink-0">
                                            <i class='fs-1 text-primary bx bx-chalkboard'></i>
                                        </div>
                                    </div>
                                    <span class="fw-semibold d-block text-black mb-1">Kelas</span>
                                    <h3 class="card-title mb-2">{{ $kelas->count() }}</h3>
                                </div>
                            </center>
                        </div>
                    </div>

                </div>
            </div>
            {{-- ALAT --}}
            <div class="col-lg-2 col-md-2 order-3">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12 mb-4">
                        <div class="card">
                            <center>
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-center justify-content-center">
                                        <div class="avatar flex-shrink-0">
                                            <i class='fs-1 text-primary bx bx-wrench'></i>
                                        </div>
                                    </div>
                                    <span class="fw-semibold d-block text-black mb-1">Alat</span>
                                    <h3 class="card-title mb-2">{{ $barangpakai->count() }}</h3>
                                </div>
                            </center>
                        </div>
                    </div>

                </div>
            </div>
            {{-- BAHAN PRAKTIKUM --}}
            <div class="col-lg-3 col-md-2 order-4">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12 mb-4">
                        <div class="card">
                            <center>
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-center justify-content-center">
                                        <div class="avatar flex-shrink-0">
                                            <i class='fs-1 text-primary bx bx-package'></i>
                                        </div>
                                    </div>
                                    <span class="fw-semibold d-block text-black mb-1">Bahan Praktikum</span>
                                    <h3 class="card-title mb-2">{{ $bahanpraktikum->count() }}</h3>
                                </div>
                            </center>
                        </div>
                    </div>

                </div>
            </div>
            {{-- BAHAN JURUSAN --}}
            <div class="col-lg-3 col-md-2 order-5">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12 mb-4">
                        <div class="card">
                            <center>
                                <div class="card-body">
                                    <div class="card-title d-flex align-items-center justify-content-center">
                                        <div class="avatar flex-shrink-0">
                                            <i class='fs-1 text-primary bx bx-box'></i>
                                        </div>
                                    </div>
                                    <span class="fw-semibold d-block text-black mb-1">Bahan Jurusan</span>
                                    <h3 class="card-title mb-2">{{ $bahanjurusan->count() }}</h3>
                                </div>
                            </center>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- LOGBOOK TERBARU --}}
        <div class="row">
            <div class="col-6 col-lg-6 order-1 order-md-1 order-lg-1 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-center">
                        <h5 class="card-title m-0 me-2">Pemakaian Alat</h5>
                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0">
                            @foreach ($pemakaian as $pakai)
                                <a href="/pemakaian/{{ $pakai->id }}">
                                    <li class="d-flex mb-4 pb-1">
                                        <div class="d-flex justify-content-between">
                                            <div class="avatar flex-shrink-0 me-3">
                                                <span class="avatar-initial rounded bg-label-danger">
                                                    {{-- <i class="bx bx-door-open"></i> --}}
                                                    @if ($pakai->barangpakai->foto ?? $pakai->foto)
                                                        <img src="{{ asset('storage') . '/' . $pakai->barangpakai->foto ?? $pakai->foto }}"
                                                            alt="">
                                                    @elseif ($pakai->foto)
                                                        <img src="{{ asset('storage') . '/' . $pakai->foto }}"
                                                            alt="">
                                                    @else
                                                        <img src="{{ asset('img') }}/unknown.png" alt="">
                                                    @endif
                                                </span>
                                            </div>
                                            <div
                                                class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                <div class="me-2">
                                                    <small
                                                        class="text-muted d-block mb-1">{{ $pakai->user->nama ?? $pakai->namauser }}
                                                        <i
                                                            class="fw-lighter">({{ \Carbon\Carbon::parse($pakai->created_at)->diffForHumans() }})</i>
                                                    </small>
                                                    <h6 class="mb-0">
                                                        <a href="/pemakaian/{{ $pakai->id }}" class="text-wrap">
                                                            {{ $pakai->barangpakai->nama ?? $pakai->namabarang }} &nbsp; -
                                                            &nbsp;
                                                            {{ $pakai->kegiatan->nama ?? $pakai->namakegiatan }}
                                                            ({{ $pakai->status }})
                                                        </a>
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </a>
                            @endforeach
                            <li class="d-flex justify-content-center">
                                <a href="/pemakaian" class="btn btn-sm btn-outline-primary">Pemakaian Alat Lainnya</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-6 order-2 order-md-2 order-lg-2 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-center">
                        <h5 class="card-title m-0 me-2">Penggunaan Bahan</h5>
                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0">
                            @foreach ($penggunaan as $guna)
                                <a href="/penggunaan/{{ $guna->id }}">
                                    <li class="d-flex mb-4 pb-1">
                                        <div class="d-flex justify-content-between">
                                            <div class="avatar flex-shrink-0 me-3">
                                                <span class="avatar-initial rounded bg-label-danger">
                                                    {{-- <i class="bx bx-door-open"></i> --}}
                                                    @if ($guna->bahanpraktikum->foto ?? $guna->foto)
                                                        <img src="{{ asset('storage') . '/' . $guna->bahanpraktikum->foto ?? $guna->foto }}"
                                                            alt="">
                                                    @elseif ($guna->foto)
                                                        <img src="{{ asset('storage') . '/' . $guna->foto }}"
                                                            alt="">
                                                    @else
                                                        <img src="{{ asset('img') }}/unknown.png" alt="">
                                                    @endif
                                                </span>
                                            </div>
                                            <div
                                                class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                <div class="me-2">
                                                    <small
                                                        class="text-muted d-block mb-1">{{ $guna->user->nama ?? $guna->namauser }}
                                                        <i
                                                            class="fw-lighter">({{ \Carbon\Carbon::parse($guna->created_at)->diffForHumans() }})</i>
                                                    </small>
                                                    <h6 class="mb-0">
                                                        <a href="/pemakaian/{{ $guna->id }}" class="text-wrap">
                                                            {{ $guna->bahanpraktikum->nama ?? $guna->namabahan }} &nbsp; -
                                                            &nbsp;
                                                            {{ $guna->kegiatan->nama ?? $guna->namakegiatan }}
                                                        </a>
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </a>
                            @endforeach
                            <li class="d-flex justify-content-center">
                                <a href="/penggunaan" class="btn btn-sm btn-outline-primary">Penggunaan Bahan Lainnya</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6 col-lg-6 order-1 order-md-1 order-lg-1 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-center">
                        <h5 class="card-title m-0 me-2">Peminjaman Alat</h5>
                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0">
                            @foreach ($palat as $pal)
                                <a href="/peminjamanalat/{{ $pal->id }}">
                                    <li class="d-flex mb-4 pb-1">
                                        <div class="d-flex justify-content-between">
                                            <div class="avatar flex-shrink-0 me-3">
                                                <span class="avatar-initial rounded bg-label-danger">
                                                    {{-- <i class="bx bx-door-open"></i> --}}
                                                    @if ($pal->barangpakai->foto ?? $pal->foto)
                                                        <img src="{{ asset('storage') . '/' . $pal->barangpakai->foto ?? $pal->foto }}"
                                                            alt="">
                                                    @elseif ($pal->foto)
                                                        <img src="{{ asset('storage') . '/' . $pal->foto }}"
                                                            alt="">
                                                    @else
                                                        <img src="{{ asset('img') }}/unknown.png" alt="">
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="w-100 gap-2">
                                                <div class="me-2">
                                                    <small
                                                        class="text-muted d-block mb-1">{{ $pal->user->nama ?? $pal->namauser }}
                                                        <i
                                                            class="fw-lighter">({{ \Carbon\Carbon::parse($pal->updated_at)->diffForHumans() }})</i>
                                                    </small>
                                                    <h6 class="mb-0">
                                                        <a href="/peminjamanalat/{{ $pal->id }}" class="text-wrap">
                                                            {{ $pal->barangpakai->nama ?? $pal->namabarang }} &nbsp; -
                                                            &nbsp;
                                                            {{ $pal->deskripsi ?? $pal->deskripsi }}
                                                            ({{ $pal->status ?? $pal->status }})
                                                        </a>
                                                    </h6>
                                                </div>
                                                <div class="user-progress mt-2 d-flex justify-content-start">
                                                    @if ($role == 'kalab' && $pal->status == 'menunggu')
                                                        <form action="/peminjamanalat/{{ $pal->id }}/status"
                                                            method="post">
                                                            @csrf
                                                            <input type="hidden" name="status" value="disetujui">
                                                            <button type="submit" class="btn btn-outline-primary p-1"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                data-bs-title="Setuju">
                                                                <i class='bx bx-message-square-check'></i>
                                                            </button>
                                                        </form>
                                                        <a class="btn btn-outline-danger p-1" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" data-bs-title="Tolak"
                                                            href="/peminjamanalat/{{ $pal->id }}/ditolak">
                                                            <i class="bx bx-message-square-x"></i>
                                                        </a>
                                                    @elseif ($role == 'mahasiswa' && $pal->status == 'disetujui')
                                                        <form action="/peminjamanalat/{{ $pal->id }}/status"
                                                            method="post">
                                                            @csrf
                                                            <input type="hidden" name="status" value="selesai">
                                                            <input type="hidden" name="tgl_kembali"
                                                                value="{{ Date('Y-m-d H:i:s') }}">
                                                            <button type="submit" class="btn btn-outline-primary p-1"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                data-bs-title="Kembalikan">
                                                                <i class='bx bx-arrow-to-left'></i> </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </a>
                            @endforeach
                            <li class="d-flex justify-content-center">
                                <a href="/peminjamanalat" class="btn btn-sm btn-outline-primary">Peminjaman Alat
                                    Lainnya</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-6 col-lg-6 order-2 order-md-2 order-lg-2 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-center">
                        <h5 class="card-title m-0 me-2">Peminjaman Bahan</h5>
                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0">
                            @foreach ($pbahan as $pab)
                                <a href="/peminjamanbahan/{{ $pab->id }}">
                                    <li class="d-flex mb-4 pb-1">
                                        <div class="d-flex justify-content-between">
                                            <div class="avatar flex-shrink-0 me-3">
                                                <span class="avatar-initial rounded bg-label-danger">
                                                    {{-- <i class="bx bx-door-open"></i> --}}
                                                    @if ($pab->bahanjurusan->foto ?? $pab->foto)
                                                        <img src="{{ asset('storage') . '/' . $pab->bahanjurusan->foto ?? $pab->foto }}"
                                                            alt="">
                                                    @elseif ($pab->foto)
                                                        <img src="{{ asset('storage') . '/' . $pakai->foto }}"
                                                            alt="">
                                                    @else
                                                        <img src="{{ asset('img') }}/unknown.png" alt="">
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="w-100 gap-2">
                                                <div class="me-2">
                                                    <small
                                                        class="text-muted d-block mb-1">{{ $pab->user->nama ?? $pab->namauser }}
                                                        <i
                                                            class="fw-lighter">({{ \Carbon\Carbon::parse($pab->updated_at)->diffForHumans() }})</i>
                                                    </small>
                                                    <h6 class="mb-0">
                                                        <a href="/peminjamanalat/{{ $pab->id }}" class="text-wrap">
                                                            {{ $pab->bahanjurusan->nama ?? $pab->namabarang }}
                                                            &nbsp; -
                                                            &nbsp;
                                                            {{ $pab->deskripsi ?? $pab->deskripsi }}
                                                            ({{ $pab->status ?? $pab->status }})
                                                        </a>
                                                    </h6>
                                                </div>
                                                <div class="user-progress mt-2 d-flex justify-content-start">
                                                    @if ($role == 'kalab' && $pab->status == 'menunggu')
                                                        <form action="/peminjamanbahan/{{ $pab->id }}/status"
                                                            method="post">
                                                            @csrf
                                                            <input type="hidden" name="status" value="disetujui">
                                                            <button type="submit" class="btn btn-outline-primary p-1"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                data-bs-title="Setuju">
                                                                <i class='bx bx-message-square-check'></i>
                                                            </button>
                                                        </form>
                                                        <a class="btn btn-outline-danger p-1" data-bs-toggle="tooltip"
                                                            data-bs-placement="top" data-bs-title="Tolak"
                                                            href="/peminjamanbahan/{{ $pab->id }}/ditolak">
                                                            <i class="bx bx-message-square-x"></i>
                                                        </a>
                                                    @elseif ($role == 'mahasiswa' && $pab->status == 'disetujui')
                                                        <form action="/peminjamanbahan/{{ $peminjamanbahan->id }}"
                                                            method="post">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="selesai">
                                                            <input type="hidden" name="tgl_kembali"
                                                                value="{{ Date('Y-m-d H:i:s') }}">
                                                            <button type="submit" class="btn btn-outline-primary p-1"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                data-bs-title="Kembalikan">
                                                                <i class='bx bx-arrow-to-left'></i> </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </a>
                            @endforeach
                            <li class="d-flex justify-content-center">
                                <a href="/peminjamanbahan" class="btn btn-sm btn-outline-primary">Peminjaman Bahan
                                    Lainnya</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
