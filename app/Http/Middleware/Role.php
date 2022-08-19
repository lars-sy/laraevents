<?php

namespace App\Http\Middleware;

use Closure;
Use App\Services\UserService;
use Illuminate\Http\Request;

class Role
{

    public function handle(Request $request, Closure $next, $role)
    {
        $userRole = auth()->user()->role;
        if ($userRole !== $role) {
            return redirect(UserService::getDashboardRouteBasedOnUserRole($userRole));
            }
        return $next($request);
    }
}
