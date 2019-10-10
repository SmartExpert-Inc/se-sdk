<?php

namespace SE\SDK\Traits;

use Illuminate\Support\Facades\DB;

trait MultiTenant
{
    public function getCurrentUser(): ?int
    {
        $sdk = resolve('se_sdk');

        if (! $sdk->auth->hasToken()) {
            return null;
        }

        return DB::table('oauth_access_tokens')
            ->select('user_id')
            ->where('id', $sdk->auth->getToken())
            ->first();
    }
}