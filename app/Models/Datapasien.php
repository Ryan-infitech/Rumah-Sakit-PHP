<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datapasien extends Model
{
    use HasFactory;

    protected $table = 'datapasien';
    protected $fillable = [
        'foto_pasien',
        'nik',
        'nama_pasien',
        'email',
        'no_telp',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'scan_ktp',
        'no_kberobat',
        'scan_kberobat',
        'no_kbpjs',
        'scan_kbpjs',
        'scan_kasuransi',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}