<?php

namespace App\Http\Controllers;

use App\Models\dokter;
use App\Models\jadwalpoliklinik;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JadwalpoliklinikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Query untuk mengambil data jadwal poliklinik
        $jadwalpoliklinik = JadwalPoliklinik::orderBy('created_at', 'desc')->get();
    
        // Ambil parameter dari permintaan GET
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
    
        // Inisialisasi query untuk semua data jadwal poliklinik
        $query = JadwalPoliklinik::query();

        // Filter berdasarkan rentang tanggal jika parameter ada
        if ($start_date && $end_date) {
            $query->whereBetween('tanggal_praktek', [$start_date, $end_date]);
        }
    
        // Ambil data jadwal poliklinik sesuai dengan query yang dibuat
        $jadwalpoliklinik = $query->orderBy('tanggal_praktek', 'asc')->get();
    
        return view('jadwalpoliklinik.index', compact('jadwalpoliklinik'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dokter = Dokter::all();
        return view('jadwalpoliklinik.create', compact('dokter'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add (Request $request)
    {
        $request->validate([
            'dokter_id' => 'required|exists:dokter,id',
            'tanggal_praktek' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'jumlah' => 'required|integer|min:1',
        ]);
    
        $jadwalpoliklinik = new JadwalPoliklinik();
        $jadwalpoliklinik->kode = 'JP-' . Str::random(8);
        $jadwalpoliklinik->dokter_id = $request->dokter_id;
        $jadwalpoliklinik->poliklinik_id = Dokter::find($request->dokter_id)->poliklinik_id;
        $jadwalpoliklinik->tanggal_praktek = $request->tanggal_praktek;
        $jadwalpoliklinik->jam_mulai = $request->jam_mulai;
        $jadwalpoliklinik->jam_selesai = $request->jam_selesai;
        $jadwalpoliklinik->jumlah = $request->jumlah;
        $jadwalpoliklinik->save();
    
        return redirect()->route('jadwalpoliklinik.index')->with('success', 'Berhasil ditambahkan');
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
        $jadwalpoliklinik = Jadwalpoliklinik::findOrFail($id);
        $dokter = Dokter::all();
        return view('jadwalpoliklinik.update', compact('jadwalpoliklinik', 'dokter'));
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
        $request->validate([
            'dokter_id' => 'required|exists:dokter,id',
            'tanggal_praktek' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i:s',
            'jam_selesai' => 'required|date_format:H:i:s|after:jam_mulai',
            'jumlah' => 'required|integer|min:1',
        ]);
    
        $jadwalpoliklinik = JadwalPoliklinik::findOrFail($id);
        $jadwalpoliklinik->dokter_id = $request->dokter_id;
        $jadwalpoliklinik->poliklinik_id = Dokter::find($request->dokter_id)->poliklinik_id;
        $jadwalpoliklinik->tanggal_praktek = $request->tanggal_praktek;
        $jadwalpoliklinik->jam_mulai = $request->jam_mulai;
        $jadwalpoliklinik->jam_selesai = $request->jam_selesai;
        $jadwalpoliklinik->jumlah = $request->jumlah;
        $jadwalpoliklinik->save();
    
        return redirect()->route('jadwalpoliklinik.index')->with('success', 'Data berhasil diperbarui');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jadwalpoliklinik = JadwalPoliklinik::findOrFail($id);
        $jadwalpoliklinik->delete();

        return redirect()->route('jadwalpoliklinik.index')->with('success', 'Data berhasil dihapus');
    }
}
