<?php

namespace App\Actions;

use Closure;

class SizeFilter
{
    public function handle($request, Closure $next)
    {
        if (!request()->has('size_id')) {
            return $next($request);
        }
        $builder = $next($request);

        return $builder->whereHas('sizes', function ($query) {
            // return $query->where('size_id', request('size_id'));
            return $query->whereIn('size_id', request('size_id'));
        });
    }
}
