<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as EventAdminController;
use App\Http\Controllers\Admin\CategoryController as CategoryAdminController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\CheckoutController;


// ==========================================
// ROUTE PUBLIK
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/event/{id}', [\App\Http\Controllers\EventController::class, 'show'])->name('events.show');
Route::get('/my-ticket/{order_id}', [\App\Http\Controllers\TicketController::class, 'show'])->name('ticket');

// Checkout (publik, tanpa login)
Route::get('/checkout/{event}', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout/{event}', [CheckoutController::class, 'store'])->name('checkout.store');

Route::get('/tentang', function() {
    return '<h1>Ini adalah halaman tentang aplikasi Event Hub</h1>';
})->name('tentang');

Route::get('/kontak', function() {
    return view('kontak');
})->name('kontak');

Route::get('/profil', function(){
    return view('profil');
})->name('profil');

Route::get('/katalog', function(){
    return view('katalog');
})->name('katalog');

Route::get('/bantuan', function(){
    return view('bantuan');
})->name('bantuan');

// Redirect /login ke /admin/login
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

// ==========================================
// ROUTE ADMIN (GROUP BERAWALAN /ADMIN)
// ==========================================
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Rute Login (Guest)
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('login.post');
    });

    // Rute Logout (Auth)
    Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

    // Rute Administrasi Utama (Admin Middleware)
    Route::middleware('admin')->group(function () {
        
        // Dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // CRUD Resources
        Route::resource('events', EventAdminController::class);
        Route::resource('categories', CategoryAdminController::class);
        Route::resource('partners', PartnerController::class);
        
        // Laporan Transaksi
        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');


    });
});