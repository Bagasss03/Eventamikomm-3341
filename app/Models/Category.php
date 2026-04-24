<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // WAJIB ADA: agar 'slug' tidak diblokir oleh Laravel
    protected $fillable = ['name', 'slug'];
}