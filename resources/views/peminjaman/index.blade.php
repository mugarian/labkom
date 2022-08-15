@extends('layout.main')
@section('container')
<!-- Bordered Table -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Peminjaman /</span> Kelola Peminjaman</h4>
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Kelola Peminjaman</h5>
            <div>
                <a href="/barang/create"><button class="btn btn-primary">Tambah Kode Barang</button></a>
            </div>
          </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                <tr class="text-center">
                    <th style="width: 0">#</th>
                    <th style="width: 0">Kode QR</th>
                    <th>Keterangan</th>
                    <th style="width: 0">Aksi</th>
                </tr>
                </thead>
                <tbody class="text-center">
                    @for ($i = 1; $i <= 5; $i++)
                    <tr>
                        <td>{{$i}}</td>
                        <td>24HJ65K8</td>
                        <td>Kode Untuk Peminjaman PC</td>
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
                            <a class="dropdown-item" href="javascript:void(0);"
                                ><i class="bx bx-info-circle me-1"></i> Lihat</a
                            >
                            <a class="dropdown-item" href="javascript:void(0);"
                                ><i class="bx bx-edit-alt me-1"></i> Edit</a
                            >
                            <a class="dropdown-item" href="javascript:void(0);"
                                ><i class="bx bx-trash me-1"></i> Delete</a
                            >
                            </div>
                        </div>
                        </td>
                    </tr>
                    @endfor
                </tbody>
            </table>
            </div>
        </div>
    </div>
  <!--/ Bordered Table -->
</div>
  @endsection
