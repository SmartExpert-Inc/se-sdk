<?php

namespace SE\SDK\Services\Products;

use Illuminate\Http\Request;
use SE\SDK\Services\BaseService;

final class QuestionService extends BaseService
{
    public function __construct()
    {
        parent::__construct();

        $this->host = config('se_sdk.products.host');
    }

    public function store(Request $request): ?\stdClass
    {
        $this->withAuth();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("/questions", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function update(int $questionId, Request $request): ?\stdClass
    {
        $this->withAuth();

        $question = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->put("/questions/{$questionId}", $request->except(["_token", "_method"]))
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $question;
    }

    public function show(int $id): ?\stdClass
    {
        $this->withAuth();

        $question = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/questions/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $question;
    }

    public function delete(int $questionId): ?\stdClass
    {
        $this->withAuth();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->delete("/questions/{$questionId}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }
}