<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Partner;
use App\Models\Event;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil data kategori, partner, dan event dari database
        $categories = Category::all();
        $partners = Partner::all();
        $events = Event::with('category')->latest()->take(6)->get();

        // Kirim data ke view 'welcome'
        return view('welcome', compact('categories', 'partners', 'events'));
    }
}