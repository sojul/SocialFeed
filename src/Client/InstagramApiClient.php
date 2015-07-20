<?php

namespace Lns\SocialFeed\Client;

use GuzzleHttp\Client;

class InstagramApiClient implements ClientInterface
{
    private $clientId;
    private $clientSecret;

    public function __construct($clientId, $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    protected function createGuzzleClient($clientId) {

        $client = new Client([
            'base_url' => 'https://api.instagram.com/',
            'defaults' => [
                'query' => [
                    'client_id' => $clientId
                ]
            ]
        ]);

        return $client;
    }

    public function get($path, array $options = array()) {
        $client = $this->createGuzzleClient($this->clientId);
        return $client->get($path, $options)->json();
    }
}
