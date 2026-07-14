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
        Schema::create('servis', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel kendaraans dan users (mekanik)
            $table->foreignId('kendaraan_id')->constrained('kendaraans')->onDelete('cascade');
            $table->foreignId('mekanik_id')->nullable()->constrained('users')->onDelete('set null'); 
            
            // Detail Transaksi Servis
            $table->date('tanggal_masuk');
            $table->text('keluhan');
            $table->enum('status', ['antrean', 'dikerjakan', 'selesai'])->default('antrean');
            $table->integer('total_biaya')->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servis');
    }
};