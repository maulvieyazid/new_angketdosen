<!-- Navbar -->
<header class="navbar navbar-expand-md d-print-none" data-bs-theme="dark">
    <div class="container-xl">
        <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbar-menu" type="button" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
            Aplikasi Angket Dosen
        </h1>
        <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item dropdown">
                <a class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" href="#" aria-label="Open user menu">
                    <div class="d-none d-md-block ps-2 me-2">
                        <div>{{ auth()->user()->nama }} ({{ auth()->user()->nik }})</div>
                        <div class="mt-1 small">
                            @php
                                $nama_bagian_user = auth()->user()->departemen->nama ?? null;
                                $title = '';
                                if (auth()->user()->is_kaprodi) {
                                    $title = 'Kaprodi';
                                }
                                if (auth()->user()->is_dekan) {
                                    $title = 'Dekan';
                                }

                            @endphp
                            {{ $title . ' ' . ucwords(strtolower($nama_bagian_user)) }}
                        </div>
                    </div>
                    <span class="avatar avatar-sm bg-white">
                        {{ auth()->user()->inisial }}
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a class="dropdown-item" href="{{ route('logout') }}">Logout</a>
                </div>
            </div>
        </div>
    </div>
</header>


<header class="navbar-expand-md">
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div class="navbar">
            <div class="container-xl">

                <ul class="navbar-nav">

                    <li class="nav-item {{ $navbar == 'home' ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('home') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                </svg>
                            </span>
                            <span class="nav-link-title">
                                Home
                            </span>
                        </a>
                    </li>


                    @php
                        $karyawan = auth()->user();
                        $exclusive = in_array(1, [$karyawan->is_dekan, $karyawan->is_warek_1, $karyawan->is_admin_fakultas, $karyawan->is_kaprodi, $karyawan->is_p3ai]);
                    @endphp
                    @if ($exclusive)
                        <li class="nav-item {{ $navbar == 'hasil-angket' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('index.hasil-angket') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg class="icon icon-tabler icon-tabler-report" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M8 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h5.697" />
                                        <path d="M18 14v4h4" />
                                        <path d="M18 11v-4a2 2 0 0 0 -2 -2h-2" />
                                        <path d="M8 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                        <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                        <path d="M8 11h4" />
                                        <path d="M8 15h3" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Hasil Angket
                                </span>
                            </a>
                        </li>
                    @endif

                    @if (auth()->user()->is_p3ai)
                        <li class="nav-item {{ $navbar == 'pertanyaan' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('index.pertanyaan') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg class="icon icon-tabler icon-tabler-checkup-list" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                        <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                        <path d="M9 14h.01" />
                                        <path d="M9 17h.01" />
                                        <path d="M12 16l1 1l3 -3" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Maintenance Pertanyaan
                                </span>
                            </a>
                        </li>
                    @endif

                    @if (auth()->user()->is_p3ai)
                        <li class="nav-item {{ $navbar == 'kategori' ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('index.kategori') }}">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg class="icon icon-tabler icon-tabler-category" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 4h6v6h-6z" />
                                        <path d="M14 4h6v6h-6z" />
                                        <path d="M4 14h6v6h-6z" />
                                        <path d="M17 17m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                                    </svg>
                                </span>
                                <span class="nav-link-title">
                                    Maintenance Kategori
                                </span>
                            </a>
                        </li>
                    @endif


                </ul>

            </div>
        </div>
    </div>
</header>
