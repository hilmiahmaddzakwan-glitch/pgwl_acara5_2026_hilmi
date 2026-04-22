<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//GeoJSON API
Route::get('/geojson_points', [ApiController::class, 'geojson_points'])
    ->name('api.geojson_points');

Route::get('/geojson_polylines', [ApiController::class, 'geojson_polylines'])
    ->name('api.geojson_polylines');

Route::get('/geojson_polygons', [ApiController::class, 'geojson_polygons'])
    ->name('api.geojson_polygons');
