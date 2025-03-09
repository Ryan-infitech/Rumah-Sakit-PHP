<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class jadwalpoliklinik extends Model
{
    protected $table = 'jadwalpoliklinik';
    
    // Add fillable property
    protected $fillable = [
        'kode',
        'dokter_id',
        'poliklinik_id',
        'tanggal_praktek',
        'jam_mulai',
        'jam_selesai',
        'jumlah'
    ];

    // Explicitly set timestamps to true (this is default, but let's be explicit)
    public $timestamps = true;
    
    // Define the column names for created_at and updated_at if they're non-standard
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    // Ensure code generation on creation with better format
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->kode)) {
                // Format: JP-YYYYMMDD-XXXX where XXXX is a sequential number
                $date = Carbon::now()->format('Ymd');
                $latestSchedule = static::where('kode', 'like', "JP-{$date}-%")
                                        ->orderBy('id', 'desc')
                                        ->first();
                
                if ($latestSchedule) {
                    // Extract the sequence number and increment
                    $lastSequence = (int) substr($latestSchedule->kode, -4);
                    $newSequence = str_pad($lastSequence + 1, 4, '0', STR_PAD_LEFT);
                } else {
                    $newSequence = '0001';
                }
                
                $model->kode = "JP-{$date}-{$newSequence}";
            }
        });
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    public function poliklinik()
    {
        return $this->belongsTo(Poliklinik::class);
    }
    
    // Add accessor for kode_jadwalpoliklinik
    public function getKodeJadwalpoliklinikAttribute()
    {
        return $this->kode;
    }
}
