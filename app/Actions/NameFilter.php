<?php

namespace App\Actions;

use Closure;

class NameFilter
{
    public function handle($request, Closure $next)
    {
        if (!request()->has('name')) {
            return $next($request);
        }
        $builder = $next($request);

        return $builder->where('name', 'like', '%' . request('name') . '%');
    }
}
