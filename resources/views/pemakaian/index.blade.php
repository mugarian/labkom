@extends('layout.main')
@section('container')
<!-- Bordered Table -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pemakaian /</span> Kelola Pemakaian</h4>
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Kelola Pemakaian</h5>
            <div>
                <a href="/pemakaian/create"><button class="btn btn-primary">Memakai</button></a>
            </div>
          </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                <tr class="text-center">
                    <th style="width: 0">#</th>
                    <th style="width: 0">Pemakai</th>
                    <th style="width: 0">Kode QR</th>
                    <th>Tgl Pakai</th>
                    <th>Tgl Selesai</th>
                    <th style="width: 0">Status</th>
                    <th style="width: 0">Referensi</th>
                    <th style="width: 0">Aksi</th>
                </tr>
                </thead>
                <tbody class="text-center">
                    @for ($i = 1; $i <= 5; $i++)
                    <tr>
                        <td>{{$i}}</td>
                        <td>Galuh</td>
                        <td>
                            <span
                            data-bs-toggle="tooltip"
                            data-bs-offset="0m5"
                            data-bs-placement="bottom"
                            data-bs-html="true"
                            title="<span>Lab UX</span>">
                                278GH3AU
                            </span>
                        </td>
                        <td>12 Agustus 2022</td>
                        <td>
                            <a href="/peminjaman/kondisi"><button class="btn btn-sm btn-primary">selesai</button></a>
                        </td>
                        <td><span class="badge bg-label-success">Disetujui </span> </td>
                        <td>88723</td>
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
