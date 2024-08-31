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
        Schema::create('table_pendekar', function (Blueprint $table) {
            $table->id();
            $table->string('nama_anggota');
            $table->string('nomor_tingkatan');
            $table->date('tanggal_ijazah');
            $table->string('foto_ijazah');
            $table->string('kode_cabang')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_kaderisasi');
    }
};
