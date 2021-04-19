<?php

namespace SE\SDK\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as BaseAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use SE\SDK\Services\UserService;

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
        if ($request->has('system_api_key')
            && $request->input('system_api_key') == config('se_sdk.auth.system_api_key')) {
            return $next($request);
        }

        /** @var UserService $userService */
        $userService = resolve(UserService::class);

        $user = $userService->authUser();

        if (! $user) {
            throw new AuthenticationException('Unauthenticated.', $guards);
        }

        App::setLocale($user->locale
            ?? $request->input('locale', config('app.locale')));

        return $next($request);
    }
}