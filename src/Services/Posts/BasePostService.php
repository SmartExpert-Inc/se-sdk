<?php

namespace SE\SDK\Services\Posts;

use SE\SDK\Services\ApiClientService;
use SE\SDK\Services\BaseService;

abstract class BasePostService extends BaseService
{
    /** @var array $headers */
    protected $headers;

    public function __construct(ApiClientService $api)
    {
        parent::__construct($api);

        $this->host = config('se_sdk.posts.host');

        $this->headers = [
            'User-Agent' => 'testing/1.0',
            'Accept' => 'application/json',
//            'Authorization' => resolve('se_sdk')->auth->getToken(),
//            'Content-Type' => 'application/json'
        ];
    }
}