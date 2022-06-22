<?php

namespace App\Actions;

use Closure;

class CategoryFilter
{
    public function handle($request, Closure $next)
    {
        if (!request()->has('category_id')) {
            return $next($request);
        }
        $builder = $next($request);

        return $builder->whereHas('categories', function ($query) {
            return $query->where('category_id', request('category_id'));
        
        });
    }
}
