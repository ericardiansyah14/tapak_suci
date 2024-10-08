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
        Schema::create('table_tingkatan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_tingkatan')->unique();
            $table->string('kategori');
            $table->string('nama_tingkatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_tingkatan');
    }
};
