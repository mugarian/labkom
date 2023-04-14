@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">
                <a href="/staff" class="text-secondary">Data Staff</a> /
            </span> {{ $staff->user->nama }}
        </h4>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">staff</h5>
                        <small class="text-muted float-end"><a href="/staff">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="nama">Nama</label>
                            <p class="form-control">{{ $staff->user->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="nomor_induk">Nomor Induk</label>
                            <p class="form-control">{{ $staff->user->nomor_induk }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="bidang">bidang</label>
                            <p class="form-control">{{ $staff->bidang }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="Email">email</label>
                            <p class="form-control">{{ $staff->user->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Foto staff</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex align-items-center align-items-sm-center justify-content-center gap-4">
                                @if ($staff->user->foto)
                                    <img src="{{ asset('storage') . '/' . $staff->user->foto }}" alt="staff-avatar"
                                        class="d-block rounded" height="200" width="200" id="uploadedAvatar" />
                                @else
                                    <img src="{{ asset('img') }}/unknown.png" alt="user-avatar" class="d-block rounded"
                                        height="200" width="200" id="uploadedAvatar" />
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-start">
                    <a href="/staff/{{ $staff->id }}/edit" class="btn btn-outline-warning me-3">Edit</a>
                    <form action="/staff/{{ $staff->id }}" method="post">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-3 col-12 mb-0">
                    <div class="alert alert-primary">
                        <h6 class="alert-heading fw-bold mb-1">Kelola Data staff</h6>
                        <p class="mb-0">Ketika Form Tambah Data staff dihapus atau diubah,<br />
                            Maka Secara Otomatis Kode QR akan dihapus atau terubah, <br />
                            Dan Langsung diseusaikan dengan kode qr yang tertera
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
