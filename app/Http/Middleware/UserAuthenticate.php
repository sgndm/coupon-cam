<?php

namespace App\Http\Middleware;

use Closure;

class UserAuthenticate
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
        if(!in_array($request->user()['usertype'], array(1))) {
            return redirect('dashboard');
        }else{
            if($request->user()['accepted'] == '0'){
                return redirect('user/accept');
            }
            return $next($request);
        }

    }
}
