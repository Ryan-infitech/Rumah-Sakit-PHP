<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Antrian;
use App\Models\Jadwalpoliklinik;
use App\Models\Datapasien;
use Barryvdh\DomPDF\Facade\PDF;
use Illuminate\Support\Facades\Auth;

class AntrianController extends Controller
{
    /**
     * Display a listing of the appointments/queues.
     * This is for admin/staff view with filtering capabilities.
     */
    public function index(Request $request)
    {
        // Query untuk mengambil data jadwal poliklinik
        $jadwalpoliklinik = Jadwalpoliklinik::orderBy('created_at', 'desc')->get();
        $filter = "";
        
        // Ambil parameter dari permintaan GET
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $search = $request->input('search');
        
        // Inisialisasi query untuk semua data antrian
        $query = Antrian::query();
        
        // Filter berdasarkan rentang tanggal jika parameter ada
        if ($start_date && $end_date) {
            $query->whereBetween('tanggal_berobat', [$start_date, $end_date]);
            $filter = ["start_date" => $start_date, 'end_date' => $end_date];
        }
        
        // Filter berdasarkan parameter pencarian jika ada
        if ($search) {
            $query->where(function($query) use ($search) {
                $query->where('kode_jadwalpoliklinik', 'like', "%$search%")
                    ->orWhere('kode_antrian', 'like', "%$search%")
                    ->orWhere('no_antrian', 'like', "%$search%")
                    ->orWhere('nama_pasien', 'like', "%$search%")
                    ->orWhere('no_telp', 'like', "%$search%")
                    ->orWhere('nama_dokter', 'like', "%$search%")
                    ->orWhere('poliklinik', 'like', "%$search%")
                    ->orWhere('penjamin', 'like', "%$search%")
                    ->orWhere('no_bpjs', 'like', "%$search%");
            });
        }
        
        // Ambil data antrian sesuai dengan query yang dibuat
        $antrian = $query->orderBy('tanggal_berobat', 'asc')->get();
        
        return view('antrian.index', compact('antrian', 'filter'));
    }

    /**
     * Display a listing of the patient's own appointments/queues.
     * This is for patient view showing only their appointments.
     */
    public function index2(Request $request)
    {
        $userId = Auth::id();
        $datapasien = Datapasien::where('user_id', $userId)->first();
        
        if ($datapasien) {
            $antrian = Antrian::with('jadwalpoliklinik')->where('id_pasien', $datapasien->id)->get();
            
            // Make sure each record has a dokter_id, even if it's missing
            foreach ($antrian as $item) {
                if (empty($item->dokter_id) && $item->jadwalpoliklinik) {
                    $item->dokter_id = $item->jadwalpoliklinik->dokter_id;
                    $item->save();
                }
            }
        } else {
            $antrian = [];
        }
        
        return view('antrian.index2', compact('antrian'));
    }

    /**
     * Generate a PDF for a specific appointment/queue
     * 
     * @param int $id The appointment ID
     * @return \Illuminate\Http\Response
     */
    public function generateAntrian($id)
    {
        $antrian = Antrian::where('id', $id)->first();
        $pdf = PDF::loadView('pdf/antrian', ['antrian' => $antrian]);
        return $pdf->stream('Antrian.pdf');
    }

    /**
     * Generate a PDF for all patient appointments/history
     * 
     * @return \Illuminate\Http\Response
     */
    public function generatePDF()
    {
        $userId = Auth::id();
        $datapasien = Datapasien::where('user_id', $userId)->first();
        
        if ($datapasien) {
            $antrian = Antrian::where('id_pasien', $datapasien->id)->get();
            $pdf = PDF::loadView('pdf/riwayat', ['antrian' => $antrian, 'datapasien' => $datapasien]);
            return $pdf->stream('Riwayat_Pendaftaran.pdf');
        }
        
        return back()->with('error', 'Tidak ada data pasien yang ditemukan');
    }
}