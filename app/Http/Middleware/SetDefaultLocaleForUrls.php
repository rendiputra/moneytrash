<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\URL;

class SetDefaultLocaleForUrls
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response
     */
    public function handle($request, Closure $next)
    {
        $name = '';
        if($request->is('user','user/*'))
        {
            $name = "user";
        }
        if($request->is('driver','driver/*'))
        {
            $name = "driver";
        }
        if($request->is('admin','admin/*'))
        {
            $name = "admin";
        }
        URL::defaults(['locale' => $name]);

        return $next($request);
    }
}