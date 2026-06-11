<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'bendahara')) {
            return $next($request);
        }

        return redirect('/login')->withErrors('Anda tidak memiliki akses ke halaman admin.');
    }
}