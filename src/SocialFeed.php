<?php

namespace Lns\SocialFeed;

use Lns\SocialFeed\Provider\ProviderInterface;

class SocialFeed
{
    protected $providers;

    public function addProvider(ProviderInterface $provider)
    {
        $this->providers[] = $provider;
        return $this;
    }

}
