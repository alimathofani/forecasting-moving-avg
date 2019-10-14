<?php

namespace App\Http\Middleware;

use Closure;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        $permissions = is_array($permission)
        ? $permission
        : explode('|', $permission);

        if(is_null($request->user())){
            abort(404);
        }

        if($permission !== null && !$request->user()->hasPermissionInRole($permissions)) {
            abort(404);
        }
        
        return $next($request);
    }
}
