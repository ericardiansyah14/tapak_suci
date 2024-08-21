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
        'ukt_pimda_id',
    ];

    public function tingkatan()
{
    return $this->belongsTo(Tingkatan::class, 'kode_angkatan', 'nomor_tingkatan');
}

public function user(){
    return $this->belongsTo(User::class);
}
public function uktpimda(){
    return $this->hasMany(UktModel::class,'id','ukt_pimda_id');
}
public function tingkatanSaatIni()
    {
        return $this->belongsTo(Tingkatan::class, 'tingkatan_saat_ini', 'nomor_tingkatan');
    }

    public function tingkatanSelanjutnya()
    {
        return $this->belongsTo(Tingkatan::class, 'tingkatan_selanjutnya', 'nomor_tingkatan');
    }
}
