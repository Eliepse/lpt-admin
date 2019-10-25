<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthorizeUserRoles
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param array|string $roles
     * @return ResponseFactory|Response|mixed
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
