<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\PointsController;
use App\Http\Controllers\PolygonsController;
use App\Http\Controllers\PolylinesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Route untuk halaman utama (Home)
Route::get('/', [PageController::class, 'landingpage'])->name('home');

// Route halaman peta dengan middleware login
Route::get('/peta', [PageController::class, 'peta'])
    ->middleware('auth')
    ->name('peta');

// Route untuk halaman tabel
Route::get('/tabel', [PageController::class, 'tabel'])->name('tabel');

// ================= CRUD ROUTES FOR POINTS =================
Route::post('/store-points', [PointsController::class, 'store'])->name('points.store');
Route::put('/update-points/{id}', [PointsController::class, 'update'])->name('points.update');
Route::delete('/delete-points/{id}', [PointsController::class, 'destroy'])->name('points.destroy');

// ================= CRUD ROUTES FOR POLYLINES =================
Route::post('/store-polylines', [PolylinesController::class, 'store'])->name('polylines.store');
Route::put('/update-polylines/{id}', [PolylinesController::class, 'update'])->name('polylines.update');
Route::delete('/delete-polylines/{id}', [PolylinesController::class, 'destroy'])->name('polylines.destroy');

// ================= CRUD ROUTES FOR POLYGONS =================
Route::post('/store-polygons', [PolygonsController::class, 'store'])->name('polygons.store');
Route::put('/update-polygons/{id}', [PolygonsController::class, 'update'])->name('polygons.update');
Route::delete('/delete-polygons/{id}', [PolygonsController::class, 'destroy'])->name('polygons.destroy');

// ================= API ROUTES FOR GEOJSON =================
Route::get('/api/geojson-points', [PointsController::class, 'geojson'])->name('api.geojson_points');
Route::get('/api/geojson-polylines', [PolylinesController::class, 'geojson'])->name('api.geojson_polylines');
Route::get('/api/geojson-polygons', [PolygonsController::class, 'geojson'])->name('api.geojson_polygons');

// Route untuk dashboard (dengan middleware auth)
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Route untuk settings (file terpisah)
require __DIR__ . '/settings.php';
