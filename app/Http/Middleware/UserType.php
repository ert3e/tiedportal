<?php

namespace App\Http\Middleware;

use Closure;
use \Permissions;
use \Auth;

class UserType
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

        $user_type = array_get($action, 'user_type', '');

        if( \Auth::guest() || \Auth::user()->type != $user_type ) {

            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest(route('login'))->with('error', 'You do not have permission to access this resource.');
            }
        }

        return $next($request);
    }
}
