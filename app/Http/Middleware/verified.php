<?php

namespace App\Http\Middleware;

use Closure;

class verified
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

        if (Auth::user() && auth()->user()->verified) {
            return $next($request);
         }   
        return redirect('/');
    }


    
}
