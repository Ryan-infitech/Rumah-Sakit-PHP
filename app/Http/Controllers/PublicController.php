<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function home()
    {
        return view('public.home', [
            'title' => 'Beranda'
        ]);
    }

    public function services()
    {
        return view('public.services', [
            'title' => 'Layanan'
        ]);
    }

    public function doctors()
    {
        return view('public.doctors', [
            'title' => 'Dokter'
        ]);
    }

    public function contact()
    {
        return view('public.contact', [
            'title' => 'Kontak'
        ]);
    }
}