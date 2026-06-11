<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    
    protected $fillable = [
        'siswa_id', 'spp_id', 'bulan', 'tahun', 'tanggal_bayar',
        'jumlah', 'metode', 'status', 'bukti_pembayaran',
        'verifikasi_by', 'verifikasi_at'
    ];
    
    protected $dates = ['tanggal_bayar', 'verifikasi_at'];
    
    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }
    
    public function spp()
    {
        return $this->belongsTo(Spp::class);
    }
    
    public function verifikator()
    {
        return $this->belongsTo(User::class, 'verifikasi_by');
    }
}