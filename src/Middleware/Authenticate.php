<?php

namespace SE\SDK\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as BaseAuth;
use Illuminate\Http\Request;

class Authenticate extends BaseAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param array $guards
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $sdk = resolve('se_sdk');
        $token = $request->bearerToken();

        if (! $token) {
            return null;
        }

        $user = $sdk->user->authUser($request);

        if ($user) {
            session()->put(['user' => $user]);

            return $next($request);
        }

        return null;
    }

}