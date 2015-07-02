<?php

namespace Lns\SocialFeed\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;
use Lns\SocialFeed\Exception\RequestException;

class TwitterApiClient implements ClientInterface
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

        try {
            return $client->get('/1.1/search/tweets.json?q=' . $search)->json();
        } catch(GuzzleRequestException $e) {
            $message = $e->getMessage();

            if ($e->hasResponse()) {

                $responseData = $e->getResponse()->json();

                $messageParts = array();

                foreach($responseData['errors'] as $error) {
                    $messageParts[] = $error['message'];
                }

                $message = join($messageParts, "\n");
            }

            throw new RequestException($message);
        }
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
