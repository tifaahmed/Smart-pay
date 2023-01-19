<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Exceptions\UnauthorizedException;

class PermissionHandlerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (app('auth')->guest()) {
            throw UnauthorizedException::notLoggedIn();
        }
        $routeName = $request->route()->getName();

        if (in_array($routeName, config('permission.excluded_routes'))) {
            return $next($request);
        }

        $routePartials = explode('.', $routeName);
        $page = $routePartials[0];
        $action = $routePartials[1];

        switch (true) {
            case in_array($action, ['all','index','show','collection']):
                $permission = $page .' view';
                break;

            case in_array($action, ['create', 'store']):
                $permission = $page .' create';
                break;

            case in_array($action, ['edit', 'update']):
                $permission = $page .' edit';
                break;

            case in_array($action, ['destroy','delete']):
                $permission = $page .' delete';
                break;

            default:
                $permission = $page .' '. $action;
                break;
        }
        if ( app('auth')->user()->can($permission) ) {
            return $next($request);
        }

        throw UnauthorizedException::forPermissions([$permission]);
    }


    
}
