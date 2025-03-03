<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jadwalpoliklinik extends Model
{
    protected $table = 'jadwalpoliklinik';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->kode = 'JP.' . str_pad(static::count() + 1, 8, '0', STR_PAD_LEFT);
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
}
