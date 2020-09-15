<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class isAdminOrCashier
{
    public function handle($request, Closure $next)
    {
        if (in_array(Session::get('level'), ['admin', 'kasir'])) {
            return $next($request);
        }
        
        return redirect()->back()
            ->with('alert', 'Mohon maaf anda bukan admin atau kasir.')
            ->with('type', 'danger');
    }
}
