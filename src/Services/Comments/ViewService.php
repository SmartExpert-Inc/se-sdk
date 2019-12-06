<?php

namespace SE\SDK\Services\Comments;

use Illuminate\Http\Request;

final class ViewService extends BaseService
{
    /** @var array $headers */
    protected $headers;

    public function __construct(ApiClientService $api)
    {
        parent::__construct($api);

        $this->host = config('se_sdk.comments.host');
    }

    public function store(Request $request): ?\stdClass
    {
        $this->withAuth();

        $view = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("/views", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $view;
    }
}