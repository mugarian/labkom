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
            <span>
                <a class="btn btn-light btn-sm" href="/akun">< kembali</a>
                <a class="btn btn-primary btn-sm text-white" href="/akun/{{ $user->nomor_induk }}"><i class="bx bx-info-circle"></i></a>
                <form action="/akun/{{ $user->nomor_induk }}" method="POST" class="d-inline">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-primary btn-sm text-white"><i class="bx bx-trash"></i></button>
                </form>
            </span>
          </div>
          <div class="card-body">
            <form action="/akun/{{$user->nomor_induk}}" method="POST" enctype="multipart/form-data">
                @method('put')
                @csrf
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">Foto Profil</label>
                    <div class="col-sm-10">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <input type="hidden" name="oldImage" value="{{ $user->image }}">
                            <img
                                @if ($user->gambar)
                                    src="{{ asset('/storage/' . $user->gambar) }}"
                                @else
                                    src="{{ asset('img') }}/user/{{ rand(1,2) }}.png"
                                @endif
                                alt="user-avatar"
                                class="d-block rounded img-preview"
                                height="100"
                                width="100"
                                id="uploadedAvatar"
                            />
                            <div class="button-wrapper">
                                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
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
                                </label>
                                <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                <i class="bx bx-reset d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Reset</span>
                                </button>

                                <p class="text-muted mb-0">Allowed JPG, JPEG or PNG. Max size of 800K</p>
                            </div>
                        </div>
                    </div>
                </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="nomor_induk">Nomor Induk</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control @error('nomor_induk')
                      is-invalid
                  @enderror" id="nomor_induk" name="nomor_induk" placeholder="10107999" required value="{{ old('nomor_induk', $user->nomor_induk) }}" />
                    @error('nomor_induk')
                    <div class="invalid-feedback">
                        {{ $message }}
                     </div>
                    @enderror
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="name">Nama</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control @error('name')
                      is-invalid
                  @enderror" id="name" name="name" placeholder="John Doe" value="{{ old('name', $user->name) }}" />
                  @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="jabatan">Jabatan</label>
              <div class="col-sm-10">
                    <select id="jabatan" class="select2 form-select @error('jabatan')
                        is-invalid
                    @enderror" id="jabatan" name="jabatan">
                      <option value="" hidden>Select Jabatan</option>
                      <option value="Admin" @selected(old('jabatan', $user->jabatan) == 'Admin')>Admin</option>
                      <option value="Dosen" @selected(old('jabatan', $user->jabatan) == 'Dosen')>Dosen</option>
                      <option value="Mahasiswa" @selected(old('jabatan', $user->jabatan) == 'Mahasiswa')>Mahasiswa</option>
                    </select>
                    @error('jabatan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                  </div>
              </div>
              <div class="row mb-3">
                  <label class="col-sm-2 col-form-label" for="email">Email</label>
                  <div class="col-sm-10">
                      <input
                      type="email"
                      class="form-control @error('email')
                          is-invalid
                      @enderror"
                      id="email"
                      name="email"
                      placeholder="Email"
                      required
                      value="{{ old('email', $user->email) }}"
                      />
                      @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                      @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-email">Password</label>
                <div class="col-sm-10">
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control @error('password')
                          is-invalid
                      @enderror"
                      name="password"
                    />
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                  </div>
                  <div class="form-text">Password harus mengandung 1 huruf besar, 1 angka, 1 huruf spesial, dan minimal 8 huruf</div>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="no_hp">No Handphone</label>
                <div class="col-sm-10">
                  <input
                    type="text"
                    id="no_hp"
                    name="no_hp"
                    class="form-control phone-mask @error('no_hp')
                        is-invalid
                    @enderror"
                    placeholder="658 799 8941"
                    value="{{ old('no_hp', $user->no_hp) }}"
                  />
                  @error('no_hp')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                  @enderror
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="alamat">Alamat</label>
                <div class="col-sm-10">
                  <textarea
                    id="alamat"
                    name="alamat"
                    class="form-control @error('alamat')
                        is-invalid
                    @enderror"
                    placeholder="Alamat"
                  >{{ old('alamat', $user->alamat) }}</textarea>
                  @error('alamat')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                  @enderror
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
