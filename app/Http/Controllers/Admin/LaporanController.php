<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\User;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pembayaran::where('status', 'Lunas');
        
        // Filter berdasarkan jenis laporan
        if ($request->jenis == 'harian' && $request->tanggal) {
            $query->whereDate('tanggal_bayar', $request->tanggal);
        } elseif ($request->jenis == 'mingguan' && $request->tanggal) {
            $query->whereBetween('tanggal_bayar', [
                date('Y-m-d', strtotime($request->tanggal . ' -7 days')),
                date('Y-m-d', strtotime($request->tanggal))
            ]);
        } elseif ($request->jenis == 'bulanan' && $request->bulan && $request->tahun) {
            $bulanNum = array_search($request->bulan, ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember']) + 1;
            $query->whereMonth('tanggal_bayar', $bulanNum)->whereYear('tanggal_bayar', $request->tahun);
        } elseif ($request->jenis == 'tahunan' && $request->tahun) {
            $query->whereYear('tanggal_bayar', $request->tahun);
        }
        
        $total_transaksi = $query->count();
        $total_pemasukan = $query->sum('jumlah');
        $siswa_lunas = User::where('role', 'siswa')->whereHas('pembayarans', function($q) {
            $q->where('status', 'Lunas');
        })->count();
        $siswa_belum_lunas = User::where('role', 'siswa')->count() - $siswa_lunas;
        $pembayaran = $query->with('siswa')->orderBy('tanggal_bayar', 'desc')->get();
        
        return view('admin.laporan.index', compact('total_transaksi', 'total_pemasukan', 'siswa_lunas', 'siswa_belum_lunas', 'pembayaran'));
    }
    
    public function print(Request $request)
    {
        $pembayaran = $this->getFilteredData($request);
        $title = $this->getTitle($request);
        
        $pdf = Pdf::loadView('admin.laporan.pdf', compact('pembayaran', 'title'));
        return $pdf->download('laporan_' . date('Y-m-d') . '.pdf');
    }
    
    public function exportExcel(Request $request)
    {
        $pembayaran = $this->getFilteredData($request);
        $title = $this->getTitle($request);
        
        return Excel::download(new LaporanExport($pembayaran, $title), 'laporan_' . date('Y-m-d') . '.xlsx');
    }
    
    private function getFilteredData($request)
    {
        $query = Pembayaran::where('status', 'Lunas')->with('siswa');
        
        if ($request->jenis == 'harian' && $request->tanggal) {
            $query->whereDate('tanggal_bayar', $request->tanggal);
        } elseif ($request->jenis == 'mingguan' && $request->tanggal) {
            $query->whereBetween('tanggal_bayar', [
                date('Y-m-d', strtotime($request->tanggal . ' -7 days')),
                date('Y-m-d', strtotime($request->tanggal))
            ]);
        } elseif ($request->jenis == 'bulanan' && $request->bulan && $request->tahun) {
            $bulanNum = array_search($request->bulan, ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember']) + 1;
            $query->whereMonth('tanggal_bayar', $bulanNum)->whereYear('tanggal_bayar', $request->tahun);
        } elseif ($request->jenis == 'tahunan' && $request->tahun) {
            $query->whereYear('tanggal_bayar', $request->tahun);
        }
        
        return $query->orderBy('tanggal_bayar', 'desc')->get();
    }
    
    private function getTitle($request)
    {
        $title = 'Laporan ';
        if ($request->jenis == 'harian' && $request->tanggal) {
            $title .= 'Harian ' . date('d/m/Y', strtotime($request->tanggal));
        } elseif ($request->jenis == 'mingguan' && $request->tanggal) {
            $title .= 'Mingguan per ' . date('d/m/Y', strtotime($request->tanggal));
        } elseif ($request->jenis == 'bulanan' && $request->bulan && $request->tahun) {
            $title .= 'Bulanan ' . $request->bulan . ' ' . $request->tahun;
        } elseif ($request->jenis == 'tahunan' && $request->tahun) {
            $title .= 'Tahunan ' . $request->tahun;
        }
        return $title;
    }
}