<?php

namespace SE\SDK\Traits;

trait Testable
{
    public function withoutMiddleware($middleware = null): void
    {
        if (is_null($middleware)) {
            app()->instance('middleware.disable', true);

            return;
        }

        foreach ((array) $middleware as $abstract) {
            app()->instance($abstract, new class {
                public function handle($request, $next) {
                    return $next($request);
                }
            });
        }

        return;
    }
}