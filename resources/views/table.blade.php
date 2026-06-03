@extends('layouts.template')

@section('styles')
<style>

    .container-custom{
        margin-top: 20px;
        margin-bottom: 30px;
    }

    .table img{
        width: 140px;
        height: 90px;
        object-fit: cover;
        border-radius: 10px;
    }

</style>
@endsection

@section('content')

<div class="container container-custom">

    <!-- Search -->
<div class="card border-0 shadow rounded-4 mb-4">

    <div class="card-body">

        <form action="{{ route('tabel') }}" method="GET">

            <div class="row g-2 align-items-center">

                <!-- Input -->
                <div class="col-md-10">

                    <input type="text"
                           name="search"
                           class="form-control"
                           placeholder="Cari berdasarkan nama..."
                           value="{{ $search }}">

                </div>

                <!-- Button -->
                <div class="col-md-2 d-grid">

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="fas fa-search me-1"></i>
                        Search

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

    <!-- ================= POINT ================= -->
    <div class="card border-0 shadow rounded-4 overflow-hidden mb-5">

        <div class="card-header bg-primary text-white">
            <h3 class="mb-0">Tabel Data Point</h3>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-striped table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Gambar</th>
                            <th>Tanggal Dibuat</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($points as $p)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $p->name }}</td>

                            <td>{{ $p->description }}</td>

                            <td>

                                @if($p->image)

                                    <img src="{{ asset('storage/images/' . $p->image) }}"
                                         alt="{{ $p->name }}"
                                         class="img-fluid rounded shadow-sm">

                                @else

                                    <span class="text-muted">
                                        Tidak ada gambar
                                    </span>

                                @endif

                            </td>

                            <td>{{ $p->created_at }}</td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Data point tidak tersedia
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

   <!-- ================= POLYLINE ================= -->
<div class="card border-0 shadow rounded-4 overflow-hidden mb-5">

    <div class="card-header bg-success text-white">
        <h3 class="mb-0">Tabel Data Polyline</h3>
    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-striped table-hover align-middle">

                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Gambar</th>
                        <th>Tanggal Dibuat</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($polylines as $pl)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $pl->name }}</td>

                        <td>{{ $pl->description }}</td>

                        <!-- Gambar -->
                        <td>

                            @if($pl->image)

                                <img src="{{ asset('storage/images/' . $pl->image) }}"
                                     alt="{{ $pl->name }}"
                                     class="img-fluid rounded shadow-sm">

                            @else

                                <span class="text-muted">
                                    Tidak ada gambar
                                </span>

                            @endif

                        </td>

                        <td>{{ $pl->created_at }}</td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            Data polyline tidak tersedia
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<!-- ================= POLYGON ================= -->
<div class="card border-0 shadow rounded-4 overflow-hidden">

    <div class="card-header bg-warning text-dark">
        <h3 class="mb-0">Tabel Data Polygon</h3>
    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-striped table-hover align-middle">

                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Gambar</th>
                        <th>Tanggal Dibuat</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($polygons as $pg)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $pg->name }}</td>

                        <td>{{ $pg->description }}</td>

                        <!-- Gambar -->
                        <td>

                            @if($pg->image)

                                <img src="{{ asset('storage/images/' . $pg->image) }}"
                                     alt="{{ $pg->name }}"
                                     class="img-fluid rounded shadow-sm">

                            @else

                                <span class="text-muted">
                                    Tidak ada gambar
                                </span>

                            @endif

                        </td>

                        <td>{{ $pg->created_at }}</td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            Data polygon tidak tersedia
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
