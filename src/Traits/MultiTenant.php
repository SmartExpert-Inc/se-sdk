<?php

namespace SE\SDK\Traits;

use Illuminate\Support\Facades\DB;

trait MultiTenant
{
    public function getCurrentUser(): ?int
    {
        return session()->get('user');
    }
}