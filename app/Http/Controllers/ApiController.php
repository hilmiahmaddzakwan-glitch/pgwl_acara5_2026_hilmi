<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PointsModel;
use App\Models\PolylinesModel;
use App\Models\PolygonsModel;

class ApiController extends Controller
{
    protected $points;
    protected $polylines;

    public function __construct()
    {
        $this->points = new PointsModel();
        $this->polylines = new PolylinesModel();
         $this->polygons = new PolygonsModel();
    }

    public function geojson_points()
    {
        $points = $this->points->geojson_points();
        return response()->json($points, 200, [], JSON_NUMERIC_CHECK);
    }

    public function geojson_polylines()
{
    $data = $this->polylines->geojson_polylines();
    return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
}

public function geojson_polygons()
{
    $data = $this->polygons->geojson_polygons();
    return response()->json($data, 200, [], JSON_NUMERIC_CHECK);
}
}
