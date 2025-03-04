<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();
                switch ($user->roles) {
                    case 'admin':
                        return redirect()->route('dashboard-admin');
                    case 'petugas':
                        return redirect()->route('dashboard-petugas');
                    case 'pasien':
                        return redirect()->route('dashboard-pasien');
                    default:
                        return redirect('/login');
                }
            }
        }

        return $next($request);
    }
}