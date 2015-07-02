<?php

namespace Lns\SocialFeed\Source;

use Lns\SocialFeed\Model\Feed;

class MixedSource implements SourceInterface
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
            $feed->merge($source->getFeed());
        }

        return $feed;
    }
}
