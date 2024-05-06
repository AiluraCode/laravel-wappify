<?php

namespace AiluraCode\Wappify\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FacebookMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $headers = config('wappify.middleware.facebook.headers');
        if (!in_array($request->header('User-Agent'), $headers['User-Agent'])) {
            return response()->json(['message' => config('wappify.middleware.facebook.unauthorized-request')], 401);
        }
        return $next($request);
    }
}
