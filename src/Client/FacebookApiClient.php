<?php

/*
 * This file is part of the Social Feed Util.
 *
 * (c) LaNetscouade <contact@lanetscouade.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Lns\SocialFeed\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException as GuzzleRequestException;
use Lns\SocialFeed\Exception\RequestException;

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

    public function get($path, array $options = array())
    {
        $client = $this->createGuzzleClient($this->clientKey, $this->clientSecret);

        try {
            return $response = $client->get('/v2.3'.$path, $options)->json();
        } catch (GuzzleRequestException $e) {
            $message = $e->getMessage();

            if ($e->hasResponse()) {
                $responseData = $e->getResponse()->json();
                $message = $responseData['error']['code'].' - '.$responseData['error']['message'];
            }

            throw new RequestException($message);
        }
    }

    protected function createGuzzleClient($clientKey, $clientSecret)
    {
        $client = new Client(array(
            'base_url' => 'https://graph.facebook.com',
            'defaults' => array(
                'query' => array(
                    'access_token' => $clientKey.'|'.$clientSecret,
                ),
            ),
        ));

        return $client;
    }
}
