<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $roles = is_array($role)
        ? $role
        : explode('|', $role);
        
        if(is_null($request->user())){
            abort(404);
        }
        
        if(!$request->user()->hasRole(... $roles)) {
			abort(404);
        }
        
        return $next($request);
    }
}
