<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $table = 'table_siswa'; 
    protected $fillable = [
        'nomor_induk',
        'nama_anggota',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'telepon_wa',
        'kode_angkatan',
        'tangga_ijazah_tingkatan',
        'prestasi_yang_diraih',
        'photo',
        'pengalaman_organisasi_tapak_suci',
        'kode_cabang',
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class, 'kode_cabang', 'nomor_induk_cabang');
    }
    
    public function tingkatan()
    {
        return $this->belongsTo(Tingkatan::class, 'kode_angkatan', 'nomor_tingkatan');
    }
}
