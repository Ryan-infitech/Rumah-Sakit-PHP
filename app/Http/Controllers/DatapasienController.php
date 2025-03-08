<?php

namespace App\Http\Controllers;

use App\Models\Datapasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DatapasienController extends Controller
{
    /**
     * Constructor to apply middleware
     */
    public function __construct()
    {
        // Apply auth middleware to all methods
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of patients.
     */
    public function index(Request $request)
    {
        // Check if user has permission to view all patients
        if (!in_array(Auth::user()->roles, ['admin', 'petugas', 'kepala_rs'])) {
            return redirect()->route('dashboard-pasien')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        // Get search input
        $search = $request->input('search');
        
        // Base query to get data for patients with role 'pasien'
        $query = Datapasien::whereHas('user', function($query) {
            $query->where('roles', 'pasien');
        });
        
        // If search term exists, filter data based on all mentioned columns
        if ($search) {
            $query->where(function($query) use ($search) {
                $query->where('nama_pasien', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('no_telp', 'like', '%' . $search . '%')
                    ->orWhere('nik', 'like', '%' . $search . '%')
                    ->orWhere('tempat_lahir', 'like', '%' . $search . '%')
                    ->orWhere('tanggal_lahir', 'like', '%' . $search . '%')
                    ->orWhere('jenis_kelamin', 'like', '%' . $search . '%')
                    ->orWhere('alamat', 'like', '%' . $search . '%')
                    ->orWhere('no_kberobat', 'like', '%' . $search . '%')
                    ->orWhere('no_kbpjs', 'like', '%' . $search . '%');
            });
        }
        
        // Get query results
        $dataPasien = $query->get();
        
        // Display view with filtered patient data
        return view('pasien.index', compact('dataPasien'));
    }
    
    /**
     * Display the specified patient.
     */
    public function show($id)
    {
        $user = Auth::user();
        
        // Define roles that have the same access rights
        $allowedRoles = ['admin', 'petugas', 'kepala_rs'];
        
        if (in_array($user->roles, $allowedRoles)) {
            // If user has one of the allowed roles, display patient data based on the given ID
            $dataPasien = Datapasien::findOrFail($id);
        } else {
            // If not one of the allowed roles, display patient data belonging to the logged-in user
            $dataPasien = Datapasien::where('user_id', $user->id)->first();
            
            if (!$dataPasien) {
                $dataPasien = new Datapasien([
                    'nama_pasien' => $user->nama_user,
                    'email' => $user->username,
                    'no_telp' => $user->no_telepon,
                    'user_id' => $user->id,
                ]);
                $dataPasien->save();
            }
            
            // Override the ID to be the ID of the logged-in user's patient record
            $id = $dataPasien->id;
            
            // Check if scan files exist in the appropriate directory
            $dataPasien->scan_ktp = $dataPasien->scan_ktp && file_exists(public_path('storage/' . $dataPasien->scan_ktp))
                ? $dataPasien->scan_ktp : null;
            $dataPasien->scan_kberobat = $dataPasien->scan_kberobat && file_exists(public_path('storage/' . $dataPasien->scan_kberobat))
                ? $dataPasien->scan_kberobat : null;
            $dataPasien->scan_kbpjs = $dataPasien->scan_kbpjs && file_exists(public_path('storage/' . $dataPasien->scan_kbpjs))
                ? $dataPasien->scan_kbpjs : null;
            $dataPasien->scan_kasuransi = $dataPasien->scan_kasuransi && file_exists(public_path('storage/' . $dataPasien->scan_kasuransi))
                ? $dataPasien->scan_kasuransi : null;
        }
        
        return view('pasien.show', compact('dataPasien', 'user'));
    }
    
    /**
     * Show the form for creating a new patient record.
     */
    public function create()
    {
        $user = Auth::user();
        
        // Check if patient data already exists for this user
        $existingData = Datapasien::where('user_id', $user->id)->first();
        
        if ($existingData) {
            // If data exists, redirect to show page
            return redirect()->route('pasien.show', $existingData->id);
        }
        
        // Otherwise show the create form
        return view('pasien.create', compact('user'));
    }

    /**
     * Store a newly created patient record in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'nullable|string|max:16',
            'nama_pasien' => 'required|string',
            'email' => 'required|email',
            'no_telp' => 'required|string',
            'tempat_lahir' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable',
            'alamat' => 'nullable|string',
            'no_kberobat' => 'nullable|string',
            'no_kbpjs' => 'nullable|string',
            'scan_ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'scan_kberobat' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'scan_kbpjs' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'scan_kasuransi' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        ]);
        
        $dataPasien = new Datapasien();
        $dataPasien->nama_pasien = $request->nama_pasien;
        $dataPasien->email = $request->email;
        $dataPasien->no_telp = $request->no_telp;
        $dataPasien->nik = $request->nik;
        $dataPasien->tempat_lahir = $request->tempat_lahir;
        $dataPasien->tanggal_lahir = $request->tanggal_lahir;
        $dataPasien->jenis_kelamin = $request->jenis_kelamin;
        $dataPasien->alamat = $request->alamat;
        $dataPasien->no_kberobat = $request->no_kberobat;
        $dataPasien->no_kbpjs = $request->no_kbpjs;
        $dataPasien->user_id = Auth::id();
        
        $dataPasien->save();
        
        // Handle file uploads
        if ($request->hasFile('scan_ktp')) {
            $path = $request->file('scan_ktp')->store('scan_ktp', 'public');
            $dataPasien->update(['scan_ktp' => $path]);
        }
        
        if ($request->hasFile('scan_kberobat')) {
            $path = $request->file('scan_kberobat')->store('scan_kberobat', 'public');
            $dataPasien->update(['scan_kberobat' => $path]);
        }
        
        if ($request->hasFile('scan_kbpjs')) {
            $path = $request->file('scan_kbpjs')->store('scan_kbpjs', 'public');
            $dataPasien->update(['scan_kbpjs' => $path]);
        }
        
        if ($request->hasFile('scan_kasuransi')) {
            $path = $request->file('scan_kasuransi')->store('scan_kasuransi', 'public');
            $dataPasien->update(['scan_kasuransi' => $path]);
        }
        
        return redirect()->route('pasien.show', $dataPasien->id)
            ->with('success', 'Data pasien berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified patient.
     */
    public function edit($id)
    {
        $user = Auth::user();
        $allowedRoles = ['admin', 'petugas'];
        
        // If admin or petugas, can edit any patient record
        if (in_array($user->roles, $allowedRoles)) {
            $dataPasien = Datapasien::findOrFail($id);
        } else {
            // If patient, can only edit their own record
            $dataPasien = Datapasien::where('user_id', $user->id)->firstOrFail();
        }
        
        return view('pasien.update', compact('dataPasien'));
    }
    
    /**
     * Update the specified patient in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nik' => 'required|string|max:16',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'alamat' => 'required|string',
            'no_kberobat' => 'nullable|string',
            'no_kbpjs' => 'nullable|string',
            'scan_ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'scan_kberobat' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'scan_kbpjs' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
            'scan_kasuransi' => 'nullable|file|mimes:jpg,jpeg,png,pdf',
        ]);
        
        $user = Auth::user();
        $allowedRoles = ['admin', 'petugas']; 
        
        // If admin or petugas, can update any patient record
        if (in_array($user->roles, $allowedRoles)) {
            $dataPasien = Datapasien::findOrFail($id);
        } else {
            // If patient, can only update their own record
            $dataPasien = Datapasien::where('user_id', $user->id)->firstOrFail();
        }
        
        $dataPasien->update($request->except(['scan_ktp', 'scan_kberobat', 'scan_kbpjs', 'scan_kasuransi']));
        
        // Handle file uploads
        if ($request->hasFile('scan_ktp')) {
            // Remove old file if it exists
            if ($dataPasien->scan_ktp) {
                Storage::disk('public')->delete($dataPasien->scan_ktp);
            }
            $path = $request->file('scan_ktp')->store('scan_ktp', 'public');
            $dataPasien->update(['scan_ktp' => $path]);
        }
        
        if ($request->hasFile('scan_kberobat')) {
            if ($dataPasien->scan_kberobat) {
                Storage::disk('public')->delete($dataPasien->scan_kberobat);
            }
            $path = $request->file('scan_kberobat')->store('scan_kberobat', 'public');
            $dataPasien->update(['scan_kberobat' => $path]);
        }
        
        if ($request->hasFile('scan_kbpjs')) {
            if ($dataPasien->scan_kbpjs) {
                Storage::disk('public')->delete($dataPasien->scan_kbpjs);
            }
            $path = $request->file('scan_kbpjs')->store('scan_kbpjs', 'public');
            $dataPasien->update(['scan_kbpjs' => $path]);
        }
        
        if ($request->hasFile('scan_kasuransi')) {
            if ($dataPasien->scan_kasuransi) {
                Storage::disk('public')->delete($dataPasien->scan_kasuransi);
            }
            $path = $request->file('scan_kasuransi')->store('scan_kasuransi', 'public');
            $dataPasien->update(['scan_kasuransi' => $path]);
        }
        
        return redirect()->route('pasien.show', $dataPasien->id)->with('success', 'Data pasien berhasil diupdate.');
    }
    
    /**
     * Remove the specified patient from storage.
     */
    public function destroy($id)
    {
        // Only admin can delete patient records
        if (Auth::user()->roles !== 'admin') {
            return redirect()->route('pasien.index')->with('error', 'Anda tidak memiliki izin untuk menghapus data pasien.');
        }
        
        $dataPasien = Datapasien::findOrFail($id);
        
        // Delete associated files
        if ($dataPasien->scan_ktp) {
            Storage::disk('public')->delete($dataPasien->scan_ktp);
        }
        if ($dataPasien->scan_kberobat) {
            Storage::disk('public')->delete($dataPasien->scan_kberobat);
        }
        if ($dataPasien->scan_kbpjs) {
            Storage::disk('public')->delete($dataPasien->scan_kbpjs);
        }
        if ($dataPasien->scan_kasuransi) {
            Storage::disk('public')->delete($dataPasien->scan_kasuransi);
        }
        
        $dataPasien->delete();
        
        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil dihapus');
    }
}