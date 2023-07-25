@extends('layout.main')
@section('container')
    <!-- Bordered Table -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="fw-bold py-3 mb-4">
            <span class="text-secondary fw-light">
                <a href="/dashboard" class="text-secondary">Beranda /</a>
                Pengajuan Bahan /
            </span>
            <span class="text-primary">
                Hasil Rule
            </span>
        </h5>
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Hasil Rule</h5>
            </div>
            <div class="card-body pb-2">
                <pre>{{ $rule ?? 'Rule Tidak ada atau Data Training Masih Kosong' }}</pre>
            </div>
        </div>
        <!--/ Bordered Table -->
    </div>
@endsection
