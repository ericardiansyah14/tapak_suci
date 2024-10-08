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
        Schema::create('ukt', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_induk')->unique();
            $table->string('nama_siswa');
            $table->string('tingkatan_saat_ini');
            $table->string('tingkatan_selanjutnya');
            $table->unsignedBigInteger('ukt_pimda_id'); 
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ukt');
    }
};
