<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transaksi_kasir', function (Blueprint $table) {
            $table->id('idtransaksi');
            $table->integer('total');
            $table->timestamps();
        });

        Schema::create('transaksi_kasir_detail', function (Blueprint $table) {
            $table->id('iddetail');
            $table->unsignedBigInteger('idtransaksi');
            $table->string('id_barang');
            $table->string('nama');
            $table->integer('harga');
            $table->integer('jumlah');
            $table->integer('subtotal');
            $table->timestamps();

            $table->foreign('idtransaksi')
                ->references('idtransaksi')
                ->on('transaksi_kasir')
                ->cascadeOnDelete();

            $table->foreign('id_barang')
                ->references('id_barang')
                ->on('barang')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_kasir_detail');
        Schema::dropIfExists('transaksi_kasir');
    }
};
