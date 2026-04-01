<?php

namespace App\Http\Controllers;

use App\Models\PolylinesModel; // Perbaiki: huruf kapital di awal (sesuai standar Laravel)
use Illuminate\Http\Request;

class PolylinesController extends Controller
{
    protected $polylinesModel; // Deklarasikan property dengan benar

    public function __construct()
    {
        $this->polylinesModel = new PolylinesModel(); // Perbaiki: huruf kapital P
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
            'geometry_polyline' => 'required',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ],
        [
            'geometry_polyline.required' => 'Field geometry polyline harus diisi.',
            'name.required' => 'Field name harus diisi.',
            'name.string' => 'Field name harus berupa string.',
            'name.max' => 'Field name tidak boleh lebih dari 255 karakter.',
            'description.string' => 'Field description harus berupa string.',
            'description.required' => 'Field description harus diisi.'
        ]
    );

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'geom' => $request->geometry_polyline,
        ];

        // Perbaiki: gunakan $this->polylinesModel (bukan $this->polylines)
        if (!$this->polylinesModel->create($data)) {
            //Kembali ke halaman peta setelah menyimpan data
            return redirect()->route('peta')->with('error', 'Gagal menyimpan data polyline!');
        }

        // Kembali ke halaman peta setelah menyimpan data
        return redirect()->route('peta')->with('success', 'Data polyline berhasil disimpan.')   ;
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
