<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tagihan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('spp_id')->constrained('spp')->onDelete('cascade');
            $table->string('bulan');
            $table->string('tahun');
            $table->decimal('nominal', 15, 0);
            $table->enum('status', ['Lunas', 'Belum Lunas'])->default('Belum Lunas');
            $table->date('jatuh_tempo')->nullable();
            $table->timestamps();
            
            $table->unique(['siswa_id', 'spp_id', 'bulan', 'tahun']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('tagihan');
    }
};