<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            'username' => 'Maaf, email/kata sandi yang anda masukan salah!',
        ]);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validate the request
        $request->validate([
            'nama_user' => 'required|string|max:255',
            'username' => 'required|string|email|max:255|unique:user',
            'password' => 'required|string|min:8|confirmed',
            'no_telepon' => 'required|string|max:15',
            'foto_user' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('foto_user')) {
            $fileName = time() . '.' . $request->foto_user->extension();
            $request->foto_user->move(public_path('uploads'), $fileName);
            $fotoPath = 'uploads/' . $fileName;
        } else {
            $fotoPath = 'uploads/default.jpg';
        }

        // Create user
        $user = User::create([
            'nama_user' => $request->nama_user,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'no_telepon' => $request->no_telepon,
            'foto_user' => $fotoPath,
            'roles' => 'pasien', // Set default role to 'pasien'
        ]);

        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
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

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')->with('success', 'Anda berhasil logout. Terima kasih!');
    }
}