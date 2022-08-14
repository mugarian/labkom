@extends('layout.main')
@section('container')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Akun / Kelola Akun /</span> Edit Akun</h4>

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
      <!-- Basic Layout -->
      <div class="col-xxl">
        <div class="card mb-4">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Edit Akun</h5>
            <small class="text-muted float-end">< Kembali</small>
          </div>
          <div class="card-body">
            <form>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">Foto Profil</label>
                    <div class="col-sm-10">
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
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-default-name">Nomor Induk</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="basic-default-name" placeholder="10107039" />
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-default-name">Nama</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="basic-default-name" placeholder="John Doe" />
                </div>
              </div>
              <div class="row mb-3">
                  <label class="col-sm-2 col-form-label" for="basic-default-company">Jabatan</label>
                  <div class="col-sm-10">
                      <input
                      type="text"
                      class="form-control"
                      id="basic-default-company"
                      placeholder="ACME Inc."
                      />
                    </div>
                </div>
              <div class="row mb-3">
                  <label class="col-sm-2 col-form-label" for="basic-default-company">Email</label>
                  <div class="col-sm-10">
                      <input
                      type="email"
                      class="form-control"
                      id="basic-default-company"
                      placeholder="ACME Inc."
                      />
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-email">Password</label>
                <div class="col-sm-10">
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="basic-default-email"
                      class="form-control"
                      placeholder="john.doe"
                      aria-label="john.doe"
                      aria-describedby="basic-default-email2"
                    />
                  </div>
                  <div class="form-text">Password harus mengandung 1 huruf besar, 1 angka, 1 huruf spesial, dan minimal 8 huruf</div>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-default-phone">No Handphone</label>
                <div class="col-sm-10">
                  <input
                    type="text"
                    id="basic-default-phone"
                    class="form-control phone-mask"
                    placeholder="658 799 8941"
                    aria-label="658 799 8941"
                    aria-describedby="basic-default-phone"
                  />
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-default-message">Alamat</label>
                <div class="col-sm-10">
                  <textarea
                    id="basic-default-message"
                    class="form-control"
                    placeholder="Hi, Do you have a moment to talk Joe?"
                    aria-label="Hi, Do you have a moment to talk Joe?"
                    aria-describedby="basic-icon-default-message2"
                  ></textarea>
                </div>
              </div>
              <div class="row justify-content-end">
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
