<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the authenticated user is an admin
        if ($request->user() && $request->user()->isAdmin()) {
            return $next($request);
        }

        // If not an admin, return a response denying access
        return response()->json(['error' => 'Unauthorized. Admins only.'], 403);
    }
}
