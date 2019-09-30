<?php

namespace SE\SDK\Services;

use Illuminate\Http\Request;

final class SocialService extends BaseService
{
    public function store(Request $request): ?\stdClass
    {
        $this->withAut();

        $social = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post('/socials', $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $social;
    }

    public function show(int $id, Request $request=null): ?\stdClass
    {
        $this->withAut($request);

        $social = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/socials/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $social;
    }
}