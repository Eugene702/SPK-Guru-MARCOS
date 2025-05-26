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
        Schema::create('penilaian_kepsek_detail', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penilaian_id'); // relasi ke penilaian utama
            $table->unsignedBigInteger('pernyataan_id');
            $table->integer('nilai');
            $table->timestamps();
        
            $table->foreign('penilaian_id')->references('id')->on('penilaian_oleh_kepala_sekolah')->onDelete('cascade');
            $table->foreign('pernyataan_id')->references('id')->on('pernyataan_kepala_sekolah');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_kepsek_detail');
    }
};
