<?php


namespace App\Http\Controllers\Filters;


use Illuminate\Support\Str;
use Closure;
class NameFilter extends FilterRequest
{
    public function handle($request, Closure $next){
        if (! request()->filled('name')) {
            return $next($request);
        }

        return $next($request)
            ->where('ar_name','LIKE', '%'.request()->input('name').'%')
            ->orWhere('en_name','LIKE', '%'.request()->input('name').'%');

    }
}
