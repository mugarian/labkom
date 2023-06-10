@extends('layout.main')
@section('container')
    <!-- Bordered Table -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><a href="/algoritma" class="text-secondary">Data algoritma</a></h4>
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">Kelola algoritma</h5>
                @if (auth()->user()->role == 'admin')
                    <small class="text-muted float-end">
                        <a href="/pengajuan/create"><button class="btn btn-primary">Tambah</button></a>
                    </small>
                @endif
            </div>
            <div class="card-body pb-2">
                <div class="table-responsive text-nowrap">
                    <table class="table table-bordered" id="myTable">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 0">#</th>
                                <th>outlook</th>
                                <th>temperature</th>
                                <th>humidity</th>
                                <th>windy</th>
                                <th>play</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="text-center">
                                <th style="width: 0">#</th>
                                <th>outlook</th>
                                <th>temperature</th>
                                <th>humidity</th>
                                <th>windy</th>
                                <th>play</th>
                                <th style="width: 0">Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody class="text-center">
                            @foreach ($algoritmas as $algoritma)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-wrap">{{ $algoritma->outlook }}</td>
                                    <td class="text-wrap">{{ $algoritma->temperature }}</td>
                                    <td class="text-wrap">{{ $algoritma->humidity }}</td>
                                    <td class="text-wrap">{{ $algoritma->windy }}</td>
                                    <td class="text-wrap">{{ $algoritma->play }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a class="btn btn-outline-success p-1" data-bs-toggle="tooltip"
                                                data-bs-placement="top" data-bs-title="Lihat"
                                                href="/algoritma/{{ $algoritma->id }}"><i class="bx bx-info-circle"></i></a>
                                            @if (auth()->user()->role == 'admin')
                                                <a class="btn btn-outline-warning p-1" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-title="Ubah"
                                                    href="/algoritma/{{ $algoritma->id }}/edit">
                                                    <i class="bx bx-edit-alt"></i>
                                                </a>
                                                <form action="/algoritma/{{ $algoritma->id }}" method="post">
                                                    @method('delete')
                                                    @csrf
                                                    <button type="submit" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-title="Hapus" class="btn btn-outline-danger p-1"
                                                        onclick="if (confirm('Hapus Data')) return true; return false">
                                                        <i class="bx bx-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                {{-- @empty
                                    <tr>
                                        <td colspan="100%">
                                            <div class="my-5">
                                                <h3 class="text-muted">
                                                    Tidak Ada Data algoritma
                                                </h3>
                                            </div>
                                        </td>
                                    </tr> --}}
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- <div class="d-flex align-items-center justify-content-end mt-4 mb-0">
                    {{ $algoritmas->links() }}
                </div> --}}
            </div>
        </div>
        <!--/ Bordered Table -->
    </div>
@endsection
