<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'no_telp',
        'alamat',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi: 1 User (Pelanggan) bisa punya banyak Kendaraan
    public function kendaraans()
    {
        return $this->hasMany(Kendaraan::class);
    }

    // Relasi: 1 User (Mekanik) bisa mengerjakan banyak Servis
    public function servisMekanik()
    {
        return $this->hasMany(Servis::class, 'mekanik_id');
    }
}