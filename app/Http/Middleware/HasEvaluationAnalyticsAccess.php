<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HasEvaluationAnalyticsAccess
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
        $user = auth()->user();
        $permissions = [
            'isHead' => $user->isHead,
            'dept-report' => $user->hasPermission('course-evaluation', 'dept-report'),
            'course-report' => $user->hasPermission('course-evaluation', 'course-report'),
        ];
        
        foreach ($permissions as $permission)
            if ($permission)
                return $next($request);

        flash('You do not have the system priviledges to access the requested resource')->error();

        return redirect()->route('home');
    }
}
