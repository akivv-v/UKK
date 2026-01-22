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
        Schema::create('penjuals', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('nama_user');
            $table->text('alamat')->nullable();
            $table->string('no_hp', 15)->nullable();
            $table->enum('role', ['Admin', 'Pemilik Toko'])->default('Admin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjuals');
    }
};
