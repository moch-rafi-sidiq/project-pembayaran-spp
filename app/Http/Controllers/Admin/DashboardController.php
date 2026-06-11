<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $total_siswa = User::where('role', 'siswa')->count();
        $total_pembayaran = Pembayaran::where('status', 'Lunas')->sum('jumlah');
        $belum_lunas = Tagihan::where('status', 'Belum Lunas')->count();
        
        $bulan_ini = date('Y-m');
        $pendapatan_bulan = Pembayaran::where('status', 'Lunas')
            ->whereRaw("DATE_FORMAT(tanggal_bayar, '%Y-%m') = ?", [$bulan_ini])
            ->sum('jumlah');
        
        $tahun_ini = date('Y');
        $pendapatan_tahun = Pembayaran::where('status', 'Lunas')
            ->whereYear('tanggal_bayar', $tahun_ini)
            ->sum('jumlah');
        
        $chart_data = [];
    $tahun_ini = date('Y');
    
    for ($bulan = 1; $bulan <= 12; $bulan++) {
        $total = Pembayaran::where('status', 'Lunas')
            ->whereYear('tanggal_bayar', $tahun_ini)
            ->whereMonth('tanggal_bayar', $bulan)
            ->sum('jumlah');
        
        $chart_data[] = (int) $total;
    }
        
        $pembayaran_terbaru = Pembayaran::with('siswa')
            ->orderBy('tanggal_bayar', 'desc')
            ->limit(10)
            ->get();
        
        $tagihan_jatuh_tempo = Tagihan::with('siswa')
            ->where('status', 'Belum Lunas')
            ->where('jatuh_tempo', '<', now()->addDays(7))
            ->limit(5)
            ->get();
        
        return view('admin.dashboard', compact(
        'total_siswa', 'total_pembayaran', 'belum_lunas',
        'pendapatan_bulan', 'pendapatan_tahun', 'chart_data',
        'pembayaran_terbaru', 'tagihan_jatuh_tempo'
    ));
    }
}