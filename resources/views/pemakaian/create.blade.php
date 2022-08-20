@extends('layout.main')
@section('container')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pemakaian / Kelola Pemakaian /</span> Tambah Pemakaian</h4>

    <!-- Basic Layout -->
    <div class="row">
      <div class="col-xl">
        <div class="card mb-4">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Pemakaian</h5>
            <small class="text-muted float-end"><a href="/pemakaian">< Kembali </a></small>
          </div>
          <div class="card-body">
            <form>
              <div class="mb-3">
                <label class="form-label" for="basic-default-fullname">Tanggal Pemakaian</label>
                <input type="datetime-local" class="form-control" id="basic-default-fullname" value="2020-10-10T20:10"/>
              </div>
              <div class="mb-3">
                <label class="form-label" for="basic-default-message">Referensi</label>
                  <textarea
                    id="basic-default-message"
                    class="form-control"
                    placeholder="Hi, Do you have a moment to talk Joe?"
                    aria-label="Hi, Do you have a moment to talk Joe?"
                    aria-describedby="basic-icon-default-message2"
                  ></textarea>
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
