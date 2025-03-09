<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // Changed from 'dashboardadmin' to make the title of the logged-in user visible
        $user = Auth::user();
        return view('dashboardadmin', compact('user'));
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
                    'waktu_selesai' => $item->updated_at->format('H:i:s'),
                    'tanggal' => $item->tanggal_berobat->format('d/m/Y'),
                    'status' => $item->status
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
}
