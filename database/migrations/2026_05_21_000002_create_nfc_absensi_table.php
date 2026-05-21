<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('nfc_absensi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mahasiswa_id');
            $table->enum('tipe', ['masuk', 'pulang']);
            $table->dateTime('waktu')->index();
            $table->timestamps();

            $table->foreign('mahasiswa_id')
                ->references('id')
                ->on('mahasiswa')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nfc_absensi');
    }
};
