<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kendaraans', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel users (pemilik kendaraan/pelanggan)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            
            // Detail Kendaraan
            $table->string('plat_nomor')->unique();
            $table->string('merk'); // Contoh: Honda, Yamaha
            $table->string('tipe'); // Contoh: Vario 125, NMAX
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kendaraans');
    }
};