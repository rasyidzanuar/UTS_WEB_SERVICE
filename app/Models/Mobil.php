<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    protected $fillable = [
        'nama_mobil', 'harga','deskripsi','gambar'
    ];
}