<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Arr;

class AuthorizeUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param array $types
     * @return mixed
     */
    public function handle($request, Closure $next, ...$types)
    {
        $userType = $request->user()->type;
        $match = Arr::first($types, function ($type) use ($userType) {
            return $userType === $type;
        });

        if (empty($match))
            return response("", 403);

        return $next($request);
    }
}
