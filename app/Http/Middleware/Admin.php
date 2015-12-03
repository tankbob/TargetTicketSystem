<?php

namespace TargetInk\Http\Middleware;

use Closure;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(\Auth::user()->admin){
            return $next($request);
        }else{
            return \Redirect::to('/');
        }
    }
}
