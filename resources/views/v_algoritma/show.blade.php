@extends('layout.main')
@section('container')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">
                <a href="/training" class="text-secondary">Data training</a> /
            </span> {{ $training->nama }}
        </h4>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Data Training</h5>
                        <small class="text-muted float-end"><a href="/training">
                                < Kembali </a></small>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label" for="nama">nama</label>
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
                                    <form action="/training/{{ $training->id }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger"
                                            onclick="if (confirm('Hapus Data')) return true; return false">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
