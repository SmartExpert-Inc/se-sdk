<?php


namespace SE\SDK\Services\Todo;

use Illuminate\Http\Request;
use SE\SDK\Services\{BaseService, ApiClientService};

final class TargetsService extends BaseService
{
    public function __construct(ApiClientService $api)
    {
        parent::__construct($api);

        $this->host = config('se_sdk.todo.host');
    }

    public function index(): ?\stdClass
    {
        $this->withAut();

        $targets = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get('/targets')
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $targets;
    }

    public function store(Request $request): ?\stdClass
    {
        $this->withAut();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("/targets", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function show(int $id): ?\stdClass
    {
        $this->withAut();

        $tag = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/targets/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $tag;
    }

    public function update(Request $request, int $id): ?\stdClass
    {
        $this->withAut();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("/targets/{$id}", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public function destroy(int $id): ?\stdClass
    {
        $this->withAut();

        $tag = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->delete("/targets/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $tag;
    }
}