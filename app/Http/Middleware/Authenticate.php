<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Request;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var Auth
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param Auth $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string|null $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role = null)
    {
        if ($this->auth->guard()->guest()) {
            return response('Unauthorized.', 401);
        }

        if ($role) {
            $user = $this->auth->guard()->user();
            if ($role !== $user->role) {
                return response('Unauthorized.', 401);
            }
        }

        return $next($request);
    }
}
