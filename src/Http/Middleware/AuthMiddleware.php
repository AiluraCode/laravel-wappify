<?php

namespace AiluraCode\Wappify\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $isAuthenticatedAdmin = Auth::check();
        if (!$isAuthenticatedAdmin) {
            return response()->json(['message' => config('wappify.middleware.auth.unauthorized-request')], 401);
        }

        return $next($request);
    }
}
