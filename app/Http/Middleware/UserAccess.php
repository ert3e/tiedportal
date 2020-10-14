<?php

namespace App\Http\Middleware;

use Closure;
use \Permissions;
use \Auth;

class UserAccess
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
        $parameters = $request->route()->parameters();

        $user = array_get($parameters, 'user', false);

        if( $user && $user->id != Auth::user()->id ) {

            if( !Permissions::has('users', 'view') ) {
                if ($request->ajax()) {
                    return response('Unauthorized.', 401);
                } else {
                    return redirect()->guest(route('login'))->with('error', 'You do not have permission to access this resource.');
                }
            }
        }

        return $next($request);
    }
}
