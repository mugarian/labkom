@extends('layout.main')
@section('container')
    <!-- Bordered Table -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><a href="/dosen" class="text-secondary">Data Dosen</a></h4>
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Kelola Dosen</h5>
                <small class="text-muted float-end"><a href="/dosen/create"><button
                            class="btn btn-primary">Tambah</button></a></small>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>Foto</th>
                                <th style="width: 0">NIP/NIK</th>
                                <th>Nama</th>
                                <th>Jurusan</th>
                                <th>Email</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($dosens as $dosen)
                                <tr>
                                    <td style="width:10%">
                                        @if ($dosen->foto)
                                            <img src="{{ asset('storage') . '/' . $dosen->foto }}" alt="dosen-avatar"
                                                class="d-block rounded img-preview" height="100" width="100"
                                                id="uploadedAvatar" />
                                        @else
                                            <img src="{{ asset('img') }}/unknown.png" alt="user-avatar"
                                                class="d-block rounded img-preview" height="100" width="100"
                                                id="uploadedAvatar" />
                                        @endif
                                    </td>
                                    <td>{{ $dosen->user->nomor_induk }}</td>
                                    <td>{{ $dosen->user->nama }}</td>
                                    <td>{{ $dosen->jurusan }}</td>
                                    <td>{{ $dosen->user->email }}</td>
                                    <td>

                                        <div class="d-flex justify-content-center">
                                            <a class="btn btn-outline-success p-1" href="/dosen/{{ $dosen->id }}"><i
                                                    class="bx bx-info-circle"></i></a>
                                            <a class="btn btn-outline-warning p-1" href="/dosen/{{ $dosen->id }}/edit"><i
                                                    class="bx bx-edit-alt"></i></a>
                                            <form action="/dosen/{{ $dosen->id }}" method="post">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger p-1">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </form>
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
