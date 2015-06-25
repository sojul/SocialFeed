<?php

namespace Lns\SocialFeed;

use Lns\SocialFeed\Source\SourceInterface;

class SocialFeed
{
    protected $sources;

    public function addSource(SourceInterface $source)
    {
        $this->sources[] = $source;
        return $this;
    }
}
