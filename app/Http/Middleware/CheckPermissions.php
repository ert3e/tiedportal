<?php

namespace App\Http\Middleware;

use Closure;
use \Permissions;

class CheckPermissions
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

        if( !Permissions::has($permission_group, 'view') ) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest(route('login'));
            }
        }

        return $next($request);
    }
}
