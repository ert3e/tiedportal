<?php

namespace App\Http\Middleware;

use Closure;
use \Permissions;
use \Auth;

class NotDeleted
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

        if(count($request->all()) == 0) return $next($request);

        // dd($request->all());

        $user = false;
        if($request->has('username'))
            $user = \App\Models\User::where('username', $request->get('username'))->first();

        if($request->has('email'))
            $user = \App\Models\User::where('email', $request->get('email'))->first();

        if(!$user) return $next($request);

        if($user->role_id == 99){
            return redirect()->guest(route('login'))->with('error', 'You do not have permission to access this resource.');
        }

        return $next($request);
    }
}
