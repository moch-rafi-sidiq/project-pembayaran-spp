<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tagihan;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

class CekTagihanJatuhTempo extends Command
{
    protected $signature = 'tagihan:cek-jatuh-tempo';
    protected $description = 'Cek tagihan jatuh tempo dan kirim notifikasi';

    public function handle()
    {
        $tagihan = Tagihan::where('status', 'Belum Lunas')
            ->where('jatuh_tempo', '<=', now())
            ->get();

        if ($tagihan->isEmpty()) {
            $this->info('Tidak ada tagihan jatuh tempo.');
            return;
        }

        foreach ($tagihan as $t) {
            $siswa = $t->siswa;
            
            // Kirim Email
            try {
                Mail::raw("Halo {$siswa->name}, tagihan SPP bulan {$t->bulan} {$t->tahun} sudah jatuh tempo. Segera bayar!", function ($message) use ($siswa) {
                    $message->to($siswa->email)
                            ->subject('⚠️ Tagihan SPP Jatuh Tempo');
                });
                $this->info("Email dikirim ke {$siswa->name} ({$siswa->email})");
            } catch (\Exception $e) {
                $this->error("Gagal kirim email ke {$siswa->name}: " . $e->getMessage());
            }

            // Kirim WhatsApp (jika ada no telepon dan API key)
            if ($siswa->no_telepon && env('FONNTE_API_KEY')) {
                try {
                    Http::post('https://api.fonnte.com/send', [
                        'target' => $siswa->no_telepon,
                        'message' => "Halo {$siswa->name},\nTagihan SPP bulan {$t->bulan} {$t->tahun} sudah jatuh tempo!\nSegera bayar di: " . url('/siswa/tagihan'),
                        'apiKey' => env('FONNTE_API_KEY'),
                    ]);
                    $this->info("WA dikirim ke {$siswa->name} ({$siswa->no_telepon})");
                } catch (\Exception $e) {
                    $this->error("Gagal kirim WA ke {$siswa->name}: " . $e->getMessage());
                }
            }
        }

        $this->info('Selesai cek tagihan jatuh tempo.');
    }
}