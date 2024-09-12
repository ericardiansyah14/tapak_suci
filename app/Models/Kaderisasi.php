<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kaderisasi extends Model
{
    use HasFactory;
    protected $table = 'table_kaderisasi'; 
    protected $fillable = [
        'nama_anggota',
        'nomor_tingkatan',
        'tanggal_ijazah',
        'foto_ijazah',
        'link',
        'kode_cabang',
    ];
}
