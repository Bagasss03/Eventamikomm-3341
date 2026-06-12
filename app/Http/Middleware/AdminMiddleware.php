<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika user belum login, arahkan ke rute login admin
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Jika user sudah login, tapi status rolenya BUKAN admin
        if (Auth::user()->role !== 'admin') {
            Auth::logout();
            return redirect()->route('admin.login')->with('error', 'Akses ditolak! Anda bukan Admin.');
        }

        return $next($request);
    }
}