<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is authenticated and is an admin
        if ($request->user() && $request->user()->is_admin == 1) {
            return $next($request);
        }

        // Return a 404 response if the user is not an admin
        abort(404);
    }
}