<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class isAdminOrWaiter
{
    public function handle($request, Closure $next)
    {
        if (in_array(Session::get('level'), ['admin', 'waiter'])) {
            return $next($request);
        }
        
        return redirect()->back()
            ->with('alert', 'Mohon maaf anda bukan admin atau waiter.')
            ->with('type', 'danger');
    }
}
