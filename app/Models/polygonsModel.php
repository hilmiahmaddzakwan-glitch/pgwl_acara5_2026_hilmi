<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class polygonsModel extends Model
{
    protected $table = 'polygons'; // Sesuaikan dengan nama tabel di database
    protected $guarded = ['id']; // Atau gunakan $fillable untuk menentukan field yang dapat diisi
}
