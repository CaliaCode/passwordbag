<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role = null)
    {
        if(Auth::check()){
            if(Auth::user()->status === 0){
                Auth::logout();

                return redirect()->back()->with('inactive', 'Your account is not active.');
            }

            if($role === 'employer' && (Auth::user()->hasRole('employer') || Auth::user()->hasRole('manager') || Auth::user()->hasRole('admin'))) {
                return $next($request);
            }elseif($role === 'manager' && (Auth::user()->hasRole('manager') || Auth::user()->hasRole('admin'))) {
                return $next($request);
            }elseif($role === 'admin' && Auth::user()->hasRole('admin')){
                return $next($request);
            }

            abort(403);
        }else{
            return redirect('login');
        }
    }
}
