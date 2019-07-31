<?php

namespace SE\SDK\Facades;

use Illuminate\Support\Facades\Facade;

class SeSDK extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'se_sdk';
    }
}