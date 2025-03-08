<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    
    protected $table = 'ratings';
    
    protected $fillable = [
        'dokter_id',
        'user_id',
        'rating',
        'review',
    ];
    
    public function dokter()
    {
        return $this->belongsTo(dokter::class, 'dokter_id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
