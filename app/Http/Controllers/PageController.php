<?php

namespace App\Http\Controllers;

use App\Models\PointsModel;
use App\Models\PolygonsModel;
use App\Models\PolylinesModel;
use App\Models\User;
use Illuminate\Http\Request;

class PageController extends Controller
{
    protected $points;
    protected $polylines;
    protected $polygons;

     public function __construct()
    {
        $this->points = new PointsModel();
        $this->polylines = new PolylinesModel();
        $this->polygons = new PolygonsModel();
        $this->user = new User();
    }

    public function landingpage()
    {
        $data = [
            'title' => 'PGWL',

            // Jumlah data
            'point_count' => $this->points->count(),
            'polyline_count' => $this->polylines->count(),
            'polygon_count' => $this->polygons->count(),
            'user_count' => $this->user->count(),
        ];

        return view('home', $data);
    }

    public function peta()
    {
        $data = [
            'title' => 'Peta Yogyakarta',
        ];

        return view('map', $data);
    }

    public function tabel(Request $request)
{
    // Keyword search
    $search = trim($request->search);

    /*
    |--------------------------------------------------------------------------
    | SEARCH POINT
    |--------------------------------------------------------------------------
    */
    $points = PointsModel::query()

        ->when($search, function ($query) use ($search) {

            $query->where(function ($q) use ($search) {

                // Search nama
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%'])

                  // Search deskripsi
                  ->orWhereRaw('LOWER(description) LIKE ?', ['%' . strtolower($search) . '%']);

            });

        })

        ->get();


    /*
    |--------------------------------------------------------------------------
    | SEARCH POLYLINE
    |--------------------------------------------------------------------------
    */
    $polylines = PolylinesModel::query()

        ->when($search, function ($query) use ($search) {

            $query->where(function ($q) use ($search) {

                $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%'])

                  ->orWhereRaw('LOWER(description) LIKE ?', ['%' . strtolower($search) . '%']);

            });

        })

        ->get();


    /*
    |--------------------------------------------------------------------------
    | SEARCH POLYGON
    |--------------------------------------------------------------------------
    */
    $polygons = PolygonsModel::query()

        ->when($search, function ($query) use ($search) {

            $query->where(function ($q) use ($search) {

                $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%'])

                  ->orWhereRaw('LOWER(description) LIKE ?', ['%' . strtolower($search) . '%']);

            });

        })

        ->get();


    /*
    |--------------------------------------------------------------------------
    | DATA
    |--------------------------------------------------------------------------
    */
    $data = [
        'title' => 'Tabel Data',
        'points' => $points,
        'polylines' => $polylines,
        'polygons' => $polygons,
        'search' => $search,
    ];

    return view('table', $data);
}
}
