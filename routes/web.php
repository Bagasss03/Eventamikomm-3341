<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as EventAdminController;
use App\Http\Controllers\Admin\CategoryController as CategoryAdminController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\TransactionController;

// Temporary route to migrate and seed DB on the cloud
Route::get('/setup-db', function() {
    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
    return 'Database migrated and seeded successfully!';
});

// ==========================================
// ROUTE PUBLIK
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/event/{id}', [\App\Http\Controllers\EventController::class, 'show'])->name('events.show');
Route::get('/checkout', [\App\Http\Controllers\EventController::class, 'checkout'])->name('checkout');
Route::get('/my-ticket', [\App\Http\Controllers\TicketController::class, 'show'])->name('ticket');

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