<?php

namespace SE\SDK\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

final class SubdomainService extends BaseService
{
    public function __construct()
    {
        parent::__construct();

        $this->host = config('se_sdk.platform.host');
    }

    public function migrateDatabase(Request $request)
    {
        $response = $this->api
            ->setBaseUrl(config("se_sdk.{$request->input('host')}.host"))
            ->setPrefix($this->prefix)
            ->put("/migrate/database", $request->all())
            ->getObject();

        $this->api->dropState();
        $this->api->dropUrls();

        return $response;
    }

    public static function setDatabase(Request $request)
    {
        if (SubdomainService::hostHasSubdomain() || $request->has('subdomain')) {
            $subdomain = SubdomainService::getSubdomain($request);
            $defaultDbName = Config::get('database.connections.mysql.database');
            Config::set('database.connections.mysql.database', "{$subdomain}_{$defaultDbName}");
        }
    }

    public static function getSubdomain(Request $request): ?string
    {
        return $request->input('subdomain') ?? explode('.', request()->getHost())[0];
    }

    public static function hostHasSubdomain(): bool
    {
        return request()->getHost() !== short_url(config('app.url'));
    }
}