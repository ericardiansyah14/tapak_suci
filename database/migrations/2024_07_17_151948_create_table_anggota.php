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
        Schema::create('table_anggota', function (Blueprint $table) {
            $table->id();
            $table->integer('nomor_induk')->unique();
            $table->string('nama_anggota');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->string('alamat');
            $table->integer('telepon_wa');
            $table->string('kode_angkatan');
            $table->date('tangga_ijazah_tingkatan');
            $table->string('prestasi_yang_diraih')->nullable();
            $table->string('photo');
            $table->string('pengalaman_organisasi_tapak_suci')->nullable();
            $table->string('kode_cabang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_anggota');
    }
};
