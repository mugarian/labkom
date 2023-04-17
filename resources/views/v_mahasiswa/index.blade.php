@extends('layout.main')
@section('container')
    <!-- Bordered Table -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><a href="/mahasiswa" class="text-secondary">Data Mahasiswa</a></h4>
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Kelola mahasiswa</h5>
                <small class="text-muted float-end"><a href="/mahasiswa/create"><button
                            class="btn btn-primary">Tambah</button></a></small>
            </div>
            <div class="card-body pb-2">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>Foto</th>
                                <th style="width: 0">NIM</th>
                                <th>Nama</th>
                                <th>angkatan</th>
                                <th>Email</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @forelse ($mahasiswas as $mahasiswa)
                                <tr>
                                    <td style="width:10%">
                                        @if ($mahasiswa->user->foto)
                                            <img src="{{ asset('storage') . '/' . $mahasiswa->user->foto }}"
                                                alt="mahasiswa-avatar" class="d-block rounded img-preview" height="100"
                                                width="100" id="uploadedAvatar" />
                                        @else
                                            <img src="{{ asset('img') }}/unknown.png" alt="user-avatar"
                                                class="d-block rounded img-preview" height="100" width="100"
                                                id="uploadedAvatar" />
                                        @endif
                                    </td>
                                    <td>{{ $mahasiswa->user->nomor_induk }}</td>
                                    <td class="text-wrap">{{ $mahasiswa->user->nama }}</td>
                                    <td>{{ $mahasiswa->angkatan }}</td>
                                    <td class="text-wrap">{{ $mahasiswa->user->email }}</td>
                                    <td>

                                        <div class="d-flex justify-content-center">
                                            <a class="btn btn-outline-success p-1" href="/mahasiswa/{{ $mahasiswa->id }}"><i
                                                    class="bx bx-info-circle"></i></a>
                                            <a class="btn btn-outline-warning p-1"
                                                href="/mahasiswa/{{ $mahasiswa->id }}/edit"><i
                                                    class="bx bx-edit-alt"></i></a>
                                            <form action="/mahasiswa/{{ $mahasiswa->id }}" method="post">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger p-1">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%">
                                        <div class="my-5">
                                            <h3 class="text-muted">
                                                Tidak Ada Data Mahasiswa
                                            </h3>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex align-items-center justify-content-end mt-4 mb-0">
                    {{ $mahasiswas->links() }}
                </div>
            </div>
        </div>
        <!--/ Bordered Table -->
    </div>
@endsection
