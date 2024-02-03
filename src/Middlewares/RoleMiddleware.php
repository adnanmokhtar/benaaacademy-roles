<?php

namespace Benaaacademy\Roless\Middlewares;

use Closure;

class RoleMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role = null)
    {

        if (!Auth::user()->hasRole($role) and !Auth::user()->hasRole("superadmin")) {
            if ($request->is(API . "/*")) {
                $response = new BenaaacademyResponse();
                return $response->json(NULL, "Authorization error", 403);
            } else {
                Benaaacademy::forbidden();
            }
        }

        return $next($request);

    }
}
