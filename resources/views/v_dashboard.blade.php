@extends('layout.main')
@section('container')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">

      {{-- banner --}}
      <div class="col-lg-8 mb-4 order-0">
        <div class="card">
          <div class="d-flex align-items-end row">
            <div class="col-sm-7">
              <div class="card-body">
                <h5 class="card-title text-primary">Halo John! 🎉</h5>
                <p class="mb-4">
                  Selamat Datang di Sistem Pengelolaan Barang dan Ruangan Melalui Pemindaian Kode QR
                </p>

                <a href="/scan" class="btn btn-sm btn-outline-primary">Scan QR</a>
              </div>
            </div>
            <div class="col-sm-5 text-center text-sm-left">
              <div class="card-body pb-0 px-0 px-md-4">
                <img
                  src="{{ asset('sneat') }}/assets/img/illustrations/man-with-laptop-light.png"
                  height="140"
                  alt="View Badge User"
                  data-app-dark-img="illustrations/man-with-laptop-dark.png"
                  data-app-light-img="illustrations/man-with-laptop-light.png"
                />
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-md-4 order-1">
        <div class="row">

          {{-- peminjaman --}}
          <div class="col-lg-12 col-md-12 col-12 mb-4">
            <div class="card">
              <center>
              <div class="card-body">
                <div class="card-title d-flex align-items-center justify-content-center">
                  <div class="avatar flex-shrink-0">
                    {{-- <img
                      src="{{ asset('sneat') }}/assets/img/icons/unicons/chart-success.png"
                      alt="chart success"
                      class="rounded"
                    /> --}}
                    <i class='fs-1 text-success bx bx-calendar-plus'></i>
                  </div>
                </div>
                <span class="fw-semibold d-block mb-1">Peminjaman</span>
                <h3 class="card-title mb-2">12</h3>
                <div class="d-flex justify-content-evenly">
                    <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> 8</small>
                    <small class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> 3</small>
                    <small class="text-secondary fw-semibold"><i class="bx bx-question-mark"></i> 1</small>
                </div>
              </div>
              </center>
            </div>
          </div>

        </div>
      </div>

       <!-- Aktivitas Peminjaman -->
      <div class="col-md-6 col-lg-4 order-2 order-md-3 order-lg-2 col-xl-4 order-0 mb-4">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-center pb-0">
            <div class="card-title mb-0">
              <h5 class="m-0">Peminjaman</h5>
              {{-- <small class="text-muted">42.82k Total Sales</small> --}}
            </div>
          </div>
          <div class="card-body">
            <ul class="p-0 mt-4 mb-0">
              <li class="d-flex mb-4 pb-1">
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                    <h6 class="mb-0">
                          <a href="/peminjaman">
                              Labkom RPL
                          </a>
                      </h6>
                    <small class="text-muted">Status: Disetujui</small>
                  </div>
                  <div class="user-progress">
                      <a href="/scan" class="btn btn-sm btn-outline-primary">Kembalikan</a>
                  </div>
                </div>
              </li>
              <li class="d-flex mb-4 pb-1">
                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                  <div class="me-2">
                      <h6 class="mb-0">
                          <a href="/peminjaman">
                              Proyektor A29
                          </a>
                      </h6>
                    <small class="text-muted">Status: Menunggu</small>
                  </div>
                  <div class="user-progress">
                      <a href="/scan" class="btn btn-sm btn-outline-success"><i class='bx bx-check' ></i></a>
                      <a href="/scan" class="btn btn-sm btn-outline-danger"><i class='bx bx-x' ></i></a>
                  </div>
                </div>
              </li>
              <li class="d-flex mb-4 pb-1">
                  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                      <h6 class="mb-0">
                          <a href="/peminjaman">
                              Laptop ROG
                          </a>
                      </h6>
                      <small class="text-muted">Status: Ditolak</small>
                    </div>
                  </div>
              </li>
              <li class="d-flex mb-4 pb-1">
                  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                      <h6 class="mb-0">
                          <a href="/peminjaman">
                              Kursi Gaming
                          </a>
                      </h6>
                      <small class="text-muted">Status: Disetujui</small>
                    </div>
                  <div class="user-progress">
                      <a href="/scan" class="btn btn-sm btn-outline-primary">Kembalikan</a>
                  </div>
                  </div>
              </li>
              <li class="d-flex mb-4 pb-1">
                  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                      <h6 class="mb-0">
                          <a href="/peminjaman">
                              Flashdisk 8GB
                          </a>
                      </h6>
                      <small class="text-muted">Status: Disetujui</small>
                    </div>
                  <div class="user-progress">
                      <a href="/scan" class="btn btn-sm btn-outline-primary">Kembalikan</a>
                  </div>
                  </div>
              </li>
              <li class="d-flex mb-0 pb-0 justify-content-center">
                  <a href="/scan" class="btn btn-sm btn-outline-primary">Peminjaman Lainnya</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!--/ Aktivitas Peminjaman -->

       <!-- Aktivitas Pemakaian -->
       <div class="col-md-6 col-lg-4 order-3 order-md-3 order-lg-2 col-xl-4 order-0 mb-4">
          <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-center pb-0">
              <div class="card-title mb-0">
                <h5 class="m-0">Pemakaian</h5>
                {{-- <small class="text-muted">42.82k Total Sales</small> --}}
              </div>
            </div>
            <div class="card-body">
              <ul class="p-0 mt-4 mb-0">
                <li class="d-flex mb-4 pb-1">
                  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                      <h6 class="mb-0">
                            <a href="/peminjaman">
                                Labkom RPL
                            </a>
                        </h6>
                      <small class="text-muted">Status: Disetujui</small>
                    </div>
                    <div class="user-progress">
                        <a href="/scan" class="btn btn-sm btn-outline-primary">Selesai</a>
                    </div>
                  </div>
                </li>
                <li class="d-flex mb-4 pb-1">
                  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                        <h6 class="mb-0">
                            <a href="/peminjaman">
                                Proyektor A29
                            </a>
                        </h6>
                      <small class="text-muted">Status: Menunggu</small>
                    </div>
                    <div class="user-progress">
                        <a href="/scan" class="btn btn-sm btn-outline-success"><i class='bx bx-check' ></i></a>
                        <a href="/scan" class="btn btn-sm btn-outline-danger"><i class='bx bx-x' ></i></a>
                    </div>
                  </div>
                </li>
                <li class="d-flex mb-4 pb-1">
                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                      <div class="me-2">
                        <h6 class="mb-0">
                            <a href="/peminjaman">
                                Laptop ROG
                            </a>
                        </h6>
                        <small class="text-muted">Status: Ditolak</small>
                      </div>
                    </div>
                </li>
                <li class="d-flex mb-4 pb-1">
                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                      <div class="me-2">
                        <h6 class="mb-0">
                            <a href="/peminjaman">
                                Kursi Gaming
                            </a>
                        </h6>
                        <small class="text-muted">Status: Disetujui</small>
                      </div>
                    <div class="user-progress">
                        <a href="/scan" class="btn btn-sm btn-outline-primary">Selesai</a>
                    </div>
                    </div>
                </li>
                <li class="d-flex mb-4 pb-1">
                    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                      <div class="me-2">
                        <h6 class="mb-0">
                            <a href="/peminjaman">
                                Flashdisk 8GB
                            </a>
                        </h6>
                        <small class="text-muted">Status: Disetujui</small>
                      </div>
                    <div class="user-progress">
                        <a href="/scan" class="btn btn-sm btn-outline-primary">Selesai</a>
                    </div>
                    </div>
                </li>
                <li class="d-flex mb-0 pb-0 justify-content-center">
                    <a href="/scan" class="btn btn-sm btn-outline-primary">Pemakaian Lainnya</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      <!--/ Aktivitas Pemakaian -->

      <div class="col-12 col-md-8 col-lg-4 order-4 order-md-2">
        <div class="row">

          {{-- pemakaian --}}
          <div class="col-lg-12 col-md-12 col-12 mb-4">
              <div class="card">
                <center>
                <div class="card-body">
                  <div class="card-title d-flex align-items-center justify-content-center">
                    <div class="avatar flex-shrink-0">
                      {{-- <img
                        src="{{ asset('sneat') }}/assets/img/icons/unicons/chart-success.png"
                        alt="chart success"
                        class="rounded"
                      /> --}}
                      <i class='fs-1 text-info bx bx-code-block'></i>
                    </div>
                  </div>
                  <span class="fw-semibold d-block mb-1">Pemakaian</span>
                  <h3 class="card-title mb-2">12</h3>
                  <div class="d-flex justify-content-evenly">
                      <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> 8</small>
                      <small class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> 3</small>
                      <small class="text-secondary fw-semibold"><i class="bx bx-question-mark"></i> 1</small>
                  </div>
                </div>
                </center>
              </div>
          </div>

          {{-- pelaporan --}}
          <div class="col-lg-12 col-md-12 col-12 mb-4">
              <div class="card">
                <center>
                <div class="card-body">
                  <div class="card-title d-flex align-items-center justify-content-center">
                    <div class="avatar flex-shrink-0">
                      {{-- <img
                        src="{{ asset('sneat') }}/assets/img/icons/unicons/chart-success.png"
                        alt="chart success"
                        class="rounded"
                      /> --}}
                      <i class='fs-1 text-danger bx bx-message-error'></i>
                    </div>
                  </div>
                  <span class="fw-semibold d-block mb-1">Pelaporan</span>
                  <h3 class="card-title mb-2">12</h3>
                  <div class="d-flex justify-content-evenly">
                      <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> 8</small>
                      <small class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> 3</small>
                      <small class="text-secondary fw-semibold"><i class="bx bx-question-mark"></i> 1</small>
                  </div>
                </div>
                </center>
              </div>
          </div>

        </div>
      </div>

    </div>
    <div class="row">
      <!-- Pelaporan -->
      <div class="col-12 col-lg-8 order-2 order-md-3 order-lg-2 mb-4">
          <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-center">
              <h5 class="card-title m-0 me-2">Pelaporan</h5>
            </div>
            <div class="card-body">
              <ul class="p-0 m-0">
                <li class="d-flex mb-4 pb-1">
                  <div class="avatar flex-shrink-0 me-3">
                      <span class="avatar-initial rounded bg-label-danger">
                          <i class="bx bx-door-open"></i>
                      </span>
                    {{-- <img src="{{ asset('sneat') }}/assets/img/icons/unicons/paypal.png" alt="User" class="rounded" /> --}}
                  </div>
                  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                      <small class="text-muted d-block mb-1">Proyektor <i class="fw-lighter">(Menunggu)</i></small>
                      <h6 class="mb-0">
                          <a href="/pelaporan">
                              Proyektor meleduk dan mengeluarkan asap
                          </a>
                      </h6>
                    </div>
                      <div class="user-progress d-flex align-items-center gap-1">
                          <a href="/scan" class="btn btn-sm btn-outline-success"><i class='bx bx-check' ></i></a>
                          <a href="/scan" class="btn btn-sm btn-outline-danger"><i class='bx bx-x' ></i></a>
                      </div>
                  </div>
                </li>
                <li class="d-flex mb-4 pb-1">
                  <div class="avatar flex-shrink-0 me-3">
                      <span class="avatar-initial rounded bg-label-danger">
                          <i class="bx bx-package"></i>
                      </span>
                    {{-- <img src="{{ asset('sneat') }}/assets/img/icons/unicons/paypal.png" alt="User" class="rounded" /> --}}
                  </div>
                  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                      <small class="text-muted d-block mb-1">PC No. 20 - Labkom Jaringan <i class="fw-lighter">(Menunggu)</i></small>
                      <h6 class="mb-0">
                          <a href="/pelaporan">
                              Tidak Menyala terus sering ngehang
                          </a>
                      </h6>
                    </div>
                      <div class="user-progress d-flex align-items-center gap-1">
                          <a href="/scan" class="btn btn-sm btn-outline-success"><i class='bx bx-check' ></i></a>
                          <a href="/scan" class="btn btn-sm btn-outline-danger"><i class='bx bx-x' ></i></a>
                      </div>
                  </div>
                </li>
                <li class="d-flex mb-4 pb-1">
                  <div class="avatar flex-shrink-0 me-3">
                      <span class="avatar-initial rounded bg-label-danger">
                          <i class="bx bx-door-open"></i>
                      </span>
                    {{-- <img src="{{ asset('sneat') }}/assets/img/icons/unicons/paypal.png" alt="User" class="rounded" /> --}}
                  </div>
                  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                      <small class="text-muted d-block mb-1">Labkom UX <i class="fw-lighter">(Disetujui)</i></small>
                      <h6 class="mb-0">
                          <a href="/pelaporan">
                              AC Panas dan Monitor tidak menyala
                          </a>
                      </h6>
                    </div>
                      <div class="user-progress d-flex align-items-center gap-1">
                      </div>
                  </div>
                </li>
                <li class="d-flex mb-4 pb-1">
                  <div class="avatar flex-shrink-0 me-3">
                      <span class="avatar-initial rounded bg-label-danger">
                          <i class="bx bx-package"></i>
                      </span>
                    {{-- <img src="{{ asset('sneat') }}/assets/img/icons/unicons/paypal.png" alt="User" class="rounded" /> --}}
                  </div>
                  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                      <small class="text-muted d-block mb-1">Ruangan 3 <i class="fw-lighter">(Disetujui)</i></small>
                      <h6 class="mb-0">
                          <a href="/pelaporan">
                              Ruangan berdebu dan sangat kotor
                          </a>
                      </h6>
                    </div>
                      <div class="user-progress d-flex align-items-center gap-1">
                          {{-- <a href="/scan" class="btn btn-sm btn-outline-success"><i class='bx bx-check' ></i></a>
                          <a href="/scan" class="btn btn-sm btn-outline-danger"><i class='bx bx-x' ></i></a> --}}
                      </div>
                  </div>
                </li>
                <li class="d-flex mb-4 pb-1">
                  <div class="avatar flex-shrink-0 me-3">
                      <span class="avatar-initial rounded bg-label-danger">
                          <i class="bx bx-package"></i>
                      </span>
                    {{-- <img src="{{ asset('sneat') }}/assets/img/icons/unicons/paypal.png" alt="User" class="rounded" /> --}}
                  </div>
                  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                      <small class="text-muted d-block mb-1">Laptop ROG <i class="fw-lighter">(Ditolak)</i></small>
                      <h6 class="mb-0">
                          <a href="/pelaporan">
                              Mahal dan Gengsis
                          </a>
                      </h6>
                    </div>
                      <div class="user-progress d-flex align-items-center gap-1">
                          {{-- <a href="/scan" class="btn btn-sm btn-outline-success"><i class='bx bx-check' ></i></a>
                          <a href="/scan" class="btn btn-sm btn-outline-danger"><i class='bx bx-x' ></i></a> --}}
                      </div>
                  </div>
                </li>
                <li class="d-flex justify-content-center">
                  <a href="/scan" class="btn btn-sm btn-outline-primary">Pelaporan Lainnya</a>
                </li>
              </ul>
            </div>
          </div>
      </div>
       <!--/ Pelaporan -->


    </div>
  </div>
@endsection
