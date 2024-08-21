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
        Schema::create('table_cabang', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_induk_cabang')->unique();
            $table->string('nama_cabang');
            $table->string('alamat_cabang');
            $table->string('kelurahan');
            $table->string('kecamatan');
            $table->string('status');
            $table->string('pelatih_cabang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_cabang');
    }
};
