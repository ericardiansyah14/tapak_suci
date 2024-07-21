<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Anggota;

class Tingkatan extends Model
{
    use HasFactory;
    protected $table = 'table_tingkatan'; 
    protected $fillable = [
        'nomor_tingkatan',
        'nama_tingkatan',
    ];
    protected static function boot()
    {
        parent::boot();

        static::deleting(function($tingkatan){
            $tingkatan->anggota()->delete();
        });
    }
public function anggota()
{
    return $this->hasMany(Anggota::class, 'kode_angkatan', 'nomor_tingkatan');
}

}
