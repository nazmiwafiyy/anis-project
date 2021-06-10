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
        if(!$request->routeIs('profile.create') && !$request->routeIs('profile.store') && $user && $user->id != 1 && !$user->profile)
        {
            Session::flash('success', 'Sila kemas kini profil anda untuk meneruskan.');
            return redirect()->route('profile.create');
        }
        return $next($request);
    }
}
