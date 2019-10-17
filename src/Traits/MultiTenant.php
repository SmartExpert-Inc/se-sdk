<?php

namespace SE\SDK\Traits;

use Illuminate\Support\Facades\DB;

trait MultiTenant
{
    public function getCurrentUser(): ?object
    {
//        return session()->get('user');
        $sdk = resolve('se_sdk');

        return $sdk->user->authUser(request());
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOwned($query)
    {
        $user = $this->getCurrentUser();

        if (! $user) {
            return $query;
        }

        return $query->where('user_id', $user->id);
    }
}