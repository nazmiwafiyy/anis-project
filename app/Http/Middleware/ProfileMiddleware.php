<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProfileMiddleware
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
        $user = $request->user();
        if(!$request->routeIs('profile.edit') && !$request->routeIs('profile.update') && $user && !$user->hasRole('super-admin') && (!$user->profile->fullname || !$user->profile->identity_no || !$user->profile->phone_no || !$user->profile->position_id || !$user->profile->department_id))
        {
            Session::flash('success', 'Please update your profile to continue.');
            return redirect()->route('profile.edit',$user->id);
        }
        return $next($request);
    }
}
