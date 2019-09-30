<?php


namespace SE\SDK\Services\Todo;

use Illuminate\Http\Request;
use SE\SDK\Services\{BaseService, ApiClientService};

class PriorityService extends BaseService
{
    public function __construct(ApiClientService $api)
    {
        parent::__construct($api);

        $this->host = config('se_sdk.todo.host');
    }

   /* public function index(): ?\stdClass
    {
        $this->withAut();

        $priority = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->get("/priority")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $priority;
    }

    public function store(Request $request): ?\stdClass
    {
        $this->withAut();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("/priority", $request->all())
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
            ->get("/priority/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $tag;
    }*/

    public function update(Request $request, int $id): ?\stdClass
    {
        $this->withAut();

        $response = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->post("/priority/{$id}", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

   /* public function destroy(int $id): ?\stdClass
    {
        $this->withAut();

        $tag = $this->api
            ->setHeaders($this->headers)
            ->setBaseUrl($this->host)
            ->setPrefix($this->prefix)
            ->delete("/priority/{$id}")
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $tag;
    }*/
}