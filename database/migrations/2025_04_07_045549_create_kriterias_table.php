<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kriterias', function (Blueprint $table) {
            $table->id();//ini harus dibuat ulang karena ada perubahan nama di databasenya
            $table->string('nama_kriteria');
            $table->integer('bobot_kriteria');
            $table->enum('jenis', ['Benefit', 'Cost']);
            $table->string('cara_penilaian');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kriterias');
    }
};
