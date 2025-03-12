<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Dokter;
use App\Models\Antrian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

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
        // Log the entire request for debugging
        Log::info('Rating submission - Raw request data:', $request->all());

        // Validate request data with less strict rules
        $validated = $request->validate([
            'dokter_id' => 'required',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        try {
            // Start a database transaction
            DB::beginTransaction();
            
            // Verify doctor exists
            $dokter = Dokter::find($request->dokter_id);
            
            if (!$dokter) {
                Log::error('Doctor not found', ['dokter_id' => $request->dokter_id]);
                return back()->with('error', 'Dokter tidak ditemukan.');
            }
            
            $userId = Auth::id();
            Log::info('User submitting rating:', ['user_id' => $userId]);
            
            // Check if user has already rated this doctor
            $existingRating = Rating::where('dokter_id', $request->dokter_id)
                                    ->where('user_id', $userId)
                                    ->first();
            
            if ($existingRating) {
                Log::info('User has already rated this doctor', [
                    'user_id' => $userId,
                    'dokter_id' => $request->dokter_id,
                    'existing_rating' => $existingRating->rating
                ]);
                
                return back()->with('info', 'Anda sudah memberikan penilaian untuk dokter ini sebelumnya.');
            }
            
            // Get the comment text
            $commentText = $request->review ?? null;
            
            Log::info('Comment text found:', ['comment' => $commentText]);
            
            // Check if the antrian_id column exists in the ratings table
            $hasAntrianIdColumn = Schema::hasColumn('ratings', 'antrian_id');
            Log::info('Has antrian_id column:', ['exists' => $hasAntrianIdColumn]);
            
            // Create rating data
            $ratingData = [
                'user_id' => $userId,
                'dokter_id' => $request->dokter_id,
                'rating' => $request->rating,
                'review' => $commentText,
            ];
            
            // Only include antrian_id if the column exists
            if ($hasAntrianIdColumn && $request->antrian_id) {
                $ratingData['antrian_id'] = $request->antrian_id;
            }
            
            // Create new rating
            $rating = Rating::create($ratingData);
            
            DB::commit();
            
            Log::info('Rating saved successfully', [
                'rating_id' => $rating->id,
                'dokter_id' => $request->dokter_id,
                'user_id' => $userId,
                'rating_value' => $request->rating
            ]);
            
            return back()->with('success', 'Terima kasih atas penilaian Anda!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Rating error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
