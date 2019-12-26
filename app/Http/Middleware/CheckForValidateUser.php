<?php namespace App\Http\Middleware;

use Closure;

class CheckForValidateUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(!auth()->user()->verify)
        {
            return redirect('/auth/activation');
        }

        if(auth()->user()->suspend)
        {
            return redirect('/auth/password');
        }

        return $next($request);
    }
}