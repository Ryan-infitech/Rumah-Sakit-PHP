<?php

namespace App\Models;

use App\Http\Controllers\RatingController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
   use HasFactory;
   
   protected $table = 'antrian';
   
   protected $fillable = [
       'kode_jadwalpoliklinik',
       'kode_antrian',
       'no_antrian',
       'nama_pasien',
       'no_telp',
       'jadwalpoliklinik_id',
       'id_pasien',
       'nama_dokter',
       'poliklinik',
       'penjamin',
       'no_bpjs',
       'scan_kbpjs',
       'scan_kasuransi',
       'tanggal_berobat',
       'tanggal_reservasi',
       'scan_surat_rujukan',
       'user_id',
       'dokter_id',
       'status',
       'waktu_mulai',
       'waktu_selesai',
   ];
   
   public function jadwalpoliklinik()
   {
       return $this->belongsTo(Jadwalpoliklinik::class);
   }
   
   public function dokter()
   {
       return $this->belongsTo(Dokter::class, 'dokter_id');
   }
   
   public function user()
   {
       return $this->belongsTo(User::class);
   }
   
   public function datapasien()
   {
       return $this->belongsTo(Datapasien::class, 'id_pasien');
   }
   
   public function riwayatKunjungan()
   {
       return $this->hasOne(RiwayatKunjungan::class);
   }

   public function rating()
   {
       return $this->hasOne(Rating::class, 'antrian_id');
   }
   
   /**
    * Check if this appointment has been rated
    */
   public function getRatedAttribute()
   {
       return $this->rating()->exists();
   }
   
   protected $casts = [
       'tanggal_berobat' => 'date',
       'tanggal_reservasi' => 'datetime',
       'waktu_mulai' => 'datetime',
       'waktu_selesai' => 'datetime',
   ];

   // Add accessor to capitalize status for display
   public function getStatusAttribute($value)
   {
       return ucfirst($value ?? 'menunggu');
   }
}