<?php

namespace SE\SDK\Services;

use GuzzleHttp\Client;

final class CarrotQuestService
{
    /** @var Client $client*/
    private $client;

    /** @var $authToken */
    private $authToken;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('carrot_quest.url'),
        ]);
        $this->authToken = config('carrot_quest.auth_token');
    }

    public function addEvent(int $userId, string $event)
    {
        $response = $this->client->request('post', "v1/users/{$userId}/events", [
            'query' => [
                'auth_token' => $this->authToken,
                'by_user_id' => true,
            ],
            'form_params' => [
                'event' => $event,
            ],
        ]);

        return $response->getBody()->getContents();
    }
}