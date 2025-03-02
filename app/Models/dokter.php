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
}