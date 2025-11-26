<?php

namespace App\Http\Middleware;

use Closure;

class ForceHttps
{
    public function handle($request, Closure $next)
    {
        // Kalau request aslinya HTTPS (via Railway proxy), paksa jadi https
        if ($request->header('X-Forwarded-Proto') === 'https') {
            $request->server->set('HTTPS', true);
        }

        return $next($request);
    }
}
