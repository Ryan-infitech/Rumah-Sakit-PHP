<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect('login');
        }
        
        // Get authenticated user
        $user = Auth::user();
        
        // Check if user has one of the specified roles
        if (in_array($user->roles, $roles)) {
            return $next($request);
        }
        
        // Redirect based on user's role if they don't have access
        switch ($user->roles) {
            case 'admin':
                return redirect()->route('dashboard-admin')
                    ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            case 'petugas':
                return redirect()->route('dashboard-petugas')
                    ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            case 'pasien':
                return redirect()->route('dashboard-pasien')
                    ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            default:
                return redirect('/login');
        }
    }
}