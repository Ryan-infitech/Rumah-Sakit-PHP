<?php

namespace App\Http\Controllers;
use App\Models\JadwalPoliklinik;
use Carbon\Carbon;
use App\Models\Pendaftaran;
use App\Models\Antrian;
use App\Models\dokter;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;
use App\Models\Datapasien;

use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $now = Carbon::now()->setTimezone('Asia/Jakarta');
        
        // Fetch available schedules
        $jadwalHariIni = JadwalPoliklinik::with('dokter', 'dokter.poliklinik')
                        ->whereDate('tanggal_praktek', $today)
                        ->where('jam_selesai', '>', $now->format('H:i'))
                        ->get();
                        
        $tomorrow = Carbon::tomorrow();
        $jadwalBesok = JadwalPoliklinik::with('dokter', 'dokter.poliklinik')
                        ->whereDate('tanggal_praktek', $tomorrow)
                        ->get();
        
        // Get doctor ratings
        $dokterIds = $jadwalHariIni->pluck('dokter_id')->merge($jadwalBesok->pluck('dokter_id'))->unique();
        $dokterRatings = [];
        
        foreach ($dokterIds as $dokterId) {
            $avgRating = Rating::where('dokter_id', $dokterId)->avg('rating');
            if ($avgRating) {
                $dokterRatings[$dokterId] = round($avgRating, 1);
            }
        }
                        
        return view('pendaftaran.index', compact('today', 'tomorrow', 'jadwalHariIni', 'jadwalBesok', 'dokterRatings'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $path = null; // Initialize $path variable
        
        if ($user->roles == 'admin' || $user->roles == 'petugas') {
            $request->validate([
                'nama_pasien' => 'required|string|max:255',
                'penjamin' => 'required',
                'no_telp' => 'nullable|string|max:15',
            ]);
            
            $nama_pasien = $request->nama_pasien;
            $id_pasien = null;
            $no_telp = $request->no_telp;
            
            // If admin/petugas uploads a file
            if ($request->hasFile('scan_surat_rujukan')) {
                $file = $request->file('scan_surat_rujukan');
                $path = $file->store('public/surat_rujukan');
            }
        } else {
            $datapasien = Datapasien::where('user_id', $user->id)->first();
            
            if (!$datapasien) {
                return back()->withErrors(['msg' => 'Data pasien tidak ditemukan. Harap lengkapi data diri anda terlebih dahulu.']);
            }
            
            // Only require these core fields for existing patients
            $requiredFields = [
                'nama_pasien', 'no_telp'
            ];
            
            $missingFields = [];
            foreach ($requiredFields as $field) {
                if (empty($datapasien->$field)) {
                    $missingFields[] = $field;
                }
            }
            
            if (!empty($missingFields)) {
                return back()->withErrors(['msg' => 'Data pasien tidak lengkap. Harap lengkapi: ' . implode(', ', $missingFields)]);
            }
            
            $request->validate([
                'penjamin' => 'required',
                'scan_surat_rujukan' => 'required_if:penjamin,BPJS|file|mimes:jpeg,png,pdf',
            ]);
            
            if ($request->penjamin == 'BPJS' && empty($datapasien->no_kbpjs)) {
                return back()->withErrors(['msg' => 'Data BPJS belum lengkap, harap lengkapi nomor BPJS terlebih dahulu!']);
            }
            
            if ($request->penjamin == 'Asuransi' && empty($datapasien->scan_kasuransi)) {
                return back()->withErrors(['msg' => 'Data Asuransi belum lengkap, harap unggah kartu asuransi terlebih dahulu!']);
            }
            
            $nama_pasien = $datapasien->nama_pasien;
            $id_pasien = $datapasien->id;
            $no_telp = $datapasien->no_telp;
            
            // If patient uploads a file
            if ($request->hasFile('scan_surat_rujukan')) {
                $file = $request->file('scan_surat_rujukan');
                $path = $file->store('public/surat_rujukan');
            }
        }
        
        $pendaftaran = new Pendaftaran();
        $pendaftaran->jadwalpoliklinik_id = $request->jadwalpoliklinik_id;
        $pendaftaran->penjamin = $request->penjamin;
        $pendaftaran->nama_pasien = $nama_pasien;
        $pendaftaran->id_pasien = $id_pasien;
        $pendaftaran->scan_surat_rujukan = $path;
        
        $jadwalpoliklinik = JadwalPoliklinik::findOrFail($request->jadwalpoliklinik_id);
        if ($jadwalpoliklinik->jumlah <= 0) {
            return back()->withErrors(['msg' => 'Kuota pendaftaran habis!']);
        }
        $jadwalpoliklinik->decrement('jumlah');
        
        $pendaftaran->save();
        
        $no_antrian = Antrian::where('jadwalpoliklinik_id', $jadwalpoliklinik->id)->count() + 1;
        $kode_antrian = $jadwalpoliklinik->poliklinik_id . $jadwalpoliklinik->dokter_id . $jadwalpoliklinik->id . $pendaftaran->id . $user->id . $no_antrian;
        
        // Get the kode value from jadwalpoliklinik table as kode_jadwalpoliklinik
        $kode_jadwal = isset($jadwalpoliklinik->kode) ? $jadwalpoliklinik->kode : 'JP' . $jadwalpoliklinik->id;
        
        $antrian = Antrian::create([
            'kode_antrian' => $kode_antrian,
            'kode_jadwalpoliklinik' => $kode_jadwal, // Use the generated code
            'no_antrian' => $no_antrian,
            'nama_pasien' => $nama_pasien,
            'no_telp' => $no_telp,
            'jadwalpoliklinik_id' => $jadwalpoliklinik->id,
            'id_pasien' => $id_pasien,
            'nama_dokter' => $jadwalpoliklinik->dokter->nama_dokter,
            'dokter_id' => $jadwalpoliklinik->dokter_id, // Add dokter_id
            'poliklinik' => $jadwalpoliklinik->poliklinik->nama_poliklinik,
            'penjamin' => $request->penjamin,
            'no_bpjs' => ($request->penjamin == 'BPJS' && isset($datapasien)) ? $datapasien->no_kbpjs : null,
            'scan_kbpjs' => ($request->penjamin == 'BPJS' && isset($datapasien)) ? $datapasien->scan_kbpjs : null,
            'scan_kasuransi' => ($request->penjamin == 'Asuransi' && isset($datapasien)) ? $datapasien->scan_kasuransi : null,
            'tanggal_berobat' => $jadwalpoliklinik->tanggal_praktek,
            'tanggal_reservasi' => now(),
            'user_id' => Auth::id(),
            'scan_surat_rujukan' => $path,
        ]);
        
        return redirect()->route('Pendaftaran.index')->with('success', 'Pendaftaran berhasil!');
    }
}
