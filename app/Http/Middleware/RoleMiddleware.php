<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (!auth()->check()) {
            abort(403);
        }

        if ((int) auth()->user()->role !== (int) $role) {
            abort(403);
        }

        return $next($request);
    }
}
