<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    // Tambahkan kolom sesuai yang ada di database kamu
    protected $fillable = [
        'category_id', 'title', 'description', 'date', 
        'location', 'price', 'stock', 'poster_path'
    ];
}