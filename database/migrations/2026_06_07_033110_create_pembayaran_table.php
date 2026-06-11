<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('spp_id')->constrained('spp')->onDelete('cascade');
            $table->string('bulan');
            $table->string('tahun');
            $table->date('tanggal_bayar');
            $table->decimal('jumlah', 15, 0);
            $table->enum('metode', ['Tunai', 'Transfer Bank', 'QRIS'])->default('Tunai');
            $table->enum('status', ['Lunas', 'Belum Lunas', 'Menunggu Verifikasi'])->default('Belum Lunas');
            $table->string('bukti_pembayaran')->nullable();
            $table->foreignId('verifikasi_by')->nullable()->constrained('users');
            $table->datetime('verifikasi_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pembayaran');
    }
};