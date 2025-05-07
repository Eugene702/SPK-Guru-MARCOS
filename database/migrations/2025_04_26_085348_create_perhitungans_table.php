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
    Schema::create('perhitungans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('guru_id')->constrained()->onDelete('cascade');
        $table->unsignedBigInteger('administrasi')->nullable(); // Foreign key to sub_kriterias table
        $table->float('supervisi')->nullable();
        $table->float('kehadiran_dikelas')->nullable();
        $table->float('presensi')->nullable();
        $table->float('sertifikat_pengembangan')->nullable();
        $table->float('kegiatan_sosial')->nullable();
        $table->float('rekan_sejawat')->nullable();
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
        Schema::dropIfExists('perhitungans');
    }
};
