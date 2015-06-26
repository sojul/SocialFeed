<?php

namespace Lns\SocialFeed\Source;

use Lns\SocialFeed\Model\Feed;

interface SourceInterface
{
    /**
     * getFeed
     *
     * @return Feed
     */
    public function getFeed();
}
