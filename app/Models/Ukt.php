<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ukt extends Model
{
    use HasFactory;
    protected $table = 'Ukt'; 
    protected $fillable = [
        'nomor_induk',
        'nama_siswa',
        'tingkatan_saat_ini',
        'tingkatan_selanjutnya',
    ];

    public function tingkatan()
{
    return $this->belongsTo(Tingkatan::class, 'kode_angkatan', 'nomor_tingkatan');
}

public function user(){
    return $this->belongsTo(User::class);
}
}
