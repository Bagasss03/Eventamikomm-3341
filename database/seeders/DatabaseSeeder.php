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
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@amikom.ac.id'],
            [
                'name'     => 'Admin Amikom',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );
            $categoryIT = Category::create([
                'name' => 'Seminar IT',
                'slug' => 'seminar-it', 
            ]);

            $categoryEnt = Category::create([
                'name' => 'Entertainment',
                'slug' => 'entertainment', 
            ]);
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
