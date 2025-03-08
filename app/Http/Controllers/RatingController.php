<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RatingController extends Controller
{
    /**
     * Store a newly created rating in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'dokter_id' => 'required',
            'rating' => 'required|numeric|min:1|max:5',
            'review' => 'nullable|string|max:500',
        ]);

        try {
            // Log for debugging
            Log::info('Rating submission', [
                'dokter_id' => $request->dokter_id,
                'user_id' => Auth::id(),
                'rating' => $request->rating
            ]);
            
            // Verify doctor exists
            $dokter = dokter::find($request->dokter_id);
            
            if (!$dokter) {
                Log::error('Doctor not found', ['dokter_id' => $request->dokter_id]);
                return back()->with('error', 'Dokter tidak ditemukan.');
            }

            // Update or create the rating
            $rating = Rating::updateOrCreate(
                [
                    'dokter_id' => $request->dokter_id,
                    'user_id' => Auth::id(),
                ],
                [
                    'rating' => $request->rating,
                    'review' => $request->review,
                ]
            );
            
            Log::info('Rating saved', ['rating_id' => $rating->id]);
            
            return back()->with('success', 'Terima kasih atas penilaian Anda!');
        } catch (\Exception $e) {
            Log::error('Rating error', ['error' => $e->getMessage()]);
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
