<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Coba login dengan username
        $credentials = ['username' => $request->username, 'password' => $request->password];
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            if ($user->role == 'admin' || $user->role == 'bendahara') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->role == 'siswa') {
                return redirect()->intended('/siswa/dashboard');
            }
        }

        // Coba login dengan NIS untuk siswa
        $siswa = \App\Models\User::where('nis', $request->username)
            ->where('role', 'siswa')
            ->first();
            
        if ($siswa && \Illuminate\Support\Facades\Hash::check($request->password, $siswa->password)) {
            Auth::login($siswa);
            $request->session()->regenerate();
            return redirect()->intended('/siswa/dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}