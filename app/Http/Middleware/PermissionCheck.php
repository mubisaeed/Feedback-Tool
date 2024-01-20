<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
class PermissionCheck
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param  $permission
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permission): mixed
    {
        if (!auth()->user()->can($permission)) {
            abort(401);
        }
        return $next($request);
    }
}
