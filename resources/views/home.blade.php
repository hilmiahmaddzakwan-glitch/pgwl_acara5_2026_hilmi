@extends('layouts.template')

@section('styles')
    <style>
        .container-custom {
            margin-top: 20px;
            margin-bottom: 30px;
        }
    </style>
@endsection

    @section('content')
<!-- Container Landing Page -->
<div class="container container-custom">
    <div class="card border-0 shadow-lg overflow-hidden">

        <!-- Hero Section -->
        <div class="card-body p-0">

            <div class="row g-0 align-items-center">

                <!-- Kiri -->
                <div class="col-lg-6 p-5">

                    <span class="badge bg-primary mb-3 px-3 py-2">
                        Praktikum Pemrograman Geospasial Web Lanjut
                    </span>

                    <h1 class="fw-bold display-5 mb-3 text-dark">
                        WebGIS Interaktif
                    </h1>

                    <!-- Statistik Informasi -->
<div class="row g-3 mb-4">

    <!-- Point -->
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">

            <div class="card-body text-center p-4">

                <div class="mb-3">
                    <i class="bi bi-geo-alt-fill text-primary fs-1"></i>
                </div>

                <h6 class="fw-bold text-muted mb-2">
                    Jumlah Point
                </h6>

                <!-- Angka -->
                <h2 class="fw-bold text-primary mb-0">
                    {{ $point_count }}
                </h2>

            </div>

        </div>
    </div>

    <!-- Polyline -->
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">

            <div class="card-body text-center p-4">

                <div class="mb-3">
                    <i class="bi bi-bezier2 text-success fs-1"></i>
                </div>

                <h6 class="fw-bold text-muted mb-2">
                    Jumlah Polyline
                </h6>

                <!-- Angka -->
                <h2 class="fw-bold text-success mb-0">
                    {{ $polyline_count }}
                </h2>

            </div>

        </div>
    </div>

    <!-- Polygon -->
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">

            <div class="card-body text-center p-4">

                <div class="mb-3">
                    <i class="bi bi-bounding-box text-warning fs-1"></i>
                </div>

                <h6 class="fw-bold text-muted mb-2">
                    Jumlah Polygon
                </h6>

                <!-- Angka -->
                <h2 class="fw-bold text-warning mb-0">
                    {{ $polygon_count }}
                </h2>

            </div>

        </div>
    </div>

    <!-- Pengguna -->
    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm rounded-4 h-100">

            <div class="card-body text-center p-4">

                <div class="mb-3">
                    <i class="bi bi-people-fill text-danger fs-1"></i>
                </div>

                <h6 class="fw-bold text-muted mb-2">
                    Jumlah Pengguna
                </h6>

                <!-- Angka -->
                <h2 class="fw-bold text-danger mb-0">
                    {{ $user_count }}
                </h2>

            </div>

        </div>
    </div>

</div>

                    <p class="text-muted fs-5 mb-4" style="text-align: justify;">
                        Platform WebGIS interaktif yang dikembangkan untuk mendukung
                        visualisasi, analisis, dan penyajian data spasial secara modern.
                        Sistem ini dibuat sebagai bagian dari kegiatan praktikum
                        Pemrograman Geospasial Web Lanjut Program Studi Sistem Informasi
                        Geografis Universitas Gadjah Mada.
                    </p>

                    <!-- Informasi -->
                    <div class="mb-4">

                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-person-circle text-primary fs-3 me-3"></i>
                            <div>
                                <h6 class="mb-0 fw-bold">Pengembang</h6>
                                <small class="text-muted">
                                    Hilmi Ahmad Dzakwan
                                </small>
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-mortarboard-fill text-primary fs-3 me-3"></i>
                            <div>
                                <h6 class="mb-0 fw-bold">Program Studi</h6>
                                <small class="text-muted">
                                    Sistem Informasi Geografis - Universitas Gadjah Mada
                                </small>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <i class="bi bi-globe-asia-australia text-primary fs-3 me-3"></i>
                            <div>
                                <h6 class="mb-0 fw-bold">Fokus Sistem</h6>
                                <small class="text-muted">
                                    Pemetaan Web Interaktif dan Visualisasi Data Spasial
                                </small>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- Kanan -->
                <div class="col-lg-6">

                    <div class="position-relative h-100">

                        <img src="https://images.unsplash.com/photo-1528127269322-539801943592?q=80&w=1400&auto=format&fit=crop"
                             class="img-fluid w-100 h-100 object-fit-cover"
                             style="min-height: 500px;"
                             alt="WebGIS Yogyakarta">

                        <!-- Overlay -->
                        <div class="position-absolute top-0 start-0 w-100 h-100"
                             style="background: linear-gradient(to right, rgba(13,110,253,0.15), rgba(0,0,0,0.45));">
                        </div>

                        <!-- Floating Card -->
                        <div class="position-absolute bottom-0 start-0 m-4 bg-white p-4 rounded-4 shadow-lg"
                             style="max-width: 320px;">

                            <h5 class="fw-bold text-primary mb-2">
                                Interactive Web Mapping
                            </h5>

                            <p class="text-muted mb-0 small">
                                Integrasi teknologi pemetaan digital berbasis web
                                untuk penyajian informasi spasial yang modern,
                                responsif, dan interaktif.
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
</div>
@endsection
