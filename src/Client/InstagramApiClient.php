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

/**
 * InstagramApiClient.
 */
class InstagramApiClient implements ClientInterface
{
    private $clientId;
    private $clientSecret;

    /**
     * __construct.
     *
     * @param $clientId
     * @param $clientSecret
     */
    public function __construct($clientId, $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    /**
     * createGuzzleClient.
     *
     * @param $clientId
     */
    protected function createGuzzleClient($clientId)
    {
        $client = new Client(array(
            'base_url' => 'https://api.instagram.com/',
            'defaults' => array(
                'query' => array(
                    'client_id' => $clientId,
                ),
            ),
        ));

        return $client;
    }

    /**
     * get.
     *
     * @param $path
     * @param array $options
     */
    public function get($path, array $options = array())
    {
        $client = $this->createGuzzleClient($this->clientId);

        return $client->get($path, $options)->json();
    }
}
