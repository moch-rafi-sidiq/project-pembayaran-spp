<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
    protected $table = 'tagihan';
    
    protected $fillable = [
        'siswa_id', 'spp_id', 'bulan', 'tahun', 'nominal', 'status', 'jatuh_tempo'
    ];
    
    protected $dates = ['jatuh_tempo'];
    
    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }
    
    public function spp()
    {
        return $this->belongsTo(Spp::class);
    }
}