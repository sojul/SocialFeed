<?php

namespace Lns\SocialFeed;

use Lns\SocialFeed\Provider\ProviderInterface;
use Lns\SocialFeed\Model\Feed;

class SocialFeed implements ProviderInterface
{
    protected $sources;

    public function addSource(SourceInterface $source)
    {
        $this->sources[] = $source;
        return $this;
    }

    public function getFeed(array $options = array()) {
        $feed = new Feed();

        foreach($this->sources as $source) {
            $provider = $source->getProvider();
            $feed->merge($provider->getFeed($source->getOptions()));
        }

        return $feed->sort();
    }

    public function getName()
    {
        return 'social_feed';
    }

}
