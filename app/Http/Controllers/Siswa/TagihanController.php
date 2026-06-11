<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use App\Models\Spp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TagihanController extends Controller
{
    public function index()
    {
        $siswa = Auth::user();
        $tagihan = Tagihan::where('siswa_id', $siswa->id)
        ->orderByRaw("FIELD(bulan, 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember')")
        ->get();
        
        return view('siswa.tagihan', compact('tagihan'));
    }
    
    public function bayar(Request $request)
    {
        $request->validate([
            'bulan' => 'required',
            'tahun' => 'required',
            'metode' => 'required|in:Tunai,Transfer Bank,QRIS',
            'bukti' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Maks 2MB
        ]);
        
        $siswa = Auth::user();
        $spp = Spp::first();

if (!$spp) {
    return back()->with('error', 'SPP belum ditentukan. Silakan hubungi admin.');
}
        
        // Cek apakah sudah pernah bayar
        $existing = Pembayaran::where('siswa_id', $siswa->id)
            ->where('bulan', $request->bulan)
            ->where('tahun', $request->tahun)
            ->where('status', 'Lunas')
            ->first();
        
        if ($existing) {
            return back()->with('error', 'Tagihan untuk bulan ini sudah lunas.');
        }
        
        // Upload bukti jika ada
        $buktiPath = null;
        if ($request->hasFile('bukti')) {
            $buktiPath = $request->file('bukti')->store('bukti_pembayaran', 'public');
        }
        
        Pembayaran::create([
            'siswa_id' => $siswa->id,
            'spp_id' => $spp->id,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'tanggal_bayar' => now(),
            'jumlah' => $spp->nominal,
            'metode' => $request->metode,
            'status' => 'Menunggu Verifikasi',
            'bukti_pembayaran' => $buktiPath,
        ]);
        
        return redirect()->route('siswa.riwayat')->with('success', 'Pembayaran berhasil dikirim, menunggu verifikasi admin.');
    }
}