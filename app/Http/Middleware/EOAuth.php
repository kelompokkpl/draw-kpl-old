<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use Illuminate\Support\Facades\URL;

class EOAuth
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
        if(Session::get('admin_id')==''){
            return redirect(URL::to(''));
        } else {
            if(Session::get('admin_privileges') !=2 ){
                return redirect(URL::to('admin'));
            }
        }
        return $next($request);
    }
}
