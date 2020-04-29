<?php

namespace App\Http\Middleware;

use Closure;

class cors
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
        return $next($request)
        ->header('Acces-Control-Allow-Origin','*')
        ->header('Acces-Control-Allow-Methods','PUT,POST,DELETE,GET,OPTIONS')
        ->header('Acces-Control-Allow-Headers','Accept,Authorization,Content-Type');
    }
}
