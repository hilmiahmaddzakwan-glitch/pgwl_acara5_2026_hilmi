<?php

namespace App\Http\Controllers;

use App\Models\pointsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PointsController extends Controller
{
    public function __construct()
    {
        $this->points = new pointsModel();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate(
            [
                'geometry' => 'required',
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
            ],
            [
                'geometry.required' => 'Field geometry harus diisi.',
                'name.required' => 'Field name harus diisi.',
                'name.string' => 'Field name harus berupa string.',
                'name.max' => 'Field name tidak boleh lebih dari 255 karakter.',
                'description.required' => 'Field description harus diisi.',
                'image.image' => 'File harus berupa gambar.',
                'image.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
                'image.max' => 'Ukuran gambar maksimal 2MB.'
            ]
        );

        // Create directory if not exist
        if (!is_dir('storage/images')) {
            mkdir('./storage/images', 0777, true);
        }

        // Get the upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_point." . strtolower($image->getClientOriginalExtension());
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

        // Simpan data ke database
        if (!$this->points->create($data)) {
            return redirect()->route('peta')->with('error', 'Gagal menyimpan data point!');
        }

        return redirect()->route('peta')->with('success', 'Data point berhasil disimpan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
            ],
            [
                'name.required' => 'Field name harus diisi.',
                'description.required' => 'Field description harus diisi.',
                'image.image' => 'File harus berupa gambar.',
                'image.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
                'image.max' => 'Ukuran gambar maksimal 2MB.'
            ]
        );

        // Cari data berdasarkan ID
        $point = $this->points->find($id);

        if (!$point) {
            return redirect()->route('peta')->with('error', 'Data point tidak ditemukan!');
        }

        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];

        // Handle image upload
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($point->image && file_exists('storage/images/' . $point->image)) {
                unlink('storage/images/' . $point->image);
            }

            // Upload gambar baru
            $image = $request->file('image');
            $name_image = time() . "_point." . strtolower($image->getClientOriginalExtension());
            $image->move('storage/images', $name_image);
            $data['image'] = $name_image;
        }

        // Update data
        if (!$this->points->where('id', $id)->update($data)) {
            return redirect()->route('peta')->with('error', 'Gagal mengupdate data point!');
        }

        return redirect()->route('peta')->with('success', 'Data point berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Cari data berdasarkan ID
            $point = $this->points->find($id);

            if (!$point) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data point tidak ditemukan!'
                ], 404);
            }

            // Hapus file gambar jika ada
            if ($point->image && file_exists('storage/images/' . $point->image)) {
                unlink('storage/images/' . $point->image);
            }

            // Hapus data dari database
            $this->points->where('id', $id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Data point berhasil dihapus!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get GeoJSON data for points
     */
    public function geojson()
    {
        $points = $this->points->all();

        $features = [];
        foreach ($points as $point) {
            $features[] = [
                'type' => 'Feature',
                'geometry' => json_decode($point->geom, true),
                'properties' => [
                    'id' => $point->id,
                    'name' => $point->name,
                    'description' => $point->description,
                    'image' => $point->image
                ]
            ];
        }

        return response()->json([
            'type' => 'FeatureCollection',
            'features' => $features
        ]);
    }
}
