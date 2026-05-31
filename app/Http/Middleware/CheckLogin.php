<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLogin
{
    /**
     * Handle an incoming request.
     * Cek apakah user sudah login via session Mahasiswa custom.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session('mahasiswa_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
