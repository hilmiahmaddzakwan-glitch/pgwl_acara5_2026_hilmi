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
    <!-- Container untuk Tabel -->
    <div class="container container-custom">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">Tabel Data Tempat Wisata Yogyakarta</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nama Tempat</th>
                                <th>Deskripsi / Lokasi</th>
                                <th>Koordinat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Bundaran UGM</td>
                                <td>Jalan Pancasila, Sleman</td>
                                <td>-7.7712, 110.3774</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Monumen Jogja Kembali</td>
                                <td>Ringroad Utara, Sleman</td>
                                <td>-7.7499, 110.3789</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Tugu Yogyakarta</td>
                                <td>Jalan Malioboro, Yogyakarta</td>
                                <td>-7.7828, 110.3671</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Alun-Alun Yogyakarta</td>
                                <td>Jalan Tugu, Yogyakarta</td>
                                <td>-7.8005, 110.3646</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Keraton Yogyakarta</td>
                                <td>Jalan Rotowijayan, Yogyakarta</td>
                                <td>-7.8055, 110.3642</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>Malioboro</td>
                                <td>Jalan Malioboro, Yogyakarta</td>
                                <td>-7.7924, 110.3665</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-muted">
                Total Data: 6 tempat wisata
            </div>
        </div>
    </div>
@endsection