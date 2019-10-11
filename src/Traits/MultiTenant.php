<?php

namespace SE\SDK\Traits;

use Illuminate\Support\Facades\DB;

trait MultiTenant
{
    public function getCurrentUser(): ?int
    {
        return session()->get('user');
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