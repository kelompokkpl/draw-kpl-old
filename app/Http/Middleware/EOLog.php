<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class EOLog
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
        $log['created_at'] = date('Y-m-d H:i:s');
        $log['cms_users_id'] = Session::get('admin_id');
        $log['url'] = $request->path();
        if($request->all()==null){
            $log['data'] = null;
        } else{
            $log['data'] = json_encode($request->all());
        }
        if(!empty(Session::get('event_id'))){
            $log['event_id'] = Session::get('event_id');
        }
        DB::table('log')->insert($log);
        return $next($request);
    }
}
