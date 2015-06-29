<?php

namespace Lns\SocialFeed\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class TwitterApiClient
{
    private $client;
    private $consumerKey;
    private $consumerSecret;

    public function __construct($consumerKey, $consumerSecret)
    {
        $this->consumerKey = $consumerKey;
        $this->consumerSecret = $consumerSecret;
    }

    public function get($search) {
        $client = $this->createGuzzleClient($this->consumerKey, $this->consumerSecret);

        return $client->get('/1.1/search/tweets.json?q=test');
    }

    protected function createGuzzleClient($consumerKey, $consumerSecret) {
        $client = new Client([
            'base_url' => 'https://api.twitter.com/',
            'defaults' => ['auth' => 'oauth']
        ]);

        $oauth = new Oauth1([
            'consumer_key'    => $consumerKey,
            'consumer_secret' => $consumerSecret
        ]);

        $client->getEmitter()->attach($oauth);

        return $client;
    }


}
