<?php
use App\Http\Controllers\PageController;
use App\Http\Controllers\PointsController;
use App\Http\Controllers\PolygonsController;
use App\Http\Controllers\PolylinesController;
use Illuminate\Support\Facades\Route;

// Route untuk halaman utama (Home)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route untuk halaman peta
Route::get('/peta', [PageController::class, 'peta'])->name('peta');

// Route untuk halaman tabel
Route::get('/tabel', [PageController::class, 'tabel'])->name('tabel');

//Points
Route::post('/store-points', [PointsController::class, 'store'])->name('points.store');

//Polylines
Route::post('/store-polylines', [PolylinesController::class, 'store'])->name('polylines.store');

//Polygons
Route::post('/store-polygons', [PolygonsController::class, 'store'])->name('polygons.store');

// Route untuk dashboard (dengan middleware auth)
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Route untuk settings (file terpisah)
require __DIR__ . '/settings.php';
