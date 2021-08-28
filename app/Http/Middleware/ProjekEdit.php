<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ProjekEdit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->role->role == 'Manager' || auth()->user()->role->role == 'Super Admin') {
            return $next($request);
        }

        return abort('404');
    }
}
