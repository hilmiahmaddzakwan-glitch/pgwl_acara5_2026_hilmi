<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function peta()
    {
        $data = [
            'title' => 'Peta Yogyakarta',
        ];
        return view('map', $data);
    }

    public function tabel()
    {
        $data = [
            'title' => 'Tabel Yogyakarta',
        ];
        return view('table', $data);
    }
}
