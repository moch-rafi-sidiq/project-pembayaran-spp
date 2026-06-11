<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spp extends Model
{
    protected $table = 'spp';
    
    protected $fillable = ['tahun', 'nominal', 'keterangan'];
    
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }
    
    public function tagihans()
    {
        return $this->hasMany(Tagihan::class);
    }
}