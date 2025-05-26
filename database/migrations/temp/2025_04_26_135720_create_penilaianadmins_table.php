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
        Schema::create('penilaianadmins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->unsignedBigInteger('administrasi')->nullable();
            $table->float('presensi_realita')->nullable();
            $table->integer('sertifikat_pengembangan')->nullable();
            $table->integer('kegiatan_sosial')->nullable();
            $table->timestamps();

             // Foreign key administrasi
            $table->foreign('administrasi')->references('id_sub_kriteria')->on('sub_kriterias')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaianadmins');
    }
};
