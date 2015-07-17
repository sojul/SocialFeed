<?php

namespace Lns\SocialFeed;

use Lns\SocialFeed\Model\Feed;
use Lns\SocialFeed\Model\ResultSet;
use Lns\SocialFeed\Provider\ProviderInterface;
use Lns\SocialFeed\Iterator\SourceIterator;

class SocialFeed implements ProviderInterface
{
    protected $sources;

    public function addSource(SourceInterface $source)
    {
        $this->sources[] = $source;
        return $this;
    }

    public function getResult(array $options = array()) {
        new SourceIterator($source);

        foreach($this->sources as $source) {
            $iterators[] = new SourceIterator($source);
        }
    }

    public function getName()
    {
        return 'social_feed';
    }

}
