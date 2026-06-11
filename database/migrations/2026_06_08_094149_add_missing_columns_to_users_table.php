<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Cek apakah kolom sudah ada sebelum menambah
            if (!Schema::hasColumn('users', 'kelas_id')) {
                $table->foreignId('kelas_id')->nullable()->constrained('kelas')->onDelete('set null');
            }
            if (!Schema::hasColumn('users', 'jurusan_id')) {
                $table->foreignId('jurusan_id')->nullable()->constrained('jurusan')->onDelete('set null');
            }
            if (!Schema::hasColumn('users', 'tahun_ajaran')) {
                $table->string('tahun_ajaran')->nullable();
            }
            if (!Schema::hasColumn('users', 'no_telepon')) {
                $table->string('no_telepon')->nullable();
            }
            if (!Schema::hasColumn('users', 'alamat')) {
                $table->text('alamat')->nullable();
            }
            if (!Schema::hasColumn('users', 'jenis_kelamin')) {
                $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            }
            if (!Schema::hasColumn('users', 'status_aktif')) {
                $table->boolean('status_aktif')->default(true);
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'kelas_id', 'jurusan_id', 'tahun_ajaran', 
                'no_telepon', 'alamat', 'jenis_kelamin', 'status_aktif'
            ]);
        });
    }
};