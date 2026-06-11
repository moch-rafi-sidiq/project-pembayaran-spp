<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Jurusan;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Buat admin
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@sekolah.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'status_aktif' => true
        ]);

        // Buat bendahara
        User::create([
            'name' => 'Bendahara Sekolah',
            'username' => 'bendahara',
            'email' => 'bendahara@sekolah.com',
            'password' => Hash::make('bendahara123'),
            'role' => 'bendahara',
            'status_aktif' => true
        ]);

        // Buat kelas dan jurusan dulu untuk siswa
        $kelas = Kelas::first();
        if (!$kelas) {
            $kelas = Kelas::create([
                'nama_kelas' => 'X-A',
                'tingkat' => '10'
            ]);
        }

        $jurusan = Jurusan::first();
        if (!$jurusan) {
            $jurusan = Jurusan::create([
                'kode_jurusan' => 'RPL',
                'nama_jurusan' => 'Rekayasa Perangkat Lunak'
            ]);
        }

        // Buat siswa contoh
        User::create([
            'name' => 'Ahmad Fauzi',
            'username' => '2024001',
            'nis' => '2024001',
            'email' => 'ahmad@siswa.com',
            'password' => Hash::make('siswa123'),
            'role' => 'siswa',
            'jenis_kelamin' => 'L',
            'kelas_id' => $kelas->id,
            'jurusan_id' => $jurusan->id,
            'tahun_ajaran' => '2024/2025',
            'no_telepon' => '08123456789',
            'alamat' => 'Jl. Pendidikan No. 1',
            'status_aktif' => true
        ]);
    }
}