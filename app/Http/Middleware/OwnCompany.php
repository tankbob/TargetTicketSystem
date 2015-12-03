<?php

namespace TargetInk\Http\Middleware;

use Closure;

class OwnCompany
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
        $company_slug = \Request::segment(1);
        $user = \Auth::user();
        if($user->admin || $user->company_slug == $company_slug){
            return $next($request);
        }else{
            return \Redirect::to('/');
        }
    }
}
