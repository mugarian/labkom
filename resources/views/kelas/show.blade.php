@extends('layout.main')
@section('container')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Kelas / Kelola Kelas /</span> Tambah Kelas</h4>

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
      <!-- Basic Layout -->
      <div class="col-xxl">
        <div class="card mb-4">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Tambah Kelas</h5>
            <small class="text-muted float-end"><a href="/kelas"> < Kembali </a></small>
          </div>
          <div class="card-body">
            <form>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-default-name">Nama</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="basic-default-name" placeholder="John Doe" />
                </div>
              </div>
              <div class="row mb-3">
                  <label class="col-sm-2 col-form-label" for="basic-default-company">Wali Dosen</label>
                  <div class="col-sm-10">
                        <select id="organization" class="select2 form-select">
                          <option value="">Select Jabatan</option>
                          <option value="en">Admin</option>
                          <option value="fr">Dosen</option>
                          <option value="de">Mahasiswa</option>
                        </select>
                    </div>
                </div>
              <div class="row mb-3">
                  <label class="col-sm-2 col-form-label" for="basic-default-company">Ketua Kelas</label>
                  <div class="col-sm-10">
                    <select id="organization" class="select2 form-select">
                        <option value="">Select Jabatan</option>
                        <option value="en">Admin</option>
                        <option value="fr">Dosen</option>
                        <option value="de">Mahasiswa</option>
                      </select>
                  </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-phone">Angkatan</label>
                    <div class="col-sm-10">
                      <input
                        type="month"
                        id="basic-default-phone"
                        class="form-control phone-mask"
                        aria-describedby="basic-default-phone"
                      />
                    </div>
                  </div>
              <div class="row mb-3">
                  <label class="col-sm-2 col-form-label" for="basic-default-company">Status</label>
                  <div class="col-sm-10">
                    <select id="organization" class="select2 form-select">
                        <option value="">Select Jabatan</option>
                        <option value="en">Admin</option>
                        <option value="fr">Dosen</option>
                        <option value="de">Mahasiswa</option>
                      </select>
                  </div>
                </div>
              <div class="row justify-content-end">
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary">Ubah</button>
                  <button type="submit" class="btn btn-outline-primary">Hapus</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
