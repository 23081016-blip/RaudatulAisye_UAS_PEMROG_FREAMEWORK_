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
        Schema::create('detail_servis', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel servis, spareparts, dan jasas
            $table->foreignId('servis_id')->constrained('servis')->onDelete('cascade');
            $table->foreignId('sparepart_id')->nullable()->constrained('spareparts')->onDelete('set null');
            $table->foreignId('jasa_id')->nullable()->constrained('jasas')->onDelete('set null');
            
            // Detail item yang digunakan/dikerjakan
            $table->integer('jumlah')->default(1);
            $table->integer('subtotal');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_servis');
    }
};