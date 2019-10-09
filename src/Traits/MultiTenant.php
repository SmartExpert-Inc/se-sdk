<?php

namespace SE\SDK\Traits;

trait MultiTenant
{
    public function getCurrentUser(): ?\stdClass
    {
        $sdk = resolve('se_sdk');

        if (! $sdk->auth->hasToken()) {
            return null;
        }

        return $sdk->auth->user();
    }
}