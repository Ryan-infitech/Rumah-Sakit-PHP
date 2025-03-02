<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PetugasController extends Controller
{
    public function index()
    {
        // Add logic to fetch:
        // - Today's queue count
        // - Served patients count
        // - Waiting patients count
        // - Total patients
        return view('dashboardpetugas');
    }

    public function daftarPasienBaru()
    {
        return view('petugas.daftar-pasien');
    }

    public function antrianHariIni()
    {
        $antrian = [
            // Sample data structure
            // Will be replaced with actual database queries
            [
                'no_antrian' => '001',
                'nama_pasien' => 'John Doe',
                'poli' => 'Umum',
                'dokter' => 'Dr. Ahmad',
                'status' => 'Menunggu'
            ]
        ];

        return view('petugas.antrian', compact('antrian'));
    }

    public function rekamMedis($id = null)
    {
        if ($id) {
            // Show specific medical record
            return view('petugas.rekam-medis-detail');
        }
        // Show list of medical records
        return view('petugas.rekam-medis-list');
    }

    public function prosesAntrian($id)
    {
        // Process queue logic here
        return redirect()->back()->with('success', 'Antrian berhasil diproses');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
