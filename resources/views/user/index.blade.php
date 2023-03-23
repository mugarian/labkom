@extends('layout.main')
@section('container')
<!-- Bordered Table -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-3"><span class="text-muted fw-light">Akun /</span> Kelola Akun</h4>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Kelola Akun</h5>
            <small class="text-muted float-end"><a href="/akun/create"><button class="btn btn-primary">Tambah</button></a></small>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                <tr class="text-center">
                    <th style="width: 0">#</th>
                    <th style="width: 0">Nomor Induk</th>
                    <th style="width: 0">Nama</th>
                    <th style="width: 0">Jabatan</th>
                    <th style="width: 0">No HP</th>
                    <th>Alamat</th>
                    <th style="width: 0">Status</th>
                    <th style="width: 0">Aksi</th>
                </tr>
                </thead>
                <tbody class="text-center">
                    @foreach ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->nomor_induk }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->jabatan }}</td>
                        <td>{{ $user->no_hp }}</td>
                        <td>{{ $user->alamat }}</td>
                        <td>{{ $user->status }}</td>
                        <td>
                        <div class="dropdown">
                            <button
                            type="button"
                            class="btn p-0 dropdown-toggle hide-arrow"
                            data-bs-toggle="dropdown"
                            >
                            <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                            <a class="dropdown-item" href="/akun/{{ $user->nomor_induk }}"
                                ><i class="bx bx-info-circle me-1"></i> Lihat</a
                            >
                            <a class="dropdown-item" href="/akun/{{ $user->nomor_induk }}/edit"
                                ><i class="bx bx-edit-alt me-1"></i> Edit</a
                            >
                            <form action="/akun/{{ $user->nomor_induk }}" method="POST" class="">
                                @method('delete')
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="bx bx-trash me-1"></i> Delete</button>
                            </form>
                            {{-- <a class="dropdown-item" href="javascript:void(0);"
                                ><i class="bx bx-trash me-1"></i> Delete</a
                            > --}}
                            </div>
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
