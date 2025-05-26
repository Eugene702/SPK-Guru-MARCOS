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
        Schema::create('penilaian_oleh_kepala_sekolah', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kepala_sekolah_id'); // relasi ke guru (kepala sekolah)
            $table->unsignedBigInteger('guru_id'); // guru yang dinilai
            $table->float('nilai_akhir')->nullable(); // nilai akhir dari penilaian
            $table->timestamps();
        
            $table->foreign('kepala_sekolah_id')->references('id')->on('gurus');
            $table->foreign('guru_id')->references('id')->on('gurus');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_oleh_kepala_sekolah');
    }
};
