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
        Schema::create('penilaian_oleh_rekan_sejawats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penilai_id')->constrained('gurus');
            $table->foreignId('guru_id')->constrained('gurus');
            $table->float('nilai_akhir')->nullable();
            // $table->unique(['penilai_id', 'guru_id']);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_oleh_rekan_sejawats');
    }
};
