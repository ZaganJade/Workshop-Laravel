<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id('idpesanan');

            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('nama');
            $table->integer('total');

            $table->enum('status_bayar', [
                'menunggu',
                'lunas',
                'kadaluarsa'
            ])->default('menunggu');

            $table->timestamp('paid_at')->nullable();

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
