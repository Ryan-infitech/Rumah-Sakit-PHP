<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datapasien extends Model
{
    use HasFactory;
    
    protected $table = 'datapasien';
    
    protected $fillable = [
        'user_id',
        'nik',
        'nama_pasien',
        'email',
        'no_telp',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'scan_ktp',
        'no_kberobat',  // Note: This field name may be different from what's used in the validation
        'scan_kberobat', // Note: This field name may be different from what's used in the validation
        'no_kbpjs',     // BPJS card number
        'scan_kbpjs',   // BPJS card scan
        'scan_kasuransi' // Insurance card scan
    ];
    
    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}