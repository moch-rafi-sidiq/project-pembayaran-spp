<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    
    protected $fillable = ['nama_kelas', 'tingkat'];
    
    public function siswas()
    {
        return $this->hasMany(User::class, 'kelas_id');
    }
}