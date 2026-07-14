<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailServis extends Model
{
    use HasFactory;

    protected $table = 'detail_servis'; // Wajib ditambahkan

    protected $fillable = [
        'servis_id', 'sparepart_id', 'jasa_id', 'jumlah', 'subtotal'
    ];

    public function servis()
    {
        return $this->belongsTo(Servis::class, 'servis_id');
    }

    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class);
    }

    public function jasa()
    {
        return $this->belongsTo(Jasa::class);
    }
}