<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $siswa = Auth::user();
        $tagihan = $siswa->tagihans;
        $pembayaran = $siswa->pembayarans;
        
        $total_tagihan = $tagihan->sum('nominal');
        $sudah_bayar = $pembayaran->where('status', 'Lunas')->sum('jumlah');
        $sisa_tagihan = $total_tagihan - $sudah_bayar;
        
        $riwayat_terbaru = $pembayaran->sortByDesc('tanggal_bayar')->take(5);
        
        return view('siswa.dashboard', compact(
            'siswa', 'total_tagihan', 'sudah_bayar', 
            'sisa_tagihan', 'riwayat_terbaru'
        ));
    }
    
    public function profil()
    {
        $siswa = Auth::user();
        return view('siswa.profil', compact('siswa'));
    }
    
    public function updateProfil(Request $request)
    {
        $siswa = Auth::user();
        
        $request->validate([
            'name' => 'required',
            'no_telepon' => 'nullable',
            'alamat' => 'nullable',
        ]);
        
        $siswa->update([
            'name' => $request->name,
            'no_telepon' => $request->no_telepon,
            'alamat' => $request->alamat,
        ]);
        
        if ($request->password) {
            $request->validate([
                'password' => 'min:6|confirmed',
            ]);
            $siswa->update([
                'password' => Hash::make($request->password),
            ]);
        }
        
        return redirect()->back()->with('success', 'Profil berhasil diupdate!');
    }
}