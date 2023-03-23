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
            <form id="/akun/{{ $user->id }}" method="POST" enctype="multipart/form-data">
                @method('put')
                @csrf
                <div class="d-flex align-items-start align-items-sm-center gap-4 mb-4">
                    @if ($user->gambar)
                        <img
                        src="{{ asset('/storage/' . auth()->user()->gambar) }}"
                        alt="user-avatar"
                        class="d-block rounded"
                        height="100"
                        width="100"
                        id="uploadedAvatar"
                        />
                    @else
                        <img
                        src="{{ asset('img') }}/user/{{ rand(1,2) }}.png"
                        alt="user-avatar"
                        class="d-block rounded"
                        height="100"
                        width="100"
                        id="uploadedAvatar"
                        />
                    @endif
                  <div class="button-wrapper">
                    <label for="gambar" class="btn btn-primary me-2 mb-4" tabindex="0">
                      <span class="d-none d-sm-block">Upload</span>
                      <i class="bx bx-upload d-block d-sm-none"></i>
                      <input
                        type="file"
                        id="upload"
                        class="account-file-input gambar @error('gambar')
                            is-invalid
                        @enderror"
                        name="gambar"
                        onchange="previewImage()"
                        hidden
                        accept="image/png, image/jpeg"
                      />
                      @error('gambar')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                        @enderror
                    </label>
                    <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                      <i class="bx bx-reset d-block d-sm-none"></i>
                      <span class="d-none d-sm-block">Reset</span>
                    </button>

                    <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                  </div>
                </div>
          <hr class="my-0" />
              <div class="row">
                <div class="mb-3 col-md-6">
                  <label for="name" class="form-label">Nama</label>
                  <input
                    class="form-control @error('name')
                        is-invalid
                    @enderror"
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    required
                  />
                  @error('name')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                        @enderror
                </div>
                <div class="mb-3 col-md-6">
                  <label for="nomor_induk" class="form-label">Nomor Induk</label>
                  <input class="form-control @error('nomor_induk')
                    is-invalid
                  @enderror" type="text" name="nomor_induk" id="nomor_induk" value="{{ old('nomor_induk', $user->nomor_induk)}}" />
                </div>
                <div class="mb-3 col-md-6">
                  <label class="form-label" for="no_hp">Nomor HP</label>
                  <div class="input-group input-group-merge">
                    <span class="input-group-text">ID (+62)</span>
                    <input
                      type="text"
                      id="no_hp"
                      name="no_hp"
                      class="form-control @error('no_hp')
                          is-invalid
                      @enderror"
                      value="{{ old('no_hp', $user->no_hp)}}"
                      placeholder="811 222 333"
                    />
                    @error('no_hp')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                        @enderror
                  </div>
                </div>
                <div class="mb-3 col-md-6">
                    <label for="email" class="form-label">E-mail</label>
                    <input
                      class="form-control @error('email')
                          is-invalid
                      @enderror"
                      type="email"
                      id="email"
                      name="email"
                      value="{{ old('email', $user->email) }}"
                      placeholder="john.doe@example.com"
                    />
                    @error('email')
                           <div class="invalid-feedback">
                              {{ $message }}
                           </div>
                        @enderror
                  </div>
                <div class="mb-3 col-md-6">
                  <label for="address" class="form-label">Alamat</label>
                  <textarea
                        id="alamat"
                        name="alamat"
                        class="form-control @error('alamat')
                            is-invalid
                        @enderror"
                        placeholder="Hi, Do you have a moment to talk Joe?"
                        >{{ old('alamat', $user->alamat)}}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">
                            {{ $message}}
                            </div>
                        @enderror
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
  <script>
    function previewImage() {
        const image = document.querySelector('.gambar');
        const imgPreview = document.querySelector('.img-preview');

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }
</script>
@endsection
