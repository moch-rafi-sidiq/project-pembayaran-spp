<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Spp;
use App\Models\Tagihan;
use Illuminate\Http\Request;

class BulkTagihanController extends Controller
{
    public function index()
    {
        $siswa_count = User::where('role', 'siswa')->count();
        $sppList = Spp::all();  // Ambil semua SPP
        return view('admin.tagihan.bulk', compact('siswa_count', 'sppList'));
    }
    
    public function generate(Request $request)
    {
        $request->validate([
            'bulan' => 'required',
            'tahun' => 'required',
            'spp_id' => 'required|exists:spp,id',
        ]);
        
        $siswa = User::where('role', 'siswa')->get();
        $spp = Spp::find($request->spp_id);
        
        if (!$spp) {
            return back()->with('error', 'SPP belum ditentukan! Silakan buat SPP terlebih dahulu.');
        }
        
        $created = 0;
        $skipped = 0;
        
        foreach ($siswa as $s) {
            $exists = Tagihan::where('siswa_id', $s->id)
                ->where('bulan', $request->bulan)
                ->where('tahun', $request->tahun)
                ->exists();
            
            if (!$exists) {
                Tagihan::create([
                    'siswa_id' => $s->id,
                    'spp_id' => $spp->id,
                    'bulan' => $request->bulan,
                    'tahun' => $request->tahun,
                    'nominal' => $spp->nominal,
                    'status' => 'Belum Lunas',
                    'jatuh_tempo' => now()->addDays(30)
                ]);
                $created++;
            } else {
                $skipped++;
            }
        }
        
        $message = "✅ $created tagihan baru dibuat untuk bulan {$request->bulan} {$request->tahun}.";
        if ($skipped > 0) {
            $message .= " $skipped siswa sudah memiliki tagihan.";
        }
        
        return back()->with('success', $message);
    }
}