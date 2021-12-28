<?php

namespace App\Http\Middleware;

use Closure;

class LoginMiddleware
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
        if (!empty(session('login_token'))) {
            return $next($request);
        } else {
            session()->flash('toastr', config('toastr.needlogin'));
            return redirect()->route('top');
        }
    }
}
