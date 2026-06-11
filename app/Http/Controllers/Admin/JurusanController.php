<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusan = Jurusan::orderBy('nama_jurusan')->get();
        return view('admin.jurusan.index', compact('jurusan'));
    }
    
    public function create()
    {
        return view('admin.jurusan.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'kode_jurusan' => 'required|unique:jurusan',
            'nama_jurusan' => 'required'
        ]);
        
        Jurusan::create($request->all());
        return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan berhasil ditambahkan');
    }
    
    public function edit($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        return view('admin.jurusan.edit', compact('jurusan'));
    }
    
    public function update(Request $request, $id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $request->validate([
            'kode_jurusan' => 'required|unique:jurusan,kode_jurusan,' . $id,
            'nama_jurusan' => 'required'
        ]);
        
        $jurusan->update($request->all());
        return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan berhasil diupdate');
    }
    
    public function destroy($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->delete();
        return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan berhasil dihapus');
    }
}