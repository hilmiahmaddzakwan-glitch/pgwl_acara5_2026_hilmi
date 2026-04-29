<?php

namespace App\Http\Controllers;

use App\Models\PolygonsModel;
use Illuminate\Http\Request;

class PolygonsController extends Controller
{
    public function __construct()
    {
        $this->polygonsModel = new PolygonsModel();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
    $request->validate(
        [
            'geometry_polygon' => 'required',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ],
        [
            'geometry_polygon.required' => 'Field geometry polygon harus diisi.',
            'name.required' => 'Field name harus diisi.',
            'name.string' => 'Field name harus berupa string.',
            'name.max' => 'Field name tidak boleh lebih dari 255 karakter.',
            'description.string' => 'Field description harus berupa string.',
            'description.required' => 'Field description harus diisi.'
        ]
    );

    ///Create directory if not exist
    if (!is_dir('storage/images')) {
   mkdir('./storage/images', 0777);
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
            'geom' => $request->geometry_polygon,
            'image' => $name_image
        ];

        // Perbaiki: gunakan $this->polygonsModel (bukan $this->polylines)
         if (!$this->polygonsModel->create($data)) {
            //Kembali ke halaman peta setelah menyimpan data
            return redirect()->route('peta')->with('error', 'Gagal menyimpan data polygon!');
        }

        // Kembali ke halaman peta setelah menyimpan data
        return redirect()->route('peta')->with('success', 'Data polygon berhasil disimpan.')   ;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
