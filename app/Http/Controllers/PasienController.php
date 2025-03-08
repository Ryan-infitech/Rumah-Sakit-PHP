<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Datapasien;

class PasienController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        
        // Get patient data for the current user if it exists
        $dataPasien = null;
        if ($user) {
            $dataPasien = Datapasien::where('user_id', $user->id)->first();
        }

        return view('dashboardpasien', compact('dataPasien'));
    }

    public function jadwalPeriksa()
    {
        $jadwal = [
            'poliklinik' => ['Umum', 'Gigi', 'Anak', 'THT'],
            'dokter' => [
                'Dr. Ahmad',
                'Dr. Sarah',
                'Dr. John'
            ]
        ];

        return view('pasien.jadwal-periksa', $jadwal);
    }

    public function riwayatPeriksa()
    {
        $riwayat = [
            [
                'tanggal' => '2023-06-20',
                'dokter' => 'Dr. Ahmad',
                'poli' => 'Umum',
                'diagnosis' => 'Flu dan Batuk',
                'resep' => 'Paracetamol, Amoxilin'
            ],
            [
                'tanggal' => '2023-05-15',
                'dokter' => 'Dr. Sarah',
                'poli' => 'Gigi',
                'diagnosis' => 'Gigi Berlubang',
                'resep' => 'Antibiotik'
            ]
        ];

        return view('pasien.riwayat-periksa', compact('riwayat'));
    }

    public function profil()
    {
        $profil = [
            'nama' => 'John Doe',
            'no_rm' => 'RM-2023-001',
            'tanggal_lahir' => '1990-01-01',
            'alamat' => 'Jl. Contoh No. 123',
            'no_telp' => '08123456789'
        ];

        return view('pasien.profil', compact('profil'));
    }
}
