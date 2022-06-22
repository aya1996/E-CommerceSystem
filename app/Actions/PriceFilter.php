<?php

namespace App\Actions;

use Closure;

class PriceFilter
{
    public function handle($request, Closure $next)
    {
        if (!request()->has('price')) {
            return $next($request);
        }
        $builder = $next($request);

        return $builder->where('price', '>=', request('price'));
    }
}
