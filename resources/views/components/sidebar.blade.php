<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        {{-- Logo --}}
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('img/logo.png') }}" width="40" alt="logo sistem">
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2">SIMALAKOM</span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    {{-- Sidebar --}}
    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
            <a href="/dashboard" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Layouts -->
        <li class="menu-item {{ Request::is('profil') ? 'active' : '' }}">
            <a href="/profil" class="menu-link">
                <i class="menu-icon tf-icons bx bx-user-circle"></i>
                <div data-i18n="Layouts">Profil</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('scan*') ? 'active' : '' }}">
            <a href="/scan" class="menu-link">
                <i class="menu-icon tf-icons bx bx-scan"></i>
                <div data-i18n="Layouts">Scan</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase my-0">
            <span class="menu-header-text">Pengelolaan</span>
        </li>

        <li class="menu-item {{ Request::is('pelaksanaan*', 'permohonan*') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-calendar"></i>
                <div data-i18n="kegiatan">Kegiatan</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ Request::is('pelaksanaan*') ? 'active' : '' }}">
                    <a href="/pelaksanaan" class="menu-link">
                        {{-- <i class="menu-icon tf-icons bx bx-calendar"></i> --}}
                        <div data-i18n="Misc">Pelaksanaan Praktikum</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('permohonan*') ? 'active' : '' }}">
                    <a href="/permohonan" class="menu-link">
                        {{-- <i class="menu-icon tf-icons bx bx-calendar"></i> --}}
                        <div data-i18n="Misc">Permohonan Kegiatan</div>
                    </a>
                </li>
            </ul>
        </li>

        <li
            class="menu-item {{ Request::is('alat*', 'barangpakai*', 'bahanjurusan*', 'bahanpraktikum*') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-package"></i>
                <div data-i18n="kegiatan">Inventori</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ Request::is('alat*', 'barangpakai*') ? 'active' : '' }}">
                    <a href="/alat" class="menu-link">
                        {{-- <i class="menu-icon tf-icons bx bx-calendar"></i> --}}
                        <div data-i18n="Misc">Alat</div>
                    </a>
                </li>
                {{-- <li class="menu-item {{ Request::is('barangpakai*') ? 'active' : '' }}">
                    <a href="/barangpakai" class="menu-link">
                        <div data-i18n="Misc">Barang Pakai (Alat)</div>
                    </a>
                </li> --}}
                <li class="menu-item {{ Request::is('bahanpraktikum*') ? 'active' : '' }}">
                    <a href="/bahanpraktikum" class="menu-link">
                        {{-- <i class="menu-icon tf-icons bx bx-calendar"></i> --}}
                        <div data-i18n="Misc">Bahan Praktikum</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('bahanjurusan*') ? 'active' : '' }}">
                    <a href="/bahanjurusan" class="menu-link">
                        {{-- <i class="menu-icon tf-icons bx bx-calendar"></i> --}}
                        <div data-i18n="Misc">Bahan Jurusan</div>
                    </a>
                </li>
            </ul>
        </li>
        <li
            class="menu-item {{ Request::is('pemakaian*', 'peminjamanalat*', 'peminjamanbahan*', 'penggunaan*') ? 'active' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-book"></i>
                <div data-i18n="kegiatan">Logbook</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ Request::is('pemakaian*') ? 'active' : '' }}">
                    <a href="/pemakaian" class="menu-link">
                        {{-- <i class="menu-icon tf-icons bx bx-calendar"></i> --}}
                        <div data-i18n="Misc">Pemakaian Alat</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('penggunaan*') ? 'active' : '' }}">
                    <a href="/penggunaan" class="menu-link">
                        {{-- <i class="menu-icon tf-icons bx bx-calendar"></i> --}}
                        <div data-i18n="Misc">Penggunaan Bahan Praktikum</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('peminjamanalat*') ? 'active' : '' }}">
                    <a href="/peminjamanalat" class="menu-link">
                        {{-- <i class="menu-icon tf-icons bx bx-calendar"></i> --}}
                        <div data-i18n="Misc">Peminjaman Alat</div>
                    </a>
                </li>
                <li class="menu-item {{ Request::is('peminjamanbahan*') ? 'active' : '' }}">
                    <a href="/peminjamanbahan" class="menu-link">
                        {{-- <i class="menu-icon tf-icons bx bx-calendar"></i> --}}
                        <div data-i18n="Misc">Peminjaman Bahan Jurusan</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ Request::is('laboratorium*') ? 'active' : '' }}">
            <a href="/laboratorium" class="menu-link">
                <i class="menu-icon tf-icons bx bx-door-open"></i>
                <div data-i18n="Misc">Laboratorium</div>
            </a>
        </li>

        <li class="menu-item {{ Request::is('kelas*') ? 'active' : '' }}">
            <a href="/kelas" class="menu-link">
                <i class="menu-icon tf-icons bx bx-chalkboard"></i>
                <div data-i18n="Misc">Kelas</div>
            </a>
        </li>


        @if (auth()->user()->role != 'mahasiswa')
            @php
                $user = App\Models\User::find(auth()->user()->id);
                $dosen = App\Models\Dosen::where('user_id', $user->id)->first();
            @endphp
            @if ($user->role == 'dosen')
                @if ($dosen->kepalalab == 'true')
                    <li class="menu-header small text-uppercase my-0">
                        <span class="menu-header-text">Rekomendasi Pengajuan</span>
                    </li>
                    <li class="menu-item {{ Request::is('training*', 'rule*', 'prediksi*') ? 'active' : '' }}">
                        <a href="javascript:void(0);" class="menu-link menu-toggle">
                            <i class='menu-icon tf-icons bx bx-sitemap'></i>
                            <div data-i18n="kegiatan">Pengajuan</div>
                        </a>
                        <ul class="menu-sub">
                            <li class="menu-item {{ Request::is('training*') ? 'active' : '' }}">
                                <a href="/training" class="menu-link">
                                    {{-- <i class="menu-icon tf-icons bx bx-calendar"></i> --}}
                                    <div data-i18n="Misc">Data Training</div>
                                </a>
                            </li>
                            <li class="menu-item {{ Request::is('rule*') ? 'active' : '' }}">
                                <a href="/rule" class="menu-link">
                                    {{-- <i class="menu-icon tf-icons bx bx-calendar"></i> --}}
                                    <div data-i18n="Misc">Hasil Rule</div>
                                </a>
                            </li>
                            <li class="menu-item {{ Request::is('prediksi*') ? 'active' : '' }}">
                                <a href="/prediksi" class="menu-link">
                                    {{-- <i class="menu-icon tf-icons bx bx-calendar"></i> --}}
                                    <div data-i18n="Misc">Prediksi</div>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            @endif
            @if (auth()->user()->role == 'admin')
                <li class="menu-header small text-uppercase my-0">
                    <span class="menu-header-text">Rekomendasi Pengajuan</span>
                </li>
                <li class="menu-item {{ Request::is('training*', 'rule*', 'prediksi*') ? 'active' : '' }}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class='menu-icon tf-icons bx bx-sitemap'></i>
                        <div data-i18n="kegiatan">Pengajuan</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{ Request::is('training*') ? 'active' : '' }}">
                            <a href="/training" class="menu-link">
                                {{-- <i class="menu-icon tf-icons bx bx-calendar"></i> --}}
                                <div data-i18n="Misc">Data Training</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::is('rule*') ? 'active' : '' }}">
                            <a href="/rule" class="menu-link">
                                {{-- <i class="menu-icon tf-icons bx bx-calendar"></i> --}}
                                <div data-i18n="Misc">Hasil Rule</div>
                            </a>
                        </li>
                        <li class="menu-item {{ Request::is('prediksi*') ? 'active' : '' }}">
                            <a href="/prediksi" class="menu-link">
                                {{-- <i class="menu-icon tf-icons bx bx-calendar"></i> --}}
                                <div data-i18n="Misc">Prediksi</div>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        @endif


        @if (auth()->user()->role == 'admin')
            <li class="menu-header small text-uppercase my-0">
                <span class="menu-header-text">Akun Pengguna</span>
            </li>
            <li class="menu-item {{ Request::is('dosen*', 'mahasiswa*') ? 'active' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-group"></i>
                    <div data-i18n="Layouts">Akun</div>
                </a>

                <ul class="menu-sub">
                    <li class="menu-item {{ Request::is('dosen*') ? 'active' : '' }}">
                        <a href="/dosen" class="menu-link">
                            {{-- <i class="menu-icon tf-icons bx bx-group"></i> --}}
                            <div data-i18n="Misc">Dosen</div>
                        </a>
                    </li>
                    <li class="menu-item {{ Request::is('mahasiswa*') ? 'active' : '' }}">
                        <a href="/mahasiswa" class="menu-link">
                            {{-- <i class="menu-icon tf-icons bx bx-group"></i> --}}
                            <div data-i18n="Misc">Mahasiswa</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif
    </ul>
</aside>
