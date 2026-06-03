<!-- Navbar Bootstrap -->
<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">

    <div class="container-fluid px-4">

        <!-- Brand -->
        <a class="navbar-brand fw-bold d-flex align-items-center"
           href="{{ route('home') }}">

            <i class="fas fa-map-marked-alt text-primary me-2 fs-4"></i>

            <span>
                {{ $title ?? 'WebGIS PGWL' }}
            </span>

        </a>

        <!-- Toggle Mobile -->
        <button class="navbar-toggler border-0 shadow-none"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>

        </button>

        <!-- Navbar Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">

            <!-- Menu Tengah -->
            <ul class="navbar-nav mx-auto">

                <!-- Home -->
                <li class="nav-item mx-1">

                    <a class="nav-link fw-semibold"
                       href="{{ route('home') }}">

                        <i class="fas fa-home me-1"></i>
                        Home

                    </a>

                </li>

                <!-- Peta -->
                <li class="nav-item mx-1">

                    <a class="nav-link fw-semibold"
                       href="{{ route('peta') }}">

                        <i class="fas fa-map me-1"></i>
                        Peta

                    </a>

                </li>

                <!-- Tabel -->
                <li class="nav-item mx-1">

                    <a class="nav-link fw-semibold"
                       href="{{ route('tabel') }}">

                        <i class="fas fa-table me-1"></i>
                        Tabel

                    </a>

                </li>

                <!-- Tentang -->
                <li class="nav-item mx-1">

                    <a class="nav-link fw-semibold"
                       href="#">

                        <i class="fas fa-info-circle me-1"></i>
                        Tentang

                    </a>

                </li>

            </ul>

            <!-- Auth -->
            <ul class="navbar-nav ms-auto align-items-center">

                <!-- Jika Belum Login -->
                @guest
                <li class="nav-item">

                    <a href="{{ route('login') }}"
                       class="btn btn-primary rounded-pill px-4 py-2 d-flex align-items-center">

                        <i class="fas fa-sign-in-alt me-2"></i>
                        Login

                    </a>

                </li>
                @endguest

                <!-- Jika Sudah Login -->
                @auth
                <li class="nav-item dropdown">

                    <!-- User -->
                    <a class="btn btn-light border rounded-pill px-3 py-2 d-flex align-items-center dropdown-toggle"
                       href="#"
                       role="button"
                       data-bs-toggle="dropdown"
                       aria-expanded="false">

                        <i class="fas fa-user-circle text-primary me-2"></i>

                        {{ Auth::user()->name }}

                    </a>

                    <!-- Dropdown -->
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 mt-2">

                        <!-- Logout -->
                        <li>

                            <form action="{{ route('logout') }}"
                                  method="POST">

                                @csrf

                                <button type="submit"
                                        class="dropdown-item py-2 text-danger">

                                    <i class="fas fa-right-from-bracket me-2"></i>
                                    Logout

                                </button>

                            </form>

                        </li>

                    </ul>

                </li>
                @endauth

            </ul>

        </div>

    </div>

</nav>
