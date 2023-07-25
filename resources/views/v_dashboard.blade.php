@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">

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
                    <a href="/laboratorium">
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
                    </a>
                </div>
            </div>
            {{-- KELAS --}}
            <div class="col-lg-2 col-md-3 order-2">
                <div class="row">
                    <a href="/kelas">
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
                    </a>
                </div>
            </div>
            {{-- ALAT --}}
            <div class="col-lg-2 col-md-2 order-3">
                <div class="row">
                    <a href="/alat">
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
                    </a>
                </div>
            </div>
            {{-- BAHAN PRAKTIKUM --}}
            <div class="col-lg-3 col-md-2 order-4">
                <div class="row">
                    <a href="/bahanpraktikum">
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
                    </a>
                </div>
            </div>
            {{-- BAHAN JURUSAN --}}
            <div class="col-lg-3 col-md-2 order-5">
                <div class="row">
                    <a href="/bahanjurusan">
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
                    </a>
                </div>
            </div>
        </div>

        {{-- KEGIATAN TERBARU --}}
        <div class="row">
            {{-- PELAKSANAAN KEGIATAN --}}
            <div class="col-lg-6 col-sm order-1 order-md-1 order-lg-1 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-center">
                        <h5 class="card-title m-0 me-2">Pelaksanaan Kegiatan</h5>
                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0">
                            @foreach ($pelaksanaans as $pelaksanaan)
                                @if ($pelaksanaan->jenis == 'permohonan')
                                    @continue
                                @endif
                                <a href="/pelaksanaan/{{ $pelaksanaan->id }}">
                                    <li class="d-flex mb-4 pb-1">
                                        <div class="d-flex justify-content-between">
                                            <div class="avatar flex-shrink-0 me-3">
                                                <span class="avatar-initial rounded bg-label-primary">
                                                    <i class="bx bx-calendar-week"></i>
                                                </span>
                                            </div>
                                            <div class="w-100 gap-2">
                                                <div class="me-2">
                                                    <small
                                                        class="text-muted d-block mb-1">{{ $pelaksanaan->user->nama ?? $pelaksanaan->namauser }}
                                                        <i
                                                            class="fw-lighter">({{ \Carbon\Carbon::parse($pelaksanaan->created_at)->diffForHumans() }})</i>
                                                    </small>
                                                    <h6 class="mb-0">
                                                        <a href="/pelaksanaan/{{ $pelaksanaan->id }}" class="text-wrap">
                                                            {{ $pelaksanaan->nama ?? $pelaksanaan->namakegiatan }} di
                                                            {{ $pelaksanaan->laboratorium->nama ?? $pelaksanaan->namalab }}
                                                            -
                                                            {{ $pelaksanaan->kelas->nama }}
                                                            ({{ $pelaksanaan->status }})
                                                        </a>
                                                    </h6>
                                                </div>
                                                <div class="user-progress mt-2 d-flex justify-content-start">
                                                    @if ($pelaksanaan->user_id == auth()->user()->id || $pelaksanaan->dospem->user_id == auth()->user()->id)
                                                        @if ($pelaksanaan->status == 'berlangsung')
                                                            <form action="/pelaksanaan/{{ $pelaksanaan->id }}"
                                                                method="post">
                                                                @csrf
                                                                @method('put')
                                                                <input type="hidden" name="status" value="selesai">
                                                                <button type="submit" class="btn btn-outline-primary p-1"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    data-bs-title="Selesai">
                                                                    <i class='bx bx-message-square-check'></i>
                                                                </button>
                                                            </form>
                                                        @elseif ($pelaksanaan->status == 'terjadwal')
                                                            <form action="/pelaksanaan/{{ $pelaksanaan->id }}"
                                                                method="post">
                                                                @csrf
                                                                @method('put')
                                                                <input type="hidden" name="status" value="berlangsung">
                                                                <button type="submit" class="btn btn-outline-primary p-1"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    data-bs-title="Jadi">
                                                                    <i class='bx bx-calendar-check'></i>
                                                                </button>
                                                            </form>
                                                            <form action="/pelaksanaan/{{ $pelaksanaan->id }}"
                                                                method="post">
                                                                @csrf
                                                                @method('put')
                                                                <input type="hidden" name="status" value="ditolak">
                                                                <button type="submit" class="btn btn-outline-danger p-1"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    data-bs-title="Tidak Jadi">
                                                                    <i class='bx bx-calendar-x'></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </a>
                            @endforeach
                            <li class="d-flex justify-content-center">
                                <a href="/pelaksanaan" class="btn btn-sm btn-outline-primary">Pelaksanaan Kegiatan
                                    Lainnya</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- PERMOHONAN KEGIATAN --}}
            <div class="col-lg-6 col-sm order-1 order-md-1 order-lg-1 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-center">
                        <h5 class="card-title m-0 me-2">Permohonan Kegiatan</h5>
                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0">
                            @foreach ($permohonans as $permohonan)
                                @if ($permohonan->jenis == 'pelaksanaan')
                                    @continue
                                @endif
                                <a href="/permohonan/{{ $permohonan->id }}">
                                    <li class="d-flex mb-4 pb-1">
                                        <div class="d-flex justify-content-between">
                                            <div class="avatar flex-shrink-0 me-3">
                                                <span class="avatar-initial rounded bg-label-primary">
                                                    <i class="bx bx-calendar-week"></i>
                                                </span>
                                            </div>
                                            <div class="w-100 gap-2">
                                                <div class="me-2">
                                                    <small
                                                        class="text-muted d-block mb-1">{{ $permohonan->user->nama ?? $permohonan->namauser }}
                                                        <i
                                                            class="fw-lighter">({{ \Carbon\Carbon::parse($permohonan->created_at)->diffForHumans() }})</i>
                                                    </small>
                                                    <h6 class="mb-0">
                                                        <a href="/permohonan/{{ $permohonan->id }}" class="text-wrap">
                                                            {{ $permohonan->nama ?? $permohonan->namakegiatan }} di
                                                            {{ $permohonan->laboratorium->nama ?? $permohonan->namalab }}
                                                            -
                                                            {{ $permohonan->kelas->nama }}
                                                            ({{ $permohonan->status }})
                                                        </a>
                                                    </h6>
                                                </div>
                                                <div class="user-progress mt-2 d-flex justify-content-start">
                                                    @if ($permohonan->user_id == auth()->user()->id)
                                                        @if ($permohonan->status == 'disetujui')
                                                            <form action="/permohonan/{{ $permohonan->id }}"
                                                                method="post">
                                                                @csrf
                                                                @method('put')
                                                                <input type="hidden" name="status" value="berlangsung">
                                                                <input type="hidden" name="mulai"
                                                                    value="{{ Date('Y-m-d H:i:s') }}">
                                                                <button type="submit" class="btn btn-outline-primary p-1"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    data-bs-title="Mulai">
                                                                    <i class='bx bx-message-square-check'></i> </button>
                                                            </form>
                                                        @elseif ($permohonan->status == 'berlangsung')
                                                            <form action="/permohonan/{{ $permohonan->id }}"
                                                                method="post">
                                                                @csrf
                                                                @method('put')
                                                                <input type="hidden" name="status" value="selesai">
                                                                <input type="hidden" name="selesai"
                                                                    value="{{ Date('Y-m-d H:i:s') }}">
                                                                <button type="submit" class="btn btn-primary p-1"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    data-bs-title="Selesai">
                                                                    <i class='bx bx-message-square-check'></i> </button>
                                                            </form>
                                                        @endif
                                                        {{-- Dospem --}}
                                                    @elseif ($permohonan->dospem->user_id == auth()->user()->id)
                                                        @if ($permohonan->verif_dospem == 'menunggu')
                                                            <form action="/permohonan/{{ $permohonan->id }}"
                                                                method="post">
                                                                @csrf
                                                                @method('put')
                                                                <input type="hidden" name="verif_dospem"
                                                                    value="disetujui">
                                                                <input type="hidden" name="verif_kalab"
                                                                    value="menunggu">
                                                                <input type="hidden" name="status" value="menunggu">
                                                                <button type="submit" class="btn btn-outline-primary p-1"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    data-bs-title="Setuju">
                                                                    <i class='bx bx-message-square-check'></i>
                                                                </button>
                                                            </form>
                                                            <a href="/permohonan/{{ $permohonan->id }}/ditolak"
                                                                class="btn btn-outline-danger p-1"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                data-bs-title="Tolak">
                                                                <i class='bx bx-message-square-x'></i>
                                                            </a>
                                                        @endif
                                                        {{-- Kalab --}}
                                                    @elseif ($permohonan->laboratorium->user_id == auth()->user()->id)
                                                        @if ($permohonan->verif_dospem == 'disetujui' && $permohonan->verif_kalab == 'menunggu')
                                                            <form action="/permohonan/{{ $permohonan->id }}"
                                                                method="post">
                                                                @csrf
                                                                @method('put')
                                                                <input type="hidden" name="verif_dospem"
                                                                    value="disetujui">
                                                                <input type="hidden" name="verif_kalab"
                                                                    value="disetujui">
                                                                <input type="hidden" name="status" value="disetujui">
                                                                <button type="submit" class="btn btn-outline-primary p-1"
                                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                                    data-bs-title="Setuju">
                                                                    <i class='bx bx-message-square-check'></i>
                                                                </button>
                                                            </form>
                                                            <a href="/permohonan/{{ $permohonan->id }}/ditolak"
                                                                class="btn btn-outline-danger p-1"
                                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                                data-bs-title="Tolak">
                                                                <i class='bx bx-message-square-x'></i>
                                                            </a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </a>
                            @endforeach
                            <li class="d-flex justify-content-center">
                                <a href="/permohonan" class="btn btn-sm btn-outline-primary">permohonan Kegiatan
                                    Lainnya</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- LOGBOOK TERBARU --}}
        <div class="row">
            <div class="col-lg-6 col-sm order-1 order-md-1 order-lg-1 mb-4">
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
                                                <span class="avatar-initial rounded bg-label-primary">
                                                    <i class="bx bx-wrench"></i>
                                                    {{-- @if ($role == 'kalab')
                                                        @if ($pakai->foto)
                                                            <img src="{{ asset('storage') . '/' .  $pakai->foto }}"
                                                                alt="">
                                                        @else
                                                            <img src="{{ asset('img') }}/unknown.png" alt="">
                                                        @endif
                                                    @else
                                                        @if ($pakai->barangpakai->foto)
                                                            <img src="{{ asset('storage') . '/' . $pakai->barangpakai->foto}}"
                                                                alt="">
                                                        @else
                                                            <img src="{{ asset('img') }}/unknown.png" alt="">
                                                        @endif
                                                    @endif --}}
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
            <div class="col-lg-6 col-sm order-2 order-md-2 order-lg-2 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-center">
                        <h5 class="card-title m-0 me-2">Penggunaan Bahan Praktikum</h5>
                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0">
                            @foreach ($penggunaan as $guna)
                                <a href="/penggunaan/{{ $guna->id }}">
                                    <li class="d-flex mb-4 pb-1">
                                        <div class="d-flex justify-content-between">
                                            <div class="avatar flex-shrink-0 me-3">
                                                <span class="avatar-initial rounded bg-label-primary">
                                                    <i class="bx bx-package"></i>
                                                    {{-- @if ($guna->foto)
                                                        <img src="{{ asset('storage') . '/' . $guna->foto }}"
                                                            alt="">
                                                    @elseif ($guna->bahanpraktikum->foto)
                                                        <img src="{{ asset('storage') . '/' . $guna->bahanpraktikum->foto }}"
                                                            alt="">
                                                    @else
                                                        <img src="{{ asset('img') }}/unknown.png" alt="">
                                                    @endif --}}
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
                                                        <a href="/penggunaan/{{ $guna->id }}" class="text-wrap">
                                                            {{ $guna->bahanpraktikum->nama ?? $guna->namabahan }}
                                                            &nbsp; - &nbsp;
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

        {{-- PEMINJAMAN TERBARU --}}
        <div class="row">
            <div class="col-lg-6 col-sm order-1 order-md-1 order-lg-1 mb-4">
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
                                                <span class="avatar-initial rounded bg-label-primary">
                                                    <i class="bx bx-calendar-minus"></i>
                                                    {{-- @if ($pal->barangpakai->foto ?? $pal->foto)
                                                        <img src="{{ asset('storage') . '/' . $pal->barangpakai->foto ?? $pal->foto }}"
                                                            alt="">
                                                    @elseif ($pal->foto)
                                                        <img src="{{ asset('storage') . '/' . $pal->foto }}"
                                                            alt="">
                                                    @else
                                                        <img src="{{ asset('img') }}/unknown.png" alt="">
                                                    @endif --}}
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
            <div class="col-lg-6 col-sm order-2 order-md-2 order-lg-2 mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-center">
                        <h5 class="card-title m-0 me-2">Peminjaman Bahan Jurusan</h5>
                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0">
                            @foreach ($pbahan as $pab)
                                <a href="/peminjamanbahan/{{ $pab->id }}">
                                    <li class="d-flex mb-4 pb-1">
                                        <div class="d-flex justify-content-between">
                                            <div class="avatar flex-shrink-0 me-3">
                                                <span class="avatar-initial rounded bg-label-primary">
                                                    <i class="bx bx-calendar-minus"></i>
                                                    {{-- @if ($pab->bahanjurusan->foto ?? $pab->foto)
                                                        <img src="{{ asset('storage') . '/' . $pab->bahanjurusan->foto ?? $pab->foto }}"
                                                            alt="">
                                                    @elseif ($pab->foto)
                                                        <img src="{{ asset('storage') . '/' . $pakai->foto }}"
                                                            alt="">
                                                    @else
                                                        <img src="{{ asset('img') }}/unknown.png" alt="">
                                                    @endif --}}
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
                                                        <a href="/peminjamanbahan/{{ $pab->id }}" class="text-wrap">
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
