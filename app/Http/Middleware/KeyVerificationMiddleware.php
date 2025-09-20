<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class keyVerificationMiddleware
{
    /** @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->get('key') === config('services.verification.key')) {
            return $next($request);
        }
        abort(403, 'your_cant_access');
    }
}
