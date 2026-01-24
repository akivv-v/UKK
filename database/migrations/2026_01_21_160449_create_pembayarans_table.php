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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->unsignedBigInteger('id_transaksi');
            $table->dateTime('waktu_pembayaran'); // Mengubah ke dateTime agar lebih akurat
            $table->integer('total');
            $table->enum('metode', ['Tunai', 'Transfer', 'Dana', 'Gopay', 'QRIS']);
            $table->string('bukti_pembayaran')->nullable();            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};