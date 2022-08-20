@extends('layout.main')
@section('container')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pelaporan / Kelola Pelaporan /</span> Tambah Pelaporan</h4>

    <!-- Basic Layout -->
    <div class="row">
      <div class="col-xl">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Pelaporan</h5>
            <small class="text-muted float-end"><a href="/pelaporan">< Kembali </a></small>
          </div>
          <div class="card-body">
            <form>
              <div class="mb-3">
                <label class="form-label" for="basic-default-fullname">Tanggal Pelaporan</label>
                <input type="datetime-local" class="form-control" id="basic-default-fullname" value="2020-10-10T20:10"/>
              </div>
              <div class="mb-3">
                <label class="form-label" for="basic-default-fullname">Judul Pelaporan</label>
                <input type="text" class="form-control" id="basic-default-fullname" value="Ini Judul"/>
              </div>
              <div class="mb-3">
                <label class="form-label" for="basic-default-message">Keterangan</label>
                  <textarea
                    id="basic-default-message"
                    class="form-control"
                    placeholder="Hi, Do you have a moment to talk Joe?"
                    aria-label="Hi, Do you have a moment to talk Joe?"
                    aria-describedby="basic-icon-default-message2"
                  ></textarea>
              </div>
              <div class="mb-3">
                <label class="form-label" for="basic-default-name">Foto Pendukung</label>
                <div class="">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img
                            src="{{ asset('sneat') }}/assets/img/avatars/1.png"
                            alt="user-avatar"
                            class="d-block rounded"
                            height="100"
                            width="100"
                            id="uploadedAvatar"
                        />
                        <div class="button-wrapper">
                            <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                            <span class="d-none d-sm-block">Upload new photo</span>
                            <i class="bx bx-upload d-block d-sm-none"></i>
                            <input
                                type="file"
                                id="upload"
                                class="account-file-input"
                                hidden
                                accept="image/png, image/jpeg"
                            />
                            </label>
                            <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                            <i class="bx bx-reset d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Reset</span>
                            </button>

                            <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Kode QR</h5>
          </div>
          <div class="card-body">
            <form>
                <div class="mb-3">
                    <div class="d-flex align-items-center align-items-sm-center justify-content-center gap-4">
                        <img
                            src="{{ asset('img') }}/qr.png"
                            alt="user-avatar"
                            class="d-block rounded"
                            height="190"
                            width="190"
                            id="uploadedAvatar"
                        />
                    </div>
                </div>
              <div class="mb-3">
                <label class="form-label" for="basic-default-fullname">Kode</label>
                <input type="text" class="form-control" id="basic-default-fullname" placeholder="4HBT6IKL" readonly="readonly" />
              </div>
              <div class="mb-3">
                <label class="form-label" for="basic-default-fullname">Nama</label>
                <input type="text" class="form-control" id="basic-default-fullname" placeholder="Lab UX" readonly="readonly" />
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="card">
        <div class="card-header">
            <button type="submit" class="btn btn-primary">Tambah</button>
            </form>
        </div>
        <div class="card-body">
          <div class="mb-3 col-12 mb-0">
            <div class="alert alert-primary">
              <h6 class="alert-heading fw-bold mb-1">Penambahan Data Peminjaman</h6>
              <p class="mb-0">Ketika Form Tambah Data Ruangan ditambahkan,<br />
                Maka Secara Otomatis Kode QR akan menambahkan data Kode QR baru, <br />
                Dan Langsung Disambungkan sesuai kode qr yang tertera
                </p>
            </div>
          </div>
        </div>
      </div>
</div>
@endsection
