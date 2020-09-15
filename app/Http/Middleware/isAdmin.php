<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class isAdmin
{
    public function handle($request, Closure $next)
    {
        if (Session::get('level') == 'admin') {
            return $next($request);
        }
        
        return redirect()->back()
            ->with('alert', 'Mohon maaf anda bukan admin.')
            ->with('type', 'danger');
    }
}
