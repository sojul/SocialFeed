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

use League\OAuth2\Client\Provider\Instagram as InstagramProvider;
use Webmozart\KeyValueStore\Api\KeyValueStore;

class InstagramTokenProvider
{
    private $clientId;
    private $clientSecret;
    private $redirectUri;
    private $provider;
    private $store;
    private $code;

    public function __construct(
        $clientId,
        $clientSecret,
        $redirectUri,
        KeyValueStore $store = null
    ) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->redirectUri = $redirectUri;

        if (!$store) {
            $store = new \Webmozart\KeyValueStore\ArrayStore();
        }

        $this->store = $store;

        $this->provider = new InstagramProvider(array(
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'redirectUri' => $redirectUri,
        ));
    }

    public function getAuthorizationUrl()
    {
        // reset previous code
        return $this->provider->getAuthorizationUrl();
    }

    /**
     * when you receive code from instagram use this setter to set the code, then use getToken method.
     *
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    public function getToken($refreshToken = false)
    {
        // if reset token is not true try to get access token from the store
        if (!$refreshToken) {
            $accessToken = $this->store->get('token');

            if ($accessToken) {
                return $accessToken;
            }
        }

        if (!$this->code) {
            new \RuntimeException('please try authorize the app using getAuthorizationUrl method');
        }

        $token = $this->provider->getAccessToken('authorization_code', array(
            'code' => $this->code,
        ))->getToken();

        $this->store->set('token', $token);

        return $token;
    }

    public function getStore()
    {
        return $this->store;
    }
}
