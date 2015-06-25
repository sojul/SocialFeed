<?php

namespace Lns\SocialFeed\Client;

use Facebook\FacebookSession;
use Facebook\FacebookRequest;

class FacebookRequestFactory
{
    private $facebookSession;

    public function __construct(FacebookSession $facebookSession)
    {
        $this->facebookSession = $facebookSession;
    }

    public function create($verb, $url)
    {
        return new FacebookRequest($this->facebookSession, $verb, $url);
    }
}
