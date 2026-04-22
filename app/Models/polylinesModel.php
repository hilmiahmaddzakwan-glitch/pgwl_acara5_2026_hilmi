<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PolylinesModel extends Model
{
    protected $table = 'polylines';
    protected $guarded = ['id'];

    public function geojson_polylines()
    {
        $lines = $this->select(DB::raw("
            id,
            ST_AsGeoJSON(geom) as geojson,
            name,
            description,
            created_at,
            updated_at
        "))->get();

        $geojson = [
            'type' => 'FeatureCollection',
            'features' => []
        ];

        foreach ($lines as $l) {
            $feature = [
                'type' => 'Feature',
                'geometry' => json_decode($l->geojson),
                'properties' => [
                    'id' => $l->id,
                    'name' => $l->name,
                    'description' => $l->description,
                    'created_at' => $l->created_at,
                    'updated_at' => $l->updated_at,
                ]
            ];

            $geojson['features'][] = $feature;
        }

        return $geojson;
    }
}
