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
            <div class="card-body pb-2">
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
                            @forelse ($dosens as $dosen)
                                <tr>
                                    <td style="width:10%">
                                        @if ($dosen->user->foto)
                                            <img src="{{ asset('storage') . '/' . $dosen->user->foto }}" alt="dosen-avatar"
                                                class="d-block rounded img-preview" height="100" width="100"
                                                id="uploadedAvatar" />
                                        @else
                                            <img src="{{ asset('img') }}/unknown.png" alt="user-avatar"
                                                class="d-block rounded img-preview" height="100" width="100"
                                                id="uploadedAvatar" />
                                        @endif
                                    </td>
                                    <td>{{ $dosen->user->nomor_induk }}</td>
                                    <td class="text-wrap">{{ $dosen->user->nama }}</td>
                                    <td>{{ $dosen->jurusan }}</td>
                                    <td class="text-wrap">{{ $dosen->user->email }}</td>
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
                            @empty
                                <tr>
                                    <td colspan="100%">
                                        <div class="my-5">
                                            <h3 class="text-muted">
                                                Tidak Ada Data Dosen
                                            </h3>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex align-items-center justify-content-end mt-4 mb-0">
                    {{ $dosens->links() }}
                </div>
            </div>
        </div>
        <!--/ Bordered Table -->
    </div>
@endsection
