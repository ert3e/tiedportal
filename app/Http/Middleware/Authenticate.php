<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // dd();
        if(Auth::user() != null && Auth::user()->role_id == 99){
            return redirect()->guest(route('login'))->with('error', 'You do not have permission to access this resource.');
        }
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest(route('login'));
            }
        }

        return $next($request);
    }
}
