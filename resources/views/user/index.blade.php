@extends('layout.main')
@section('container')
<!-- Bordered Table -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Akun /</span> Kelola Akun</h4>
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
                    @for ($i = 1; $i <= 5; $i++)
                        <tr>
                            <td>{{$i}}</td>
                            <td>10107039</td>
                            <td>Galuh</td>
                            <td>Mahasiswa</td>
                            <td>082316039450</td>
                            <td>Cinangsi</td>
                            <td>Aktif</td>
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
