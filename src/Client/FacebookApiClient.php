<?php

namespace Lns\SocialFeed\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class FacebookApiClient implements ClientInterface
{
    private $client;
    private $clientKey;
    private $clientSecret;

    public function __construct($clientKey, $clientSecret)
    {
        $this->clientKey = $clientKey;
        $this->clientSecret = $clientSecret;
    }

    public function get($path) {
        $client = $this->createGuzzleClient($this->clientKey, $this->clientSecret);

        return $client->get('/v2.3' . $path)->json();
    }

    protected function createGuzzleClient($clientKey, $clientSecret) {
        $client = new Client([
            'base_url' => 'https://graph.facebook.com',
            'defaults' => [
                'query' => [
                    'access_token' => $clientKey . '|' . $clientSecret
                ]
            ]
        ]);

        return $client;
    }

}
