<?php

namespace App\Http\Middleware;

use Closure;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!in_array($request->ip(), config('app.api_allow_ips')) ||
            str_replace('Bearer ', '', $request->header('Authorization')) !== config('app.api_token')
        ) {
            abort(403);
        }

        return $next($request);
    }
}
