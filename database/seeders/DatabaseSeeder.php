<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 0. Opsional: Hapus data lama agar tidak duplikat saat dijalankan ulang
        // Schema::disableForeignKeyConstraints();
        // User::truncate();
        // Event::truncate();
        // Category::truncate();
        // Schema::enableForeignKeyConstraints();

        // 1. Akun Admin Utama
        // Menggunakan updateOrCreate agar tidak error jika dijalankan berkali-kali
        User::updateOrCreate(
            ['email' => 'admin@amikom.ac.id'],
            [
                'name'     => 'Admin Amikom',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        // 2. Insert Kategori Event
        // Gunakan updateOrCreate agar slug unik tidak menyebabkan error
        // Ganti bagian kategori jadi seperti ini:
            $categoryIT = Category::create([
                'name' => 'Seminar IT',
                'slug' => 'seminar-it', // Kolom ini wajib ada!
            ]);

            $categoryEnt = Category::create([
                'name' => 'Entertainment',
                'slug' => 'entertainment', // Kolom ini juga wajib ada!
            ]);

        // 3. Insert Sampel Events
        // Event 1: Jazz Night
        Event::updateOrCreate(
            ['title' => 'Jazz Night 2026'],
            [
                'category_id' => $catEnt->id,
                'description' => 'Malam musik jazz syahdu di pelataran Amikom.',
                'date'        => '2026-05-10 19:00:00',
                'location'    => 'Amikom Baru',
                'price'       => 50000,
                'stock'       => 100,
                'poster_path' => 'posters/event-1.png',
            ]
        );

        // Event 2: Hackaton
        Event::updateOrCreate(
            ['title' => 'Hackaton Amikom 2026'],
            [
                'category_id' => $catIT->id,
                'description' => 'Kompetisi coding 24 jam untuk mencari solusi digital.',
                'date'        => '2026-06-15 08:00:00',
                'location'    => 'Inkubator Amikom',
                'price'       => 75000,
                'stock'       => 50,
                'poster_path' => 'posters/event-2.png',
            ]
        );

        // Event 3: AI Summit
        Event::updateOrCreate(
            ['title' => 'AI & Future Tech Summit'],
            [
                'category_id' => $catIT->id,
                'description' => 'Seminar tren kecerdasan buatan masa depan.',
                'date'        => '2026-07-20 09:00:00',
                'location'    => 'Cinema Gedung 6',
                'price'       => 30000,
                'stock'       => 200,
                'poster_path' => 'posters/event-3.png',
            ]
        );

        // Event 4 (Olahraga)
        Event::updateOrCreate(
            ['title' => 'Amikom Futsal Cup'],
            [
                'category_id' => $catSport->id,
                'description' => 'Turnamen futsal antar program studi.',
                'date'        => '2026-08-05 15:00:00',
                'location'    => 'Lapangan Futsal Amikom',
                'price'       => 100000,
                'stock'       => 16,
                'poster_path' => 'posters/event-4.png',
            ]
        );

        // Event 5 (Entertainment)
        Event::updateOrCreate(
            ['title' => 'Stand Up Comedy Kampus'],
            [
                'category_id' => $catEnt->id,
                'description' => 'Tertawa bersama komika-komika berbakat kampus.',
                'date'        => '2026-09-12 19:30:00',
                'location'    => 'Basement Gedung 4',
                'price'       => 25000,
                'stock'       => 150,
                'poster_path' => 'posters/event-5.png',
            ]
        );

        // Event 6 (Olahraga)
        Event::updateOrCreate(
            ['title' => 'E-Sport Mobile Legends'],
            [
                'category_id' => $catSport->id,
                'description' => 'Turnamen bergengsi MLBB Amikom Championship.',
                'date'        => '2026-10-10 10:00:00',
                'location'    => 'Aula BSC',
                'price'       => 50000,
                'stock'       => 32,
                'poster_path' => 'posters/event-6.png',
            ]
        );
    }
}
