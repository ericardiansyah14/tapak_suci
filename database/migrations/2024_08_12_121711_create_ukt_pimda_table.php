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
        Schema::create('ukt_pimda', function (Blueprint $table) {
            $table->id(); // id default adalah unsignedBigInteger
            $table->string('lokasi_ukt');
            $table->string('tanggal_ukt');
            $table->string('ketua_panitia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ukt_pimda');
    }
};


