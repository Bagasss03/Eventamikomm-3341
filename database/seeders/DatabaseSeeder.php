<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
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
            ['title' => 'Jazz Night 2025'],
            [
                'category_id' => $categoryEnt->id,
                'description' => 'Nikmati malam yang indah dengan alunan musik jazz yang merdu.',
                'date'        => '2026-05-10 19:00:00',
                'location'    => 'Amikom Baru',
                'price'       => 50000,
                'stock'       => 100,
                'poster_path' => 'posters/event-1.png',
            ]
        );

        // Event 2: Hackaton
        Event::updateOrCreate(
            ['title' => 'Hackaton - Unleash Your Inner Developer'],
            [
                'category_id' => $categoryIT->id,
                'description' => 'Ayo asah skill coding kamu dan ciptakan solusi inovatif untuk tantangan masa depan!',
                'date'        => '2026-05-05 10:00:00',
                'location'    => 'Inkubator Amikom',
                'price'       => 50000,
                'stock'       => 100,
                'poster_path' => 'posters/event-2.png',
            ]
        );

        // Event 3: AI Summit
        Event::updateOrCreate(
            ['title' => 'AI & FUTURE TECH SUMMIT 2026'],
            [
                'category_id' => $categoryIT->id,
                'description' => 'Jelajahi tren terkini dalam kecerdasan buatan dan teknologi masa depan bersama para ahli di bidangnya.',
                'date'        => '2026-05-01 13:00:00',
                'location'    => 'Cinema Unit 6',
                'price'       => 50000,
                'stock'       => 100,
                'poster_path' => 'posters/event-3.png',
            ]
        );
    }
}