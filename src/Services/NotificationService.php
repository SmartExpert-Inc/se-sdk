<?php

namespace SE\SDK\Services;

use Illuminate\Http\Request;

final class NotificationService extends BaseService
{
    public function __construct()
    {
        parent::__construct();

        $this->host = config('se_sdk.platform.host');
    }

    public function send(Request $request): ?\stdClass
    {
        $this->withAuth();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("notifications/send", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }
}