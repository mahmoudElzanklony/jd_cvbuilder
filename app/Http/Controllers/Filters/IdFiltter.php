<?php

namespace App\Http\Controllers\Filters;
use Closure;
class IdFiltter extends FilterRequest
{
    public function handle($request, Closure $next){
        if (! request()->filled('id')) {
            return $next($request);
        }

        return $next($request)
            ->whereRaw('id > '.request('id'));
    }
}
