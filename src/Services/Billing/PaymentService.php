<?php

namespace SE\SDK\Services\Billing;

use Illuminate\Http\Request;
use SE\SDK\Services\BaseService;

final class PaymentService extends BaseService
{
    public function __construct()
    {
        parent::__construct();

        $this->host = config('se_sdk.billing.host');
    }

    public function getRedirectUrl(string $paymentSystem, Request $request): ?\stdClass
    {
        $this->withAuth();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("{$paymentSystem}/get-redirect-url", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }
}