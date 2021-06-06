<?php

namespace App\Http\Middleware;

use App\Repositories\FeatureRepository;
use Closure;
use Illuminate\Http\Request;

class FeatureMiddleware
{
    protected $feature;
    public function __construct(FeatureRepository $feature)
    {
        $this->feature = $feature;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        $feature = $user->user_role->feature;
        $credential = $feature->url;
        $base_route = head(explode('.', $request->route()->getName()));
        if ($credential != $base_route) abort(404);

        $features = $this->feature->search(new Request(['code' => $feature->code]));
        $features = $this->feature->nested_data($features, $feature->code);
        view()->share(['features' => $features]);

        return $next($request);
    }
}
