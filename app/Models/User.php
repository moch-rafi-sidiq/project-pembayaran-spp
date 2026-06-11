<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'nis', 'no_telepon', 'alamat',
        'role', 'jenis_kelamin', 'status_aktif', 'kelas_id', 'jurusan_id', 'tahun_ajaran'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'status_aktif' => 'boolean',
    ];
    
    // Relasi
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
    
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
    
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'siswa_id');
    }
    
    public function tagihans()
    {
        return $this->hasMany(Tagihan::class, 'siswa_id');
    }
    
    // Scope
    public function scopeSiswa($query)
    {
        return $query->where('role', 'siswa');
    }
    
    public function scopeActive($query)
    {
        return $query->where('status_aktif', true);
    }
}