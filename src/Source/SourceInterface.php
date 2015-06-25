<?php

namespace Lns\SocialFeed\Source;

use Lns\SocialFeed\Model\Feed;

interface SourceInterface
{
    /**
     * getFeed
     *
     * @param string $query
     * @return Feed
     */
    public function getFeed($query);
}
