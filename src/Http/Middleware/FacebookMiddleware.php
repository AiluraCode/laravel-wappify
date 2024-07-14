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
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $headers = config('wappify.middleware.facebook.headers');
        if (!in_array($request->header('User-Agent'), $headers['User-Agent'], true)) {
            return response()->json(['message' => 'Request rejected because the client does not belong to Facebook'], 401);
        }

        return $next($request);
    }
}
