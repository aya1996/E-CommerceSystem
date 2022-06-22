<?php

namespace App\Actions;

use Closure;

class ColorFilter
{
    public function handle($request, Closure $next)
    {
        if (!request()->has('color_id')) {
            return $next($request);
        }
        $builder = $next($request);

        return $builder->whereHas('colors', function ($query) {
            // return $query->where('color_id', request('color_id'));
            return $query->whereIn('color_id', request('color_id'));
        });
    }
}
