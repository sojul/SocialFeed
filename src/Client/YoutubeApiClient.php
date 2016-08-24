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

/**
 * YoutubeApiClient.
 */
class YoutubeApiClient extends AbstractClient implements ClientInterface
{
    private $client;
    private $apiKey;

    /**
     * __construct.
     *
     * @param $key
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * createGuzzleClient.
     *
     * @param $consumerKey
     * @param $consumerSecret
     */
    protected function createGuzzleClient($apiKey)
    {
        return new Client([
            'base_uri' => 'https://www.googleapis.com',
            'query' => array(
                'key' => $apiKey,
            ),
        ]);
    }

    /**
     * get.
     *
     * @param $path
     * @param array $options
     */
    public function get($path, array $options = array())
    {
        $client = $this->createGuzzleClient($this->apiKey);

        $options = $this->applyDefaultClientQuery($client, $options);

        try {
            return json_decode($client->get('/youtube/v3' . $path, $options)->getBody(), true);
        } catch (GuzzleRequestException $e) {
            $message = $e->getMessage();
            throw new RequestException($message);
        }
    }
}

