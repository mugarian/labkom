@extends('layout.main')
@section('container')
    <!-- Bordered Table -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">
                <a href="/staff" class="text-secondary">staff</a>
                /</span> Kelola staff</h4>
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Kelola staff</h5>
                <small class="text-muted float-end"><a href="/staff/create"><button
                            class="btn btn-primary">Tambah</button></a></small>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>Foto</th>
                                <th style="width: 0">NIM</th>
                                <th>Nama</th>
                                <th>Bidang</th>
                                <th>Email</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($staffs as $staff)
                                <tr>
                                    <td style="width:10%">
                                        @if ($staff->foto)
                                            <img src="{{ asset('storage') . '/' . $staff->foto }}" alt="staff-avatar"
                                                class="d-block rounded img-preview" height="100" width="100"
                                                id="uploadedAvatar" />
                                        @else
                                            <img src="{{ asset('img') }}/unknown.png" alt="user-avatar"
                                                class="d-block rounded img-preview" height="100" width="100"
                                                id="uploadedAvatar" />
                                        @endif
                                    </td>
                                    <td>{{ $staff->user->nomor_induk }}</td>
                                    <td>{{ $staff->user->nama }}</td>
                                    <td>{{ $staff->bidang }}</td>
                                    <td>{{ $staff->user->email }}</td>
                                    <td>

                                        <div class="d-flex justify-content-center">
                                            <a class="btn btn-outline-success p-1" href="/staff/{{ $staff->id }}"><i
                                                    class="bx bx-info-circle"></i></a>
                                            <a class="btn btn-outline-warning p-1" href="/staff/{{ $staff->id }}/edit"><i
                                                    class="bx bx-edit-alt"></i></a>
                                            <form action="/staff/{{ $staff->id }}" method="post">
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
