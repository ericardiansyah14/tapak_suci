<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Anggota;

class Cabang extends Model
{
    use HasFactory;
    protected $table = 'table_cabang'; 
    protected $fillable = [
        'nomor_induk_cabang',
        'nama_cabang',
        'alamat_cabang',
        'pelatih_cabang',
    ];
    protected static function boot()
    {
        parent::boot();

        static::deleting(function($cabang){
            $cabang->anggota()->delete();
        });
    }
    // Cabang.php
public function anggota()
{
    return $this->hasMany(Anggota::class, 'kode_cabang', 'nomor_induk_cabang');
}

public function siswa()
{
    return $this->hasMany(Anggota::class, 'kode_cabang', 'nomor_induk_cabang');
}

}
