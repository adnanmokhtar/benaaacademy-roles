<?php

namespace Benaaacademy\Roles\Middlewares;

use Closure;
use Benaaacademy\Platform\Facades\Benaaacademy;
use Gate;

class PermissionMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param  string|null $permission
     * @return mixed
     */
    public function handle($request, Closure $next, $permission = null)
    {

        if (!Gate::allows($permission)) {

            if ($request->is(API . "/*")) {

                return $next($request);

                $response = new BenaaacademyResponse();
                return $response->json(NULL, "Authorization error", 403);

            } else {
                Benaaacademy::forbidden();
            }
        }

        return $next($request);
    }
}
