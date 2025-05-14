<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sub_kriterias', function (Blueprint $table) {
            $table->id('id_sub_kriteria');
            // $table->unsignedBigInteger('kriteria_id');
            $table->string('nama_sub_kriteria');
            $table->integer('bobot_sub_kriteria');
            $table->timestamps();
            $table->foreign('kriteria_id')->references('id_kriteria')->on('kriterias')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_kriterias');
    }
};

