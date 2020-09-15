<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class isOnline
{
    public function handle($request, Closure $next)
    {
        if (Session::has('is_online') && Session::get('is_online') == TRUE) {
            return $next($request);
        }
        
        return redirect()->route('login')
            ->with('alert', 'Masuk terlebih dahulu agar dapat mengakses halaman tersebut.')
            ->with('type', 'danger');
    }
}
