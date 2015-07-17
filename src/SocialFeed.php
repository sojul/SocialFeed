<?php

namespace Lns\SocialFeed;

use Lns\SocialFeed\Provider\ProviderInterface;
use Lns\SocialFeed\Model\Feed;
use Lns\SocialFeed\Model\ResultSet;

class SocialFeed implements ProviderInterface
{
    protected $sources;

    public function addSource(SourceInterface $source)
    {
        $this->sources[] = $source;
        return $this;
    }

    public function getResult(array $options = array()) {
        $feed = new Feed();

        foreach($this->sources as $source) {
            $provider = $source->getProvider();
            $feed->merge($provider->getResult($source->getOptions()));
        }

        return new ResultSet($feed->sort());
    }

    public function getName()
    {
        return 'social_feed';
    }

}
