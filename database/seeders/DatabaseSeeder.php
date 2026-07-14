<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kendaraan;
use App\Models\Servis;
use App\Models\Sparepart;
use App\Models\Jasa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Pengguna
        $admin = User::create([
            'name' => 'Admin Bengkel',
            'email' => 'admin@bengkel.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        $kasir = User::create([
            'name' => 'Kasir Bengkel',
            'email' => 'kasir@bengkel.com',
            'password' => Hash::make('password123'),
            'role' => 'kasir',
        ]);

        $mekanik = User::create([
            'name' => 'Mekanik Handal',
            'email' => 'mekanik@bengkel.com',
            'password' => Hash::make('password123'),
            'role' => 'mekanik',
        ]);

        $pelanggan = User::create([
            'name' => 'Dinda Nurul Islami',
            'email' => 'pelanggan@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'pelanggan',
            'no_telp' => '08123456789',
            'alamat' => 'Jl. Merdeka No. 10'
        ]);
        
        $pemilik = User::create([
            'name' => 'Pemilik Maju Motor',
            'email' => 'pemilik@bengkel.com',
            'password' => Hash::make('password123'),
            'role' => 'pemilik',
        ]);

        // 2. Buat Data Kendaraan Milik Pelanggan
        $kendaraan1 = Kendaraan::create([
            'user_id' => $pelanggan->id,
            'plat_nomor' => 'BM 1234 AB',
            'merk' => 'Honda',
            'tipe' => 'Vario 125',
        ]);

        $kendaraan2 = Kendaraan::create([
            'user_id' => $pelanggan->id,
            'plat_nomor' => 'B 9999 XYZ',
            'merk' => 'Yamaha',
            'tipe' => 'NMAX',
        ]);

        // 3. Buat Data Katalog Sparepart & Jasa
        Sparepart::create([
            'nama_sparepart' => 'Oli Mesin MPX2',
            'harga' => 55000,
            'stok' => 20,
        ]);

        Sparepart::create([
            'nama_sparepart' => 'Kampas Rem Depan',
            'harga' => 45000,
            'stok' => 15,
        ]);

        Jasa::create([
            'nama_jasa' => 'Servis Ringan Matik',
            'harga' => 35000,
        ]);

        Jasa::create([
            'nama_jasa' => 'Ganti Oli',
            'harga' => 10000,
        ]);

        // 4. Buat Data Antrean Servis Masuk
        Servis::create([
            'kendaraan_id' => $kendaraan1->id,
            'mekanik_id' => null, // Belum ada mekanik yang ambil
            'tanggal_masuk' => now()->toDateString(),
            'keluhan' => 'Lampu utama mati dan tarikan motor terasa berat gass pol',
            'status' => 'antrean',
            'total_biaya' => 0,
        ]);

        Servis::create([
            'kendaraan_id' => $kendaraan2->id,
            'mekanik_id' => null,
            'tanggal_masuk' => now()->toDateString(),
            'keluhan' => 'Bunyi berdecit di bagian cvt kalau dibawa jalan pelan',
            'status' => 'antrean',
            'total_biaya' => 0,
        ]);
    }
}