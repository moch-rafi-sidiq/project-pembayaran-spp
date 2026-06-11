<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Spp;
use Illuminate\Http\Request;

class SppController extends Controller
{
    public function index()
    {
        $spp = Spp::orderBy('tahun', 'desc')->get();
        return view('admin.spp.index', compact('spp'));
    }
    
    public function create()
    {
        return view('admin.spp.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'tahun' => 'required',
            'nominal' => 'required|numeric'
        ]);
        
        Spp::create($request->all());
        return redirect()->route('admin.spp.index')->with('success', 'SPP berhasil ditambahkan');
    }
    
    public function edit($id)
    {
        $spp = Spp::findOrFail($id);
        return view('admin.spp.edit', compact('spp'));
    }
    
    public function update(Request $request, $id)
    {
        $spp = Spp::findOrFail($id);
        $request->validate([
            'tahun' => 'required|unique:spp,tahun,' . $id,
            'nominal' => 'required|numeric'
        ]);
        
        $spp->update($request->all());
        return redirect()->route('admin.spp.index')->with('success', 'SPP berhasil diupdate');
    }
    
    public function destroy($id)
    {
        $spp = Spp::findOrFail($id);
        $spp->delete();
        return redirect()->route('admin.spp.index')->with('success', 'SPP berhasil dihapus');
    }
}