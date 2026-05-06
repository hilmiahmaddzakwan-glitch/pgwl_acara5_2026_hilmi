<?php

namespace App\Http\Controllers;

use App\Models\polygonsModel;
use Illuminate\Http\Request;

class PolygonsController extends Controller
{
    public function __construct()
    {
        $this->polygons = new polygonsModel();
    }

    public function store(Request $request)
    {
        $request->validate([
            'geometry' => 'required',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if (!is_dir('storage/images')) {
            mkdir('./storage/images', 0777, true);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_polygon." . strtolower($image->getClientOriginalExtension());
            $image->move('storage/images', $name_image);
        } else {
            $name_image = null;
        }

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'geom' => $request->geometry,
            'image' => $name_image
        ];

        if (!$this->polygons->create($data)) {
            return redirect()->route('peta')->with('error', 'Gagal menyimpan data polygon!');
        }

        return redirect()->route('peta')->with('success', 'Data polygon berhasil disimpan.');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $polygon = $this->polygons->find($id);

        if (!$polygon) {
            return redirect()->route('peta')->with('error', 'Data polygon tidak ditemukan!');
        }

        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            if ($polygon->image && file_exists('storage/images/' . $polygon->image)) {
                unlink('storage/images/' . $polygon->image);
            }

            $image = $request->file('image');
            $name_image = time() . "_polygon." . strtolower($image->getClientOriginalExtension());
            $image->move('storage/images', $name_image);
            $data['image'] = $name_image;
        }

        if (!$this->polygons->where('id', $id)->update($data)) {
            return redirect()->route('peta')->with('error', 'Gagal mengupdate data polygon!');
        }

        return redirect()->route('peta')->with('success', 'Data polygon berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        try {
            $polygon = $this->polygons->find($id);

            if (!$polygon) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data polygon tidak ditemukan!'
                ], 404);
            }

            if ($polygon->image && file_exists('storage/images/' . $polygon->image)) {
                unlink('storage/images/' . $polygon->image);
            }

            $this->polygons->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data polygon berhasil dihapus!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function geojson()
    {
        $polygons = $this->polygons->all();

        $features = [];
        foreach ($polygons as $polygon) {
            $features[] = [
                'type' => 'Feature',
                'geometry' => json_decode($polygon->geom, true),
                'properties' => [
                    'id' => $polygon->id,
                    'name' => $polygon->name,
                    'description' => $polygon->description,
                    'image' => $polygon->image
                ]
            ];
        }

        return response()->json([
            'type' => 'FeatureCollection',
            'features' => $features
        ]);
    }
}
