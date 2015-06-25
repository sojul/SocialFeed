<?php

namespace Lns\SocialFeed\Client;

use Lns\SocialFeed\Client\FacebookRequestFactory;
use Facebook\FacebookResponse;

class FacebookOgClient
{
    private $facebookRequestFactory;

    /**
     * __construct
     *
     * @param FacebookRequestFactory $facebookRequestFactory
     */
    public function __construct(FacebookRequestFactory $facebookRequestFactory)
    {
        $this->facebookRequestFactory = $facebookRequestFactory;
    }

    /**
     * get
     *
     * @param string $query
     * @param FacebookResponse $object
     */
    public function get($query)
    {
        return $this
            ->facebookRequestFactory
            ->create('GET', $query)
            ->execute();
    }
}
