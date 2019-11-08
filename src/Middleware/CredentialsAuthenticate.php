<?php

namespace SE\SDK\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as BaseAuth;
use Illuminate\Http\Request;

class CredentialsAuthenticate extends BaseAuth
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

//        TODO: Use this after SPA
//        $guard = $this->auth->guard('api');
//        $token = $request->bearerToken();

//        if (! $token) {
//            throw new AuthenticationException('Unauthenticated.', $guards);
//        }

        $credentials = $sdk->auth->credentials($request);

        if (! $credentials) {
            throw new AuthenticationException('Unauthenticated.', $guards);
        }

        return $next($request);
    }

}