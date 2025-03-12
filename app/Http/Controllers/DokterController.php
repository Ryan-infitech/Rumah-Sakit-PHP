<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokter;
use App\Models\Poliklinik;
use App\Models\Rating;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all doctors with their poliklinik relationship
        $dokter = Dokter::with('poliklinik')->latest()->get();
        
        // Calculate average ratings for all doctors using efficient query
        $dokterRatings = Rating::select('dokter_id', DB::raw('ROUND(AVG(rating), 1) as average_rating'))
            ->groupBy('dokter_id')
            ->pluck('average_rating', 'dokter_id')
            ->toArray();
        
        // Log the ratings for debugging
        Log::info('Doctor ratings:', $dokterRatings);
        
        return view('dokter.index', [
            'dokter' => $dokter,
            'dokterRatings' => $dokterRatings
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Log::info('Metode create dipanggil');
        $poliklinik = Poliklinik::all();
        return view('dokter.create', compact('poliklinik'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'nama_dokter' => 'required|max:255',
            'poliklinik_id' => 'required',
            'foto_dokter' => 'image|nullable|max:1999'
        ]);

        // Proses upload file foto
        if ($request->hasFile('foto_dokter')) {
            $filenameWithExt = $request->file('foto_dokter')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('foto_dokter')->getClientOriginalExtension();
            $filenameToStore = $filename . '_' . time() . '.' . $extension;
            $path = $request->file('foto_dokter')->storeAs('public/foto_dokter', $filenameToStore);
        } else {
            $filenameToStore = 'noimage.jpg';
        }

        // Simpan data dokter baru
        $dokter = new Dokter;
        $dokter->nama_dokter = $validatedData['nama_dokter'];
        $dokter->poliklinik_id = $validatedData['poliklinik_id'];
        $dokter->foto_dokter = $filenameToStore;
        $dokter->save();

        return redirect()->route('dokter.index')->with('success', 'Berhasil menyimpan data');
        return redirect()->back()->withInput()->withErrors(['error' => 'Gagal menyimpan data. Silakan coba lagi.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dokter = Dokter::with('poliklinik')->findOrFail($id);
        
        // Get average rating for this doctor
        $averageRating = Rating::where('dokter_id', $id)->avg('rating') ?: 0;
        
        // Log for debugging
        Log::info('Doctor average rating', [
            'dokter_id' => $id, 
            'averageRating' => $averageRating,
            'rating_count' => Rating::where('dokter_id', $id)->count()
        ]);
        
        // Get all ratings for this doctor with user information
        $ratings = Rating::with('user')
            ->where('dokter_id', $id)
            ->latest()
            ->get();
        
        // Use the review column directly for displaying comments
        $ratings->each(function($rating) {
            $rating->comment = $rating->review;
        });
        
        return view('dokter.show', compact('dokter', 'averageRating', 'ratings'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dokter = Dokter::find($id);
        $poliklinik = Poliklinik::all(); // Asumsikan Anda memiliki model Poliklinik untuk mengambil semua data poliklinik
        return view('dokter.update', compact('dokter', 'poliklinik'));
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
        // Validation remains the same
        $validatedData = $request->validate([
            'nama_dokter' => 'required|max:255',
            'poliklinik_id' => 'required',
            'foto_dokter' => 'image|nullable|max:1999'
        ]);
    
        // Find the doctor record
        $dokter = Dokter::findOrFail($id);
    
        // Only handle photo upload if a new file is provided
        if ($request->hasFile('foto_dokter')) {
            $filenameWithExt = $request->file('foto_dokter')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('foto_dokter')->getClientOriginalExtension();
            $filenameToStore = $filename . '_' . time() . '.' . $extension;
            $path = $request->file('foto_dokter')->storeAs('public/foto_dokter', $filenameToStore);
    
            // Delete old photo if it's not the default
            if ($dokter->foto_dokter != 'noimage.jpg') {
                Storage::delete('public/foto_dokter/' . $dokter->foto_dokter);
            }
            
            // Set the new filename only if a file was uploaded
            $dokter->foto_dokter = $filenameToStore;
        }
    
        // Update the doctor data
        $dokter->nama_dokter = $validatedData['nama_dokter'];
        $dokter->poliklinik_id = $validatedData['poliklinik_id'];
        
        if ($dokter->save()) {
            return redirect()->route('dokter.index')->with('success', 'Data berhasil diperbarui');
        } else {
            return redirect()->back()->withInput()->withErrors(['error' => 'Gagal memperbarui data. Silakan coba lagi.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dokter = Dokter::findOrFail($id);

        // Hapus file foto jika bukan 'noimage.jpg'
        if ($dokter->foto_dokter != 'noimage.jpg') {
            Storage::delete('public/foto_dokter/' . $dokter->foto_dokter);
        }

        // Hapus data dokter dari database
        $dokter->delete();

        return redirect()->route('dokter.index')->with('success', 'Data berhasil dihapus');
    }
}