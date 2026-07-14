<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servis extends Model
{
    use HasFactory;
    
    protected $table = 'servis'; // Wajib ditambahkan

    protected $fillable = [
        'kendaraan_id', 'mekanik_id', 'tanggal_masuk', 'keluhan', 'status', 'total_biaya'
    ];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    public function mekanik()
    {
        return $this->belongsTo(User::class, 'mekanik_id');
    }

    public function detailServis()
    {
        return $this->hasMany(DetailServis::class, 'servis_id');
    }
}