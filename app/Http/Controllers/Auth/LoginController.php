<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function username()
    {
        return 'username';
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return $this->authenticated($request, $user);
        }

        return redirect()->back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->roles == 'admin') {
            return redirect('/dashboard-admin');
        } elseif ($user->roles == 'petugas') {
            return redirect('/dashboard-petugas');
        } elseif ($user->roles == 'pasien') {
            return redirect('/dashboard-pasien');
        }
    }
}
