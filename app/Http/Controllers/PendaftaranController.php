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
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $now = Carbon::now()->setTimezone('Asia/Jakarta');
        
        // Optimize query by selecting only needed fields and eager loading relationships
        $jadwalHariIni = JadwalPoliklinik::select('id', 'dokter_id', 'tanggal_praktek', 'jam_mulai', 'jam_selesai', 'jumlah')
            ->with([
                'dokter:id,nama_dokter,poliklinik_id,foto_dokter', 
                'dokter.poliklinik:id,nama_poliklinik'
            ])
            ->whereDate('tanggal_praktek', $today)
            ->where('jam_selesai', '>', $now->format('H:i'))
            ->where('jumlah', '>', 0)
            ->get();
            
        $tomorrow = Carbon::tomorrow();
        $jadwalBesok = JadwalPoliklinik::select('id', 'dokter_id', 'tanggal_praktek', 'jam_mulai', 'jam_selesai', 'jumlah')
            ->with([
                'dokter:id,nama_dokter,poliklinik_id,foto_dokter', 
                'dokter.poliklinik:id,nama_poliklinik'
            ])
            ->whereDate('tanggal_praktek', $tomorrow)
            ->where('jumlah', '>', 0)
            ->get();
            
        // Add query for future schedules (beyond tomorrow) - Limited to 30 days from now
        $futureDate = Carbon::tomorrow()->addDay();
        $maxDate = Carbon::today()->addDays(30);
        $jadwalMendatang = JadwalPoliklinik::select('id', 'dokter_id', 'tanggal_praktek', 'jam_mulai', 'jam_selesai', 'jumlah')
            ->with([
                'dokter:id,nama_dokter,poliklinik_id,foto_dokter', 
                'dokter.poliklinik:id,nama_poliklinik'
            ])
            ->whereDate('tanggal_praktek', '>', $tomorrow)
            ->whereDate('tanggal_praktek', '<=', $maxDate)
            ->where('jumlah', '>', 0)
            ->orderBy('tanggal_praktek')
            ->get();
        
        // Get doctor ratings more efficiently using a single database query
        $dokterIds = $jadwalHariIni->pluck('dokter_id')
            ->concat($jadwalBesok->pluck('dokter_id'))
            ->concat($jadwalMendatang->pluck('dokter_id'))
            ->unique()
            ->values()
            ->toArray();
            
        $dokterRatings = [];
        
        if (!empty($dokterIds)) {
            $ratings = DB::table('ratings')
                ->select('dokter_id', DB::raw('AVG(rating) as avg_rating'))
                ->whereIn('dokter_id', $dokterIds)
                ->groupBy('dokter_id')
                ->get();
                
            foreach ($ratings as $rating) {
                $dokterRatings[$rating->dokter_id] = round($rating->avg_rating, 1);
            }
        }
                        
        return view('pendaftaran.index', compact('today', 'tomorrow', 'jadwalHariIni', 'jadwalBesok', 'jadwalMendatang', 'dokterRatings'));
    }
    
    public function adminRegistration()
    {
        $today = Carbon::today();
        $now = Carbon::now()->setTimezone('Asia/Jakarta');
        
        // Optimize queries with better eager loading and select only needed fields
        $jadwalHariIni = JadwalPoliklinik::select('id', 'dokter_id', 'tanggal_praktek', 'jam_mulai', 'jam_selesai', 'jumlah', 'poliklinik_id')
            ->with([
                'dokter:id,nama_dokter,poliklinik_id,foto_dokter',
                'dokter.poliklinik:id,nama_poliklinik'
            ])
            ->whereDate('tanggal_praktek', $today)
            ->where('jam_selesai', '>', $now->format('H:i'))
            ->where('jumlah', '>', 0)
            ->get();
                        
        // Limit future dates to reduce memory usage
        $jadwalMendatang = JadwalPoliklinik::select('id', 'dokter_id', 'tanggal_praktek', 'jam_mulai', 'jam_selesai', 'jumlah', 'poliklinik_id')
            ->with([
                'dokter:id,nama_dokter,poliklinik_id,foto_dokter',
                'dokter.poliklinik:id,nama_poliklinik'
            ])
            ->whereDate('tanggal_praktek', '>', $today)
            ->where('jumlah', '>', 0)
            ->orderBy('tanggal_praktek')
            ->limit(30) // Limit future dates to reduce memory usage
            ->get();
        
        // Efficiently get doctor ratings
        $dokterIds = $jadwalHariIni->pluck('dokter_id')
            ->concat($jadwalMendatang->pluck('dokter_id'))
            ->unique()
            ->values()
            ->toArray();
            
        $dokterRatings = [];
        
        if (!empty($dokterIds)) {
            $ratings = DB::table('ratings')
                ->select('dokter_id', DB::raw('AVG(rating) as avg_rating'))
                ->whereIn('dokter_id', $dokterIds)
                ->groupBy('dokter_id')
                ->get();
                
            foreach ($ratings as $rating) {
                $dokterRatings[$rating->dokter_id] = round($rating->avg_rating, 1);
            }
        }
                        
        return view('pendaftaran.admin_registration', compact('today', 'jadwalHariIni', 'jadwalMendatang', 'dokterRatings'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $path = null; // Initialize $path variable
        $datapasien = null; // Initialize $datapasien for later use
        $id_pasien = null; // Initialize id_pasien
        
        if ($user->roles == 'admin' || $user->roles == 'petugas') {
            // Validate admin/petugas input
            $request->validate([
                'nama_pasien' => 'required|string|max:255',
                'penjamin' => 'required',
                'no_telp' => 'required|string|max:15',
            ]);
            
            $nama_pasien = $request->nama_pasien;
            $no_telp = $request->no_telp;
            
            // Check if patient already exists based on name and phone number
            $datapasien = Datapasien::where('nama_pasien', $nama_pasien)
                                ->where('no_telp', $no_telp)
                                ->first();
            
            if ($datapasien) {
                // If patient record exists, use their ID
                $id_pasien = $datapasien->id;
            } else {
                // Create a new patient record
                $datapasien = new Datapasien();
                $datapasien->nama_pasien = $nama_pasien;
                $datapasien->no_telp = $no_telp;
                $datapasien->email = $no_telp . '@placeholder.com'; // Placeholder email
                $datapasien->user_id = $user->id; // Use the admin/staff ID temporarily
                $datapasien->save();
                
                $id_pasien = $datapasien->id;
            }
            
            // If admin/petugas uploads a file
            if ($request->hasFile('scan_surat_rujukan')) {
                $file = $request->file('scan_surat_rujukan');
                $path = $file->store('public/surat_rujukan');
            }
        } else {
            // Patient registration logic
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
        
        // Get jadwalpoliklinik data first to check availability
        $jadwalpoliklinik = JadwalPoliklinik::with(['dokter.poliklinik' => function($query) {
            $query->select('id', 'nama_poliklinik');
        }])->select('id', 'dokter_id', 'tanggal_praktek', 'kode', 'poliklinik_id', 'jumlah')
          ->findOrFail($request->jadwalpoliklinik_id);
          
        if ($jadwalpoliklinik->jumlah <= 0) {
            return back()->withErrors(['msg' => 'Kuota pendaftaran habis!']);
        }
        
        // Decrement quota
        $jadwalpoliklinik->decrement('jumlah');
        
        // Create pendaftaran record
        $pendaftaran = new Pendaftaran();
        $pendaftaran->jadwalpoliklinik_id = $request->jadwalpoliklinik_id;
        $pendaftaran->penjamin = $request->penjamin;
        $pendaftaran->nama_pasien = $nama_pasien;
        $pendaftaran->id_pasien = $id_pasien;
        $pendaftaran->scan_surat_rujukan = $path;
        $pendaftaran->save();
        
        // Generate queue number
        $no_antrian = Antrian::where('jadwalpoliklinik_id', $jadwalpoliklinik->id)->count() + 1;
        $kode_antrian = $jadwalpoliklinik->poliklinik_id . $jadwalpoliklinik->dokter_id . $jadwalpoliklinik->id . $pendaftaran->id . $user->id . $no_antrian;
        
        // Get the kode value from jadwalpoliklinik table as kode_jadwalpoliklinik
        $kode_jadwal = $jadwalpoliklinik->kode ?? 'JP' . $jadwalpoliklinik->id;
        
        // Create antrian data with proper BPJS/insurance info
        $antrianData = [
            'kode_antrian' => $kode_antrian,
            'kode_jadwalpoliklinik' => $kode_jadwal,
            'no_antrian' => $no_antrian,
            'nama_pasien' => $nama_pasien,
            'no_telp' => $no_telp,
            'jadwalpoliklinik_id' => $jadwalpoliklinik->id,
            'id_pasien' => $id_pasien,
            'nama_dokter' => $jadwalpoliklinik->dokter->nama_dokter,
            'dokter_id' => $jadwalpoliklinik->dokter_id,
            'poliklinik' => $jadwalpoliklinik->dokter->poliklinik->nama_poliklinik,
            'penjamin' => $request->penjamin,
            'tanggal_berobat' => $jadwalpoliklinik->tanggal_praktek,
            'tanggal_reservasi' => now(),
            'user_id' => Auth::id(),
            'scan_surat_rujukan' => $path,
        ];
        
        // Add BPJS/insurance data if available from patient record
        if ($datapasien) {
            if ($request->penjamin == 'BPJS') {
                $antrianData['no_bpjs'] = $datapasien->no_kbpjs;
                $antrianData['scan_kbpjs'] = $datapasien->scan_kbpjs;
            } elseif ($request->penjamin == 'Asuransi') {
                $antrianData['scan_kasuransi'] = $datapasien->scan_kasuransi;
            }
        }
        
        // Create the antrian record
        $antrian = Antrian::create($antrianData);
        
        // Determine redirect route based on user role
        $redirectRoute = ($user->roles == 'admin' || $user->roles == 'petugas') ? 
            'admin.registration' : 'Pendaftaran.index';
            
        return redirect()->route($redirectRoute)->with('success', 'Pendaftaran berhasil!');
    }
}
