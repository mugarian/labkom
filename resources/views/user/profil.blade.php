@extends('layout.main')
@section('container')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Profil /</span> Nama Akun</h4>

    <div class="row">
      <div class="col-md-12">
        {{-- <ul class="nav nav-pills flex-column flex-md-row mb-3">
          <li class="nav-item">
            <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> Account</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages-account-settings-notifications.html"
              ><i class="bx bx-bell me-1"></i> Notifications</a
            >
          </li>
        </ul> --}}
        <div class="card mb-4">
          <h5 class="card-header">Profile Details</h5>
          <!-- Account -->
          <div class="card-body">
            {{-- Foto Profil --}}
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
          <hr class="my-0" />
          <div class="card-body">
            <form id="formAccountSettings" method="POST" onsubmit="return false">
              <div class="row">
                <div class="mb-3 col-md-6">
                  <label for="firstName" class="form-label">Nama</label>
                  <input
                    class="form-control"
                    type="text"
                    id="firstName"
                    name="firstName"
                    value="John"
                    autofocus
                  />
                </div>
                <div class="mb-3 col-md-6">
                  <label for="lastName" class="form-label">Nomor Induk</label>
                  <input class="form-control" type="text" name="lastName" id="lastName" value="10107001" />
                </div>
                <div class="mb-3 col-md-6">
                  <label for="organization" class="form-label">Jabatan</label>
                    <select id="organization" class="select2 form-select">
                      <option value="">Select Jabatan</option>
                      <option value="en">Admin</option>
                      <option value="fr">Dosen</option>
                      <option value="de">Mahasiswa</option>
                    </select>
                </div>
                <div class="mb-3 col-md-6">
                  <label class="form-label" for="phoneNumber">Nomor HP</label>
                  <div class="input-group input-group-merge">
                    <span class="input-group-text">ID (+62)</span>
                    <input
                      type="text"
                      id="phoneNumber"
                      name="phoneNumber"
                      class="form-control"
                      placeholder="811 222 333"
                    />
                  </div>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="email" class="form-label">E-mail</label>
                    <input
                      class="form-control"
                      type="text"
                      id="email"
                      name="email"
                      value="john.doe@example.com"
                      placeholder="john.doe@example.com"
                    />
                  </div>
                <div class="mb-3 col-md-6">
                  <label for="address" class="form-label">Alamat</label>
                  <input type="text" class="form-control" id="address" name="address" placeholder="Address" />
                </div>
              </div>
              <div class="row">
                <div class="form-check m-3">
                    <input
                      class="form-check-input"
                      type="checkbox"
                      name="accountActivation"
                      id="accountActivation"
                    />
                    <label class="form-check-label" for="accountActivation">Ubah Password</label>
                  </div>
                <div class="mb-3 col-md-6">
                    <label for="state" class="form-label">Password Lama</label>
                    <input class="form-control" type="text" id="state" name="state" placeholder="California" />
                </div>
                <div class="mb-3 col-md-6">
                    <label for="state" class="form-label">Password Baru</label>
                    <input class="form-control" type="text" id="state" name="state" placeholder="California" />
                </div>
              <div class="mt-2">
                <button type="submit" class="btn btn-primary me-2">Save changes</button>
                <button type="reset" class="btn btn-outline-secondary">Cancel</button>
              </div>
            </form>
          </div>
          <!-- /Account -->
        </div>
        <div class="card">
          <h5 class="card-header">Relasi Akun</h5>
          <div class="card-body">
            <div class="mb-3 col-12 mb-0">
              <div class="alert alert-primary">
                <h6 class="alert-heading fw-bold mb-1">Wali Dosen SI A 2020</h6>
                <p class="mb-0">Mensetujui Setiap peminjaman</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
