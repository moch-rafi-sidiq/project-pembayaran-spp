<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function index()
    {
        $pengguna = User::whereIn('role', ['admin', 'bendahara'])->get();
        return view('admin.pengguna.index', compact('pengguna'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);
        
        User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status_aktif' => true
        ]);
        
        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil ditambahkan');
    }
    
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Cegah menghapus akun sendiri
        if ($user->id == auth()->id()) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus akun sendiri');
        }
        
        $user->delete();
        return redirect()->route('admin.pengguna.index')->with('success', 'Pengguna berhasil dihapus');
    }
}