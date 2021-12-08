<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MustBeOwner
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
        if (auth()->user()?->position_id != 1) {
            return redirect('/')->with('forbidden', 'Halaman tidak dapat diakses.');
        }
        return $next($request);
    }
}
