<?php

use Illuminate\Support\Facades\Route;

// Rute Home (Bawaan Laravel atau buat view sendiri)
Route::get('/', function () {
    return view('profil'); // Pastikan file welcome.blade.php ada
});

// Rute Kontak (Dari tugas sebelumnya)
Route::get('/kontak', function () {
    return view('kontak');
});

// 3 Rute Baru
Route::get('/profil', function () {
    return view('profil');
});

Route::get('/katalog', function () {
    return view('katalog');
});

Route::get('/bantuan', function () {
    return view('bantuan');
});