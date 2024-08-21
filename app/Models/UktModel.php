<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UktModel extends Model
{
    use HasFactory;
    protected $table = 'ukt_pimda'; 
    protected $fillable = [
        'lokasi_ukt',
        'tanggal_ukt',
        'ketua_panitia',
    
    ];

    public function uktaja(){
        return $this->belongsTo(Ukt::class,'id','ukt_pimda_id');
    }
}
