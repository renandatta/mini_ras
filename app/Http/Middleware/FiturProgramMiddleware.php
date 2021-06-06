<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FiturProgramMiddleware
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
        $fitur_program = array(
            ['url' => '/', 'name' => 'Dashboard'],
            ['url' => 'admin.features', 'name' => 'Feature'],
            ['url' => 'profiles', 'name' => 'Profile'],
            ['url' => 'vehicles', 'name' => 'Vehicle'],
            ['url' => 'delivery_orders', 'name' => 'Delivery Order'],
        );
        $fitur_program = json_decode(json_encode($fitur_program));
        view()->share(['fitur_program' => $fitur_program]);

        return $next($request);
    }
}
