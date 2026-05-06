<?php

namespace App\Http\Controllers;

use App\Models\polylinesModel;
use Illuminate\Http\Request;

class PolylinesController extends Controller
{
    public function __construct()
    {
        $this->polylines = new polylinesModel();
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'geometry' => 'required',
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
            ]
        );

        if (!is_dir('storage/images')) {
            mkdir('./storage/images', 0777, true);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_polyline." . strtolower($image->getClientOriginalExtension());
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

        if (!$this->polylines->create($data)) {
            return redirect()->route('peta')->with('error', 'Gagal menyimpan data polyline!');
        }

        return redirect()->route('peta')->with('success', 'Data polyline berhasil disimpan.');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $polyline = $this->polylines->find($id);

        if (!$polyline) {
            return redirect()->route('peta')->with('error', 'Data polyline tidak ditemukan!');
        }

        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            if ($polyline->image && file_exists('storage/images/' . $polyline->image)) {
                unlink('storage/images/' . $polyline->image);
            }

            $image = $request->file('image');
            $name_image = time() . "_polyline." . strtolower($image->getClientOriginalExtension());
            $image->move('storage/images', $name_image);
            $data['image'] = $name_image;
        }

        if (!$this->polylines->where('id', $id)->update($data)) {
            return redirect()->route('peta')->with('error', 'Gagal mengupdate data polyline!');
        }

        return redirect()->route('peta')->with('success', 'Data polyline berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        try {
            $polyline = $this->polylines->find($id);

            if (!$polyline) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data polyline tidak ditemukan!'
                ], 404);
            }

            if ($polyline->image && file_exists('storage/images/' . $polyline->image)) {
                unlink('storage/images/' . $polyline->image);
            }

            $this->polylines->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data polyline berhasil dihapus!'
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
        $polylines = $this->polylines->all();

        $features = [];
        foreach ($polylines as $polyline) {
            $features[] = [
                'type' => 'Feature',
                'geometry' => json_decode($polyline->geom, true),
                'properties' => [
                    'id' => $polyline->id,
                    'name' => $polyline->name,
                    'description' => $polyline->description,
                    'image' => $polyline->image
                ]
            ];
        }

        return response()->json([
            'type' => 'FeatureCollection',
            'features' => $features
        ]);
    }
}
