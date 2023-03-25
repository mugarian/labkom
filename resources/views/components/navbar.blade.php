<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <p>{{ auth()->user()->nama }}</p>

        <ul class="navbar-nav flex-row align-items-center ms-auto">

            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="{{ asset('img') }}/unknown.png" alt class="w-px-40 h-auto rounded-circle" />
                        {{-- @if (auth()->user()->gambar)
                            <img src="{{ asset('/storage/' . auth()->user()->gambar) }}" alt="Foto Profil"
                                class="w-px-40 h-auto rounded-circle" />
                        @else
                            <img src="{{ asset('img') }}/user/{{ rand(1, 2) }}.png" alt
                                class="w-px-40 h-auto rounded-circle" />
                        @endif --}}
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="/profil">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="{{ asset('img') }}/unknown.png" alt
                                            class="w-px-40 h-auto rounded-circle" />
                                        {{-- @if (auth()->user()->gambar)
                                            <img src="{{ asset('/storage/' . auth()->user()->gambar) }}"
                                                alt="Foto Profil" class="w-px-40 h-auto rounded-circle" />
                                        @else
                                        @endif --}}
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
                        <a class="dropdown-item" href="#">
                            <i class="bx bx-user me-2"></i>
                            <span class="align-middle">Profile</span>
                        </a>
                    </li>
                    <li>
                        {{-- <a class="dropdown-item" href="auth-login-basic.html"> --}}
                        <div class="dropdown-divider"></div>
                        <form action="/logout" method="post">
                            @csrf
                            <button type="submit" class="btn btn-light">
                                <i class="bx bx-power-off me-2"></i>Logout
                            </button>
                        </form>
                        {{-- <span class="align-middle">Log Out</span> --}}
                        </a>
                    </li>
                </ul>
            </li>
            <!--/ User -->
        </ul>
    </div>
</nav>
