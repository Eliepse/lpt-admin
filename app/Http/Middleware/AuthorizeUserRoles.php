<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Arr;

class AuthorizeUserRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param array|string $roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        /** @var User $user */
        $user = $request->user();

        if (!$user->roles->hasOne(is_string($roles) ? [$roles] : $roles))
            return response("", 403);

        return $next($request);
    }
}
