<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ProfileMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $request->merge(['profile_id' => session('profile_id')]);
        return $next($request);
    }
}
