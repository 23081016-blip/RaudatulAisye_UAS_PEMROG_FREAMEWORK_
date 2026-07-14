<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'plat_nomor', 'merk', 'tipe'];

    // Relasi: Kendaraan ini milik 1 User (Pelanggan)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: 1 Kendaraan bisa diservis berkali-kali
    public function servis()
    {
        return $this->hasMany(Servis::class);
    }
}