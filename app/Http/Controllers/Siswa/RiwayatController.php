<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RiwayatController extends Controller
{
    public function index()
    {
        $siswa = Auth::user();
        $riwayat = Pembayaran::where('siswa_id', $siswa->id)
            ->with('spp')
            ->orderBy('tanggal_bayar', 'desc')
            ->get();
        
        return view('siswa.riwayat', compact('riwayat'));
    }
    
    public function downloadBukti($id)
    {
        $pembayaran = Pembayaran::where('id', $id)
            ->where('siswa_id', Auth::user()->id)
            ->firstOrFail();
        
        if ($pembayaran->bukti_pembayaran && Storage::disk('public')->exists($pembayaran->bukti_pembayaran)) {
            return Storage::disk('public')->download($pembayaran->bukti_pembayaran);
        }
        
        return back()->with('error', 'File bukti pembayaran tidak ditemukan.');
    }
}