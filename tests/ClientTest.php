<?php

namespace Tests\Unit;

use SE\SDK\ServiceProvider;
use Tests\TestCase;
use Illuminate\Http\Response;

class HttpClientTest extends TestCase
{
    const TEST_URL = "https://www.mocky.io/v2/5185415ba171ea3a00704eed";

    /**
     * @return void
     */
    public function testGetRequests()
    {
        $response = requests()->get(self::TEST_URL);
        $response->assertStatus(Response::HTTP_OK);
    }

    protected function getPackageProviders($app)
    {
        return [
            \SE\SDK\ServiceProvider::class
        ];
    }
}