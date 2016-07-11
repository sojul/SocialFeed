<?php

namespace Lns\SocialFeed\Client;

use League\OAuth2\Client\Provider\Instagram as InstagramProvider;
use Webmozart\KeyValueStore\Api\KeyValueStore;
use Lns\SocialFeed\Provider\InstagramUserMediaProvider;
use Lns\SocialFeed\Client\InstagramApiClient;
use Lns\SocialFeed\Factory\InstagramPostFactory;
use Lns\SocialFeed\SocialFeed;
use Lns\SocialFeed\Source;

class InstagramTokenProvider
{
    private $clientId;
    private $clientSecret;
    private $redirectUri;
    private $provider;
    private $store;

    public function __construct(
        $clientId,
        $clientSecret,
        $redirectUri,
        KeyValueStore $store = null
    )
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->redirectUri = $redirectUri;

        if (!$store) {
            $store = new \Webmozart\KeyValueStore\ArrayStore();
        }

        $this->store = $store;

        $this->provider = new InstagramProvider([
            'clientId' => $clientId,
            'clientSecret' => $clientSecret,
            'redirectUri' => $redirectUri,
        ]);
    }

    public function getAuthorizationUrl()
    {
        // reset previous code
        return $this->provider->getAuthorizationUrl();
    }

    /**
     * when you receive code from instagram use this setter to set the code, then use getToken method
     *
     * @param string $code
     */
    public function setCode($code) {
        $this->store->set('code', $code);

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

        $code = $this->store->get('code');

        if (!$code) {
            new \RuntimeException('please try authorize the app using getAuthorizationUrl method');
        }

        $token = $this->provider->getAccessToken('authorization_code', [
            'code' => $code
        ])->getToken();

        $this->store->set('token', $token);

        return $token;
    }

    public function getStore() {
        return $this->store;
    }
}
