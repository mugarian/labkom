@extends('layout.main')
@section('container')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Scan QR /</span> Opsi</h4>

    <div class="row">
      <div class="col-md-12">
        <div class="card mb-4">
          <h5 class="card-header">Memilih Opsi Scan Kode QR</h5>
          <!-- Account -->
          <div class="card-body">
            <h6 class="fw-lighter">A. Kode QR</h6>
            {{-- Foto Profil --}}
            <div class="d-flex align-items-start align-items-sm-center gap-4">
                <i class='bx bx-barcode' style="font-size:100px"></i>
                <div class="button-wrapper">
                    <form class="d-flex mb-3" onsubmit="return false">
                        <input class="form-control me-2" type="search" placeholder="Kode QR" aria-label="Search" />
                        <button class="btn btn-outline-primary" type="submit"><i class="bx bx-search"></i></button>
                    </form>
                <p class="text-muted mb-0">Masukkan Kode yang tertera di stiker kode qr</p>
              </div>
            </div>
          </div>
          <hr class="my-0" />
          <div class="card-body">
            <h6 class="fw-lighter">B. Scan QR</h6>
            <div class="mt-3">
                <div class="row">
                  <div class="col-md-6 col-12 mb-3 mb-md-0">
                    <div class="list-group">
                      <a
                        class="list-group-item list-group-item-action active"
                        id="list-home-list"
                        data-bs-toggle="list"
                        href="#list-home"
                        >1. Buka Kamera Pemindaian di HP</a
                      >
                      <a
                        class="list-group-item list-group-item-action"
                        id="list-profile-list"
                        data-bs-toggle="list"
                        href="#list-profile"
                        >2. Arahkan Kamera Pemindaian ke Stiker Kode QR</a
                      >
                      <a
                        class="list-group-item list-group-item-action"
                        id="list-messages-list"
                        data-bs-toggle="list"
                        href="#list-messages"
                        >3. Jika Menampilkan Link, maka tekan lanjutkan</a
                      >
                      <a
                        class="list-group-item list-group-item-action"
                        id="list-settings-list"
                        data-bs-toggle="list"
                        href="#list-settings"
                        >4. Hasil Pemindaian telah Selesai</a
                      >
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <div class="tab-content p-0">
                      <div class="tab-pane fade show active" id="list-home">
                        <img src="{{ asset('img') }}/1.png" alt="" style="max-width:200px">
                      </div>
                      <div class="tab-pane fade" id="list-profile">
                        <img src="{{ asset('img') }}/2.png" alt="" style="max-width:200px">
                      </div>
                      <div class="tab-pane fade" id="list-messages">
                        <img src="{{ asset('img') }}/3.png" alt="" style="max-width:200px">
                      </div>
                      <div class="tab-pane fade" id="list-settings">
                        <img src="{{ asset('img') }}/4.png" alt="" style="max-width:200px">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <!-- /Account -->
        </div>
        <div class="card">
          <h5 class="card-header">Perhatian</h5>
          <div class="card-body">
            <div class="mb-3 col-12 mb-0">
              <div class="alert alert-danger">
                <h6 class="alert-heading fw-bold mb-1">Kendala Pemindaian</h6>
                <p class="mb-0">Jika Terdapat Kendala Ketika Melakukan Pemindaian Kode QR, <br /> Silahkan Hubungi Admin atau Dosen Pengampu yang sedang mengajar</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
