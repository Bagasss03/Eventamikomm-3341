<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman ringkasan data (Dashboard) panel administrasi
     */
    public function index()
    {
        // 1. Menjumlahkan semua nominal total_price dari kolom Transaksi Lunas
        $totalRevenue = Transaction::whereIn('status', ['settlement', 'success', 'Settlement', 'Success', 'SETTLEMENT', 'SUCCESS'])->sum('total_price');
        
        // 2. Menghitung berapa orang tamu yang tiketnya sudah Lunas
        $ticketsSold = Transaction::whereIn('status', ['settlement', 'success', 'Settlement', 'Success', 'SETTLEMENT', 'SUCCESS'])->count();
        
        // 3. Menghitung jumlah acara mendatang yang aktif diselenggarakan
        $activeEvents = Event::where('date', '>=', now())->count();
        
        // 4. Menghitung transaksi ngadat (Status belum dibayar pelanggan / Expired)
        $pendingOrders = Transaction::whereIn('status', ['pending', 'Pending', 'PENDING'])->count();
        
        // 5. Menyertakan 5 daftar riwayat pesanan (History) paling mutakhir di panel
        $recentTransactions = Transaction::with('event')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalRevenue', 
            'ticketsSold', 
            'activeEvents', 
            'pendingOrders', 
            'recentTransactions'
        ));
    }
}