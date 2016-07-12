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
class InstagramApiClient extends AbstractClient implements ClientInterface
{
    private $accessToken;

    /**
     * __construct.
     *
     * @param $accessToken
     * @param $clientSecret
     */
    public function __construct($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * createGuzzleClient.
     *
     * @param $accesToken
     */
    protected function createGuzzleClient($accessToken)
    {
        return new Client(array(
            'base_uri' => 'https://api.instagram.com/',
            'query' => array(
                'access_token' => $accessToken,
            ),
        ));
    }

    /**
     * get.
     *
     * @param $path
     * @param array $options
     */
    public function get($path, array $options = array())
    {
        $client = $this->createGuzzleClient($this->accessToken);

        $options = $this->applyDefaultClientQuery($client, $options);

        return json_decode($client->get($path, $options)->getBody(), true);
    }
}
