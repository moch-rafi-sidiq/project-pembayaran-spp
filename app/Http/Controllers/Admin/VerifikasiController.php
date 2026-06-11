<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifikasiController extends Controller
{
    public function index()
    {
        $pembayaran = Pembayaran::with('siswa')
            ->where('status', 'Menunggu Verifikasi')
            ->orderBy('tanggal_bayar', 'desc')
            ->get();
        
        return view('admin.verifikasi.index', compact('pembayaran'));
    }
    
    public function verify($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->update([
            'status' => 'Lunas',
            'verifikasi_by' => Auth::user()->id,
            'verifikasi_at' => now()
        ]);
        
        // Update status tagihan
        $tagihan = Tagihan::where('siswa_id', $pembayaran->siswa_id)
            ->where('bulan', $pembayaran->bulan)
            ->where('tahun', $pembayaran->tahun)
            ->first();
        
        if ($tagihan) {
            $tagihan->update(['status' => 'Lunas']);
        }
        
        return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi');
    }
    
    public function reject($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->update([
            'status' => 'Belum Lunas',
            'verifikasi_by' => Auth::user()->id,
            'verifikasi_at' => now()
        ]);
        
        return redirect()->back()->with('success', 'Pembayaran ditolak');
    }
}