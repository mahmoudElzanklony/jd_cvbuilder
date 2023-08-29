<?php


namespace App\Http\Controllers\Filters;
use Closure;
use Illuminate\Support\Str;

class TagFilter extends FilterRequest
{
    public function handle($request, Closure $next){
        $result = $next($request);
        foreach(request()->keys() as $inputName){
            if (strpos($inputName, 'job') !== false) {
                $values = request($inputName);
                $inputName = Str::replace('job_','',$inputName);
                foreach($values as $v){
                    $v = json_decode($v,true);
                    $result = $result->whereHas($inputName,function ($e) use ($v){
                        $e->where('ar_title','=',$v['value']);

                    });

                }

            }
        }
        return $result;


    }
}

