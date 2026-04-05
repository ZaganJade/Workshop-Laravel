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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('idpesanan');

            // Midtrans
            $table->string('order_id_midtrans')->unique();
            $table->string('transaction_id')->nullable();

            $table->string('payment_type')->nullable();
            $table->string('bank')->nullable();

            $table->integer('gross_amount');

            $table->enum('status', [
                'menunggu',
                'berhasil',
                'kadaluarsa',
                'dibatalkan'
            ])->default('menunggu');

            $table->json('raw_response')->nullable();

            $table->timestamps();

            $table->foreign('idpesanan')
                ->references('idpesanan')
                ->on('pesanans')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
