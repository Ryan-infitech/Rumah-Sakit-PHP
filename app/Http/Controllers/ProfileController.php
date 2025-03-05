<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display the user's profile
     */
    public function index()
    {
        $user = Auth::user(); // Mengambil data pengguna yang sedang login
        return view('user.profile', compact('user'));
    }
}