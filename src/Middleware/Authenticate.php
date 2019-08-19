<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as BaseAuth;

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

        if ($sdk->auth->hasToken()) {
            return $next($request);
        }

        return redirect()->route('login');
    }

}