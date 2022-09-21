<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\Request;

use App\Models\Role;
use App\Models\Menu;
use App\Models\AuthorizationType;
use App\Models\Authorization;

class RouteAuthorization
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
        $routeNameArray = explode(".", $request->route()->getName());
        $routeMenu = $routeNameArray[0];
        $routeType = count($routeNameArray) - 1;

        $role = Role::where('id', auth()->user()->id)->first();
        $menu = Menu::where('name', $routeMenu)->first();
        $authorizationType = AuthorizationType::where('name', $routeType)->first();

        $authorization = Authorization::where('role_id', $role->id)
            ->where('menu_id', $menu->id)
            ->where('authorization_type_id', $authorizationType->id)->first();

        return $authorization->has_access ? $next($request) : to_route('dashboard');
    }
}
