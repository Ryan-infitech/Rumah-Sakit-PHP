<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Dokter;
use App\Models\Datapasien;
use App\Models\Antrian;
use App\Models\Poliklinik;
use App\Models\RiwayatKunjungan;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RiwayatPasienExport;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            // Check if the authenticated user has admin role
            if (Auth::check() && Auth::user()->roles !== 'admin') {
                return redirect('/login')->with('error', 'Unauthorized access');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get counts for dashboard
        $counts = [
            'users' => User::count(),
            'doctors' => Dokter::count(),
            'patients' => Datapasien::count(),
            'clinics' => Poliklinik::count(),
            'todayAppointments' => Antrian::whereDate('tanggal_berobat', Carbon::today())->count()
        ];
        
        return view('dashboardadmin', compact('user', 'counts'));
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

    public function riwayatAntrian(Request $request)
    {
        // Get date from request or use today's date
        $date = $request->date ? Carbon::parse($request->date)->format('Y-m-d') : Carbon::today()->format('Y-m-d');
        
        // Get patients for the selected date with any status
        $riwayat = Antrian::whereDate('tanggal_berobat', $date)
            ->orderBy('no_antrian', 'asc')
            ->get()
            ->map(function($item) {
                return [
                    'id' => $item->id,
                    'no_antrian' => $item->no_antrian,
                    'nama_pasien' => $item->nama_pasien,
                    'poli' => $item->poliklinik,
                    'dokter' => $item->nama_dokter,
                    'waktu_mulai' => $item->waktu_mulai ? Carbon::parse($item->waktu_mulai)->format('H:i:s') : '-',
                    'waktu_selesai' => $item->waktu_selesai ? Carbon::parse($item->waktu_selesai)->format('H:i:s') : '-',
                    'tanggal' => $item->tanggal_berobat->format('d/m/Y'),
                    'status' => ucfirst($item->status)
                ];
            });

        // Group by status for summary
        $summary = [
            'total' => $riwayat->count(),
            'menunggu' => $riwayat->where('status', 'Menunggu')->count(),
            'diproses' => $riwayat->where('status', 'Diproses')->count(),
            'dilayani' => $riwayat->where('status', 'Dilayani')->count(),
        ];

        return view('admin.riwayat-antrian', compact('riwayat', 'date', 'summary'));
    }

    public function riwayatPasien(Request $request)
    {
        // Get search parameters
        $search = $request->input('search');
        $start_date = $request->input('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : null;
        $end_date = $request->input('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : null;
        $poliklinik = $request->input('poliklinik');
        $dokter = $request->input('dokter');

        // Base query for visit history
        $query = RiwayatKunjungan::query()
            ->with(['pasien', 'dokter', 'poliklinik'])
            ->orderBy('tanggal_kunjungan', 'desc')
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_pasien', 'like', "%{$search}%")
                    ->orWhere('kode_kunjungan', 'like', "%{$search}%")
                    ->orWhere('nama_dokter', 'like', "%{$search}%")
                    ->orWhere('poliklinik', 'like', "%{$search}%");
            });
        }

        if ($start_date && $end_date) {
            $query->whereBetween('tanggal_kunjungan', [$start_date, $end_date]);
        } elseif ($start_date) {
            $query->where('tanggal_kunjungan', '>=', $start_date);
        } elseif ($end_date) {
            $query->where('tanggal_kunjungan', '<=', $end_date);
        }

        if ($poliklinik) {
            $query->where('poliklinik_id', $poliklinik);
        }

        if ($dokter) {
            $query->where('dokter_id', $dokter);
        }

        // Get paginated results
        $riwayatPasien = $query->paginate(15)->appends($request->query());

        // Get data for filters
        $polikliniks = Poliklinik::all();
        $dokters = Dokter::all();

        return view('admin.riwayat-pasien', compact('riwayatPasien', 'polikliniks', 'dokters', 'search', 'start_date', 'end_date'));
    }
    
    public function detailRiwayatPasien($id)
    {
        $riwayat = RiwayatKunjungan::with(['pasien', 'dokter', 'poliklinik', 'antrian'])->findOrFail($id);
        
        return view('admin.riwayat-pasien-detail', compact('riwayat'));
    }
    
    public function exportRiwayatPasien(Request $request)
    {
        // Get search parameters from request
        $search = $request->input('search');
        $start_date = $request->input('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : null;
        $end_date = $request->input('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : null;
        $poliklinik = $request->input('poliklinik');
        $dokter = $request->input('dokter');
        
        // Base query
        $query = RiwayatKunjungan::query()
            ->with(['pasien', 'dokter', 'poliklinik'])
            ->orderBy('tanggal_kunjungan', 'desc')
            ->orderBy('created_at', 'desc');
        
        // Apply the same filters as the view
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama_pasien', 'like', "%{$search}%")
                    ->orWhere('kode_kunjungan', 'like', "%{$search}%")
                    ->orWhere('nama_dokter', 'like', "%{$search}%")
                    ->orWhere('poliklinik', 'like', "%{$search}%");
            });
        }

        if ($start_date && $end_date) {
            $query->whereBetween('tanggal_kunjungan', [$start_date, $end_date]);
        } elseif ($start_date) {
            $query->where('tanggal_kunjungan', '>=', $start_date);
        } elseif ($end_date) {
            $query->where('tanggal_kunjungan', '<=', $end_date);
        }

        if ($poliklinik) {
            $query->where('poliklinik_id', $poliklinik);
        }

        if ($dokter) {
            $query->where('dokter_id', $dokter);
        }
        
        // Get all results for export
        $riwayatPasien = $query->get();
        
        // Generate filename with current date
        $filename = 'riwayat_kunjungan_pasien_' . now()->format('Ymd_His') . '.xlsx';
        
        return Excel::download(new RiwayatPasienExport($riwayatPasien), $filename);
    }
}
