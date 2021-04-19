<?php

namespace SE\SDK\Jobs;

use SE\SDK\Services\ApiClientService;

abstract class BaseJob
{
    public function __construct(ApiClientService $apiClientService)
    {
        $apiClientService->activateSystemMode();
    }
}
