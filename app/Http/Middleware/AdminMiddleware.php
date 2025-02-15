<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        foreach( config('admin.email') as $email ){
            if ( Auth::check() && Auth::user()->email == $email){
                return $next($request);
            }
        }

        return redirect()->route('dashboard');
    }
}
