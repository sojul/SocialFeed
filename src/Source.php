<?php

namespace Lns\SocialFeed;

use Lns\SocialFeed\Provider\ProviderInterface;

class Source implements SourceInterface
{
    private $provider;
    private $options;

    public function __construct(ProviderInterface $provider, array $options = array())
    {
        $this->provider = $provider;
        $this->options = $options;
    }

    public function getProvider()
    {
        return $this->provider;
    }

    public function getOptions()
    {
        return $this->options;
    }
}
