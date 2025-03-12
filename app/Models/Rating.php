<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Rating extends Model
{
    use HasFactory;
    
    protected $table = 'ratings';
    
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'dokter_id',
        'rating',
        'review',
    ];
    
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        // Add antrian_id to fillable properties if the column exists
        if (Schema::hasTable('ratings') && Schema::hasColumn('ratings', 'antrian_id')) {
            $this->fillable[] = 'antrian_id';
        }
    }
    
    protected $casts = [
        'rating' => 'integer',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function dokter()
    {
        return $this->belongsTo(Dokter::class, 'dokter_id');
    }
    
    public function antrian()
    {
        // Only define this relationship if the column exists
        if (Schema::hasTable('ratings') && Schema::hasColumn('ratings', 'antrian_id')) {
            return $this->belongsTo(Antrian::class);
        }
        
        return null;
    }
    
    // Get the comment attribute (alias for review)
    public function getCommentAttribute()
    {
        return $this->review;
    }
    
    // Scope method to get average rating for a doctor
    public function scopeAverageRatingByDoctor($query, $dokterId)
    {
        return $query->where('dokter_id', $dokterId)
            ->select('dokter_id')
            ->selectRaw('ROUND(AVG(rating), 1) as average_rating')
            ->groupBy('dokter_id');
    }
}
