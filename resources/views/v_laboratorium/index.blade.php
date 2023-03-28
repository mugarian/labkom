@extends('layout.main')
@section('container')
    <!-- Bordered Table -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">
                <a href="/laboratorium" class="text-secondary">Laborotorium</a> /</span> Kelola laborotorium</h4>
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Kelola Laboratorium</h5>
                @if (auth()->user()->role == 'admin')
                    <small class="text-muted float-end"><a href="/laboratorium/create"><button
                                class="btn btn-primary">Tambah</button></a></small>
                @endif
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 0">#</th>
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Kepala Lab</th>
                                <th>Deskripsi</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($laboratoriums as $laboratorium)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td style="width:10%">
                                        @if ($laboratorium->foto)
                                            <img src="{{ asset('storage') . '/' . $laboratorium->foto }}"
                                                alt="laboratorium-avatar" class="d-block rounded img-preview" height="100"
                                                width="100" id="uploadedAvatar" />
                                        @else
                                            <img src="{{ asset('img') }}/unknown.png" alt="user-avatar"
                                                class="d-block rounded img-preview" height="100" width="100"
                                                id="uploadedAvatar" />
                                        @endif
                                    </td>
                                    <td>{{ $laboratorium->nama }}</td>
                                    <td>{{ $laboratorium->user->nama }}</td>
                                    <td>{{ $laboratorium->deskripsi }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a class="btn btn-outline-success p-1"
                                                href="/laboratorium/{{ $laboratorium->id }}"><i
                                                    class="bx bx-info-circle"></i></a>
                                            @if (auth()->user()->id == $laboratorium->user->id || auth()->user()->role == 'admin')
                                                <a class="btn btn-outline-warning p-1"
                                                    href="/laboratorium/{{ $laboratorium->id }}/edit"><i
                                                        class="bx bx-edit-alt"></i></a>
                                                @if (auth()->user()->role == 'admin')
                                                    <form action="/laboratorium/{{ $laboratorium->id }}" method="post">
                                                        @method('delete')
                                                        @csrf
                                                        <button type="submit" class="btn btn-outline-danger p-1">
                                                            <i class="bx bx-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
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
@endsection
