<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\User;
use App\Models\Spp;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayaran = Pembayaran::with('siswa')->orderBy('tanggal_bayar', 'desc')->paginate(15);
        return view('admin.pembayaran.index', compact('pembayaran'));
    }
    
    public function create()
    {
        $siswa = User::where('role', 'siswa')->get();
        $spp = Spp::all();
        return view('admin.pembayaran.create', compact('siswa', 'spp'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required',
            'spp_id' => 'required',
            'bulan' => 'required',
            'tahun' => 'required',
            'tanggal_bayar' => 'required',
            'metode' => 'required',
            'status' => 'required'
        ]);
        
        // Ambil nominal dari SPP
        $spp = Spp::findOrFail($request->spp_id);
        
        Pembayaran::create([
            'siswa_id' => $request->siswa_id,
            'spp_id' => $request->spp_id,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'tanggal_bayar' => $request->tanggal_bayar,
            'jumlah' => $spp->nominal,
            'metode' => $request->metode,
            'status' => $request->status
        ]);
        
        return redirect()->route('admin.pembayaran.index')->with('success', 'Pembayaran berhasil ditambahkan');
    }
    
    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->delete();
        return redirect()->route('admin.pembayaran.index')->with('success', 'Pembayaran berhasil dihapus');
    }
}