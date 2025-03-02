<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index()
    {
        // Sample data for dashboard
        $data = [
            'nextAppointment' => '25 Juli 2023',
            'totalVisits' => 5,
            'upcomingAppointments' => [
                [
                    'tanggal' => '2023-07-25',
                    'dokter' => 'Dr. Ahmad',
                    'poli' => 'Umum',
                    'status' => 'Terjadwal'
                ],
                [
                    'tanggal' => '2023-08-01',
                    'dokter' => 'Dr. Sarah',
                    'poli' => 'Gigi',
                    'status' => 'Menunggu'
                ]
            ]
        ];

        return view('dashboardpasien', $data);
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
