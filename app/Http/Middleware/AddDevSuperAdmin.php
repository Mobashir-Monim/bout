<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Role;

class AddDevSuperAdmin
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
        if (auth()->user() != null) {
            if (auth()->user()->email == 'mobashir.monim@bracu.ac.bd') {
                auth()->user()->roles()->attach(Role::where('name', 'super-admin')->first()->id);
            }
        }

        return $next($request);
    }
}
