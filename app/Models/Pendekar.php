<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendekar extends Model
{
    use HasFactory;
    protected $table = 'table_pendekar'; 
    protected $fillable = [
        'nama_anggota',
        'nomor_tingkatan',
        'tanggal_ijazah',
        'foto_ijazah',
        'kode_cabang',
    ];
}
