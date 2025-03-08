<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dokter extends Model
{
    use HasFactory;
    
    // Beritahu Laravel untuk menggunakan tabel 'dokter'
    protected $table = 'dokter';
    
    protected $fillable = ['nama_dokter', 'poliklinik_id', 'foto_dokter'];
    
    public function poliklinik()
    {
        return $this->belongsTo(Poliklinik::class, 'poliklinik_id');
    }
    
    // Add relationship with ratings
    public function ratings()
    {
        return $this->hasMany(Rating::class, 'dokter_id');
    }
    
    // Get average rating for the doctor
    public function getAverageRatingAttribute()
    {
        return $this->ratings()->avg('rating') ?: 0;
    }
}