@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Home /</a>
                Pengajuan Bahan /
                <a href="/training" class="text-secondary">Data Training /</a>
            </span>
            <span class="text-primary">
                {{ $training->nama }}
            </span>
        </h5>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Detail Data Training</h5>
                        <small class="text-muted float-end"><a href="/training">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="nama">nama bahan</label>
                            <p class="form-control">{{ $training->nama }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="pengajuan">Kategori Pengajuan</label>
                            <p class="form-control">
                                @if ($training->pengajuan == 'lebih')
                                    Melebihi Kuota
                                @elseif ($training->pengajuan == 'pas')
                                    Sesuai Kuota
                                @else
                                    Kurang dari Kuota
                                @endif
                            </p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="Harga">Kategori Harga</label>
                            <p class="form-control">{{ $training->harga }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="label">Label</label>
                            <p class="form-control">{{ $training->label }}</p>
                        </div>
                        <div class="mb-3">
                            @if (auth()->user()->role == 'admin')
                                <div class="d-flex justify-content-start">
                                    <a href="/training/{{ $training->id }}/edit"
                                        class="btn btn-outline-warning me-3">Edit</a>
                                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal{{ $training->id }}">
                                        Delete
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal{{ $training->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-wrap">
                        Apakah Anda Yakin Ingin Menghapus Data {{ $training->nama }}?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                        {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                        <form action="/training/{{ $training->id }}" method="post">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-primary">
                                Ya
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
