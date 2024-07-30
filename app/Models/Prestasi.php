<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestasi extends Model
{
    use HasFactory;
    protected $table = 'prestasi'; 
    protected $fillable = [
        'nama_event',
        'skala_event',
        'tanggal_event',
        'prestasi_yang_diraih',
        'pelatih',
    ];

}
