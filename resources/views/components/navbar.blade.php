<!-- Navbar Bootstrap -->
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <i class="fas fa-map-marked-alt me-2"></i>
            {{ $title ?? 'Tabel Yogyakarta' }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('home') }}">
                        <i class="fas fa-home me-1"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('peta') }}">
                        <i class="fas fa-map me-1"></i> Peta
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('tabel') }}">
                        <i class="fas fa-table me-1"></i> Tabel
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-info-circle me-1"></i> Tentang
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
