<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Memeriksa apakah pengguna sudah login dan memiliki role yang sesuai
        if (Auth::check() && Auth::user()->roles != $role) {
            return redirect('/'); // Arahkan pengguna yang tidak sesuai peran ke halaman utama
        }

        return $next($request);
    }
}
