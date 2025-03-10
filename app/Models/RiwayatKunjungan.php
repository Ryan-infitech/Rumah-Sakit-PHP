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
    
    // Generate a unique code for the visit
    public static function generateKodeKunjungan()
    {
        $date = now()->format('Ymd');
        $randomString = strtoupper(substr(uniqid(), -4));
        return "VISIT-{$date}-{$randomString}";
    }
}
