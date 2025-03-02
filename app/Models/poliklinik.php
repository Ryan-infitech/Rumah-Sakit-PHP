<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class poliklinik extends Model
{
    use HasFactory;
    protected $table = 'poliklinik';
    protected $fillable = [
        'nama_poliklinik',
    ];
}
