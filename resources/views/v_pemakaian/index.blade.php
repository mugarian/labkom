@extends('layout.main')
@section('container')
    <!-- Bordered Table -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">
                <a href="/pemakaian" class="text-secondary">pemakaian</a>
                /</span> Kelola pemakaian
        </h4>
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Kelola pemakaian</h5>
                <div class="d-flex justify-content-end @if ($akhir->status == 'mulai') d-none @endif">
                    <small class="text-muted float-end">
                        <a href="/pemakaian/create">
                            <button class="btn btn-primary">pemakaian</button>
                        </a>
                    </small>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 0">#</th>
                                <th>Barang</th>
                                <th>Kegiatan</th>
                                <th>Oleh</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($pemakaians as $pemakaian)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pemakaian->barangpakai->nama }}
                                        <br>({{ $pemakaian->kegiatan->laboratorium->nama }})
                                    </td>
                                    <td>{{ $pemakaian->kegiatan->nama }}</td>
                                    <td>{{ $pemakaian->user->nama }}</td>
                                    <td>{{ $pemakaian->mulai }}</td>
                                    <td>
                                        @if ($pemakaian->status == 'mulai')
                                            <div id="todaysDate">

                                            </div>
                                        @else
                                            {{ $pemakaian->selesai }} <br>({{ $pemakaian->status }})
                                    </td>
                            @endif
                            <td>
                                <div class="d-flex justify-content-center">
                                    <a class="btn btn-outline-success p-1" href="/pemakaian/{{ $pemakaian->id }}"><i
                                            class="bx bx-info-circle"></i></a>
                                    @if ($pemakaian->status == 'mulai')
                                        <a class="btn btn-outline-primary p-1"
                                            href="/pemakaian/{{ $pemakaian->id }}/edit"><i
                                                class='bx bx-calendar-check'></i>
                                        </a>
                                        {{-- <form action="/pk/{{ $pemakaian->id }}/done" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-primary p-1">
                                                <i class='bx bx-calendar-check'></i>
                                            </button>
                                        </form> --}}
                                    @endif
                                </div>
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--/ Bordered Table -->
    </div>
    @if ($akhir->status == 'mulai')
        <script>
            function padTo2Digits(num) {
                return num.toString().padStart(2, '0');
            }

            function formatDate(date) {
                return (
                    [
                        date.getFullYear(),
                        padTo2Digits(date.getMonth() + 1),
                        padTo2Digits(date.getDate()),
                    ].join('-') +
                    ' ' + [
                        padTo2Digits(date.getHours()),
                        padTo2Digits(date.getMinutes()),
                        padTo2Digits(date.getSeconds()),
                    ].join(':')
                );
            }

            function showDate() {
                document.getElementById("todaysDate").innerHTML = formatDate(new Date());
            }

            setInterval(showDate, 1000);
        </script>
    @endif
@endsection
