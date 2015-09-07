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
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use Lns\SocialFeed\Exception\RequestException;

/**
 * TwitterApiClient.
 */
class TwitterApiClient implements ClientInterface
{
    private $client;
    private $consumerKey;
    private $consumerSecret;

    /**
     * __construct.
     *
     * @param $consumerKey
     * @param $consumerSecret
     */
    public function __construct($consumerKey, $consumerSecret)
    {
        $this->consumerKey = $consumerKey;
        $this->consumerSecret = $consumerSecret;
    }

    /**
     * get.
     *
     * @param $path
     * @param array $options
     */
    public function get($path, array $options = array())
    {
        $client = $this->createGuzzleClient($this->consumerKey, $this->consumerSecret);

        try {
            return $client->get('/1.1'.$path, $options)->json();
        } catch (GuzzleRequestException $e) {
            $message = $e->getMessage();

            if ($e->hasResponse()) {
                $responseData = $e->getResponse()->json();

                $messageParts = array();

                foreach ($responseData['errors'] as $error) {
                    $messageParts[] = $error['message'];
                }

                $message = implode($messageParts, "\n");
            }

            throw new RequestException($message);
        }
    }

    /**
     * createGuzzleClient.
     *
     * @param $consumerKey
     * @param $consumerSecret
     */
    protected function createGuzzleClient($consumerKey, $consumerSecret)
    {
        $client = new Client(array(
            'base_url' => 'https://api.twitter.com',
            'defaults' => array('auth' => 'oauth'),
        ));

        $oauth = new Oauth1(array(
            'consumer_key' => $consumerKey,
            'consumer_secret' => $consumerSecret,
        ));

        $client->getEmitter()->attach($oauth);

        return $client;
    }
}
