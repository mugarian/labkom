<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <b>
            Selamat Datang
            @php
                $user = App\Models\User::find(auth()->user()->id);
                if ($user->role == 'dosen') {
                    $dosen = App\Models\Dosen::where('user_id', $user->id)->first();
                    if ($dosen->kepalalab == 'true') {
                        $lab = App\Models\Laboratorium::where('user_id', $user->id)->first();
                        echo 'Kalab di ' . $lab->nama . ' !';
                    } elseif ($dosen->jabatan == 'ketua jurusan') {
                        echo 'Ketua Jurusan!';
                    } else {
                        echo 'Dosen!';
                    }
                } elseif ($user->role == 'mahasiswa') {
                    echo 'Mahasiswa!';
                } else {
                    echo 'Admin';
                }
            @endphp

        </b>


        <ul class="navbar-nav flex-row align-items-center ms-auto">

            {{-- Notifications --}}
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar d-flex align-items-center">
                        <i class='bx bxs-bell bx-sm'></i>
                        @php
                            $jumlah = auth()
                                ->user()
                                ->unreadNotifications->count();
                        @endphp
                        @if ($jumlah)
                            <span class="position-absolute top-50 translate-middle badge rounded-pill bg-danger">
                                <span class="w-25">
                                    {{ $jumlah }}
                                </span>
                                <small class="visually-hidden">unread messages</small>
                            </span>
                        @endif
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end overflow-auto" style="max-height: 500px;">
                    @forelse (auth()->user()->unreadNotifications as $notification)
                        <li>
                            <div class="dropdown-item">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <div class="mb-2">
                                            <i class='{{ $notification->data['icon'] }} me-2'></i>
                                            <small class="fw-bold">{{ $notification->data['title'] }}</small>
                                        </div>
                                        <a href="/{{ $notification->data['uri'] }}"
                                            class="text-underline-none text-dark">
                                            <div>
                                                <small class="d-block text-wrap">
                                                    {{ $notification->data['description'] }}
                                                </small>
                                                <small class="text-muted">
                                                    {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                                </small>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="ms-2">
                                        <form action="/notifikasi/read" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $notification->id }}">
                                            <button type="submit" class="btn btn-light p-0">
                                                <i class='bx bx-x'></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                        </li>
                    @empty
                        <li>
                            <div class="dropdown-item">
                                <center>
                                    <small class="text-muted text-center">Tidak Ada Notifikasi</small>
                                </center>
                            </div>
                        </li>
                    @endforelse
                </ul>
            </li>

            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        @if (auth()->user()->foto)
                            <img src="{{ asset('/storage/' . auth()->user()->foto) }}" alt="Foto Profil"
                                class="w-px-40 h-auto rounded-circle" />
                        @else
                            <img src="{{ asset('img') }}/unknown.png" alt class="w-px-40 h-auto rounded-circle" />
                            {{-- <img src="{{ asset('img') }}/user/{{ rand(1, 2) }}.png" alt
                                class="w-px-40 h-auto rounded-circle" /> --}}
                        @endif
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="/profil">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        @if (auth()->user()->foto)
                                            <img src="{{ asset('/storage/' . auth()->user()->foto) }}" alt="Foto Profil"
                                                class="w-px-40 h-auto rounded-circle" />
                                        @else
                                            <img src="{{ asset('img') }}/unknown.png" alt
                                                class="w-px-40 h-auto rounded-circle" />
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block">{{ auth()->user()->nama }}</span>
                                    <small class="text-muted">{{ auth()->user()->role }}</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                    </li>
                    <li>
                        <a class="dropdown-item" href="/profil">
                            <i class="bx bx-user me-2"></i>
                            <span class="align-middle">Profil</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item"
                            href="https://wa.me/6285814381705?text=Assalamualaikum,%20mau%20minta%20bantuan%20SIMALAKOM">
                            <i class="bx bxl-whatsapp me-2"></i>
                            <span class="align-middle">Hubungi
                            </span>
                        </a>
                    </li>
                    <li>
                        {{-- <a class="dropdown-item" href="auth-login-basic.html"> --}}
                        <div class="dropdown-divider"></div>
                        <button type="button" class="btn btn-light" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            <i class="bx bx-power-off me-2"></i>
                            Logout
                        </button>
                        {{-- <form action="/logout" method="post">
                            @csrf
                            <button type="submit" class="btn btn-light">
                                <i class="bx bx-power-off me-2"></i>Logout
                            </button>
                        </form> --}}

                        {{-- <span class="align-middle">Log Out</span> --}}
                        </a>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>
</nav>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi Logout</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin melakukan Logout?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                <form action="/logout" method="post">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-power-off me-2"></i>Ya
                    </button>
                </form>
                {{-- <button type="button" class="btn btn-primary">Ya</button> --}}
            </div>
        </div>
    </div>
</div>
