<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatKunjungan extends Model
{
    use HasFactory;
    
    protected $table = 'riwayat_kunjungan';
    
    protected $fillable = [
        'antrian_id',
        'pasien_id',
        'dokter_id',
        'poliklinik_id',
        'kode_kunjungan',
        'no_antrian',
        'nama_pasien',
        'nama_dokter',
        'poliklinik',
        'tanggal_kunjungan',
        'waktu_mulai',
        'waktu_selesai',
        'durasi_pelayanan',
        'status',
        'penjamin',
        'catatan',
    ];
    
    protected $casts = [
        'tanggal_kunjungan' => 'date',
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];
    
    // Relationships
    public function antrian()
    {
        return $this->belongsTo(Antrian::class);
    }
    
    public function pasien()
    {
        return $this->belongsTo(Datapasien::class, 'pasien_id');
    }
    
    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }
    
    public function poliklinik()
    {
        return $this->belongsTo(Poliklinik::class);
    }
    
    /**
     * Generate a unique visit code
     * 
     * @return string
     */
    public static function generateKodeKunjungan()
    {
        $prefix = 'VIS';
        $date = now()->format('Ymd');
        $lastRecord = self::orderBy('id', 'desc')->first();
        $lastNumber = $lastRecord ? intval(substr($lastRecord->kode_kunjungan, -4)) : 0;
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        
        return $prefix . $date . $newNumber;
    }
}
