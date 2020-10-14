<?php

namespace App\Http\Middleware;

use Closure;

class Permissions
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
        $action = $request->route()->getAction();

        $permission_group = $action['permission_group'];

        return $next($request);
    }
}
