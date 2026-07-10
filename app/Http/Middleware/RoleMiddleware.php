<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check()) {
            abort(403);
        }

        if ((int) Auth::user()->role_id !== (int) $role) {
            abort(403);
        }

        return $next($request);
    }
}
