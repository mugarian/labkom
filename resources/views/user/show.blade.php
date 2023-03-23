@extends('layout.main')
@section('container')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Akun / Kelola Akun /</span> Lihat Akun</h4>

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
      <!-- Basic Layout -->
      <div class="col-xxl">
        <div class="card mb-4">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Lihat Akun</h5>
            <span>
                <a class="btn btn-light btn-sm" href="/akun">< kembali</a>
                <a class="btn btn-primary btn-sm text-white" href="/akun/{{ $user->nomor_induk }}/edit"><i class="bx bx-edit-alt"></i></a>
                <form action="/akun/{{ $user->nomor_induk }}" method="POST" class="d-inline">
                    @method('delete')
                    @csrf
                    <button type="submit" class="btn btn-primary btn-sm text-white"><i class="bx bx-trash"></i></button>
                </form>
            </span>
          </div>
          <div class="card-body">
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label" for="basic-default-name">Foto Profil</label>
                    <div class="col-sm-10">
                        <div class="d-flex align-items-start align-items-sm-center gap-4">
                            <img
                                @if ($user->gambar)
                                    src="{{ asset('/storage/' . $user->gambar) }}"
                                @else
                                    src="{{ asset('img') }}/user/{{ rand(1,2) }}.png"
                                @endif
                                    alt="user-avatar"
                                    class="d-block rounded"
                                    height="100"
                                    width="100"
                                    id="uploadedAvatar"
                                />
                        </div>
                    </div>
                </div>
              <div class="row">
                <h5 class="col-sm-2 col-form-label" for="basic-default-nomor-induk">Nomor Induk</h5>
                <div class="col-sm-10">
                    <h6 class="form-control">{{$user->nomor_induk}}</h6>
                </div>
              </div>
              <div class="row">
                <h5 class="col-sm-2 col-form-label" for="basic-default-name">Nama</h5>
                <div class="col-sm-10">
                    <h6 class="form-control">{{$user->name}}</h6>
                </div>
              </div>
                <div class="row">
                    <h5 class="col-sm-2 col-form-label" for="basic-default-jabatan">Jabatan</h5>
                    <div class="col-sm-10">
                        <h6 class="form-control">{{$user->jabatan}}</h6>
                    </div>
                </div>
              <div class="row">
                    <h5 class="col-sm-2 col-form-label" for="basic-default-email">Email</h5>
                    <div class="col-sm-10">
                        <h6 class="form-control">{{$user->email}}</h6>
                    </div>
                </div>
              <div class="row">
                <h5 class="col-sm-2 col-form-label" for="basic-default-no-hp">No Handphone</h5>
                <div class="col-sm-10">
                    <h6 class="form-control">{{$user->no_hp}}</h6>
                </div>
              </div>
              <div class="row">
                <h5 class="col-sm-2 col-form-label" for="basic-default-alamat">Alamat</h5>
                <div class="col-sm-10">
                    <h6 class="form-control">{{$user->alamat}}</h6>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
