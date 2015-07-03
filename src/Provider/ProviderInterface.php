<?php

namespace Lns\SocialFeed\Provider;

use Lns\SocialFeed\Model\Feed;

interface ProviderInterface
{
    /**
     * getFeed
     *
     * @return Feed
     */
    public function getFeed(array $options = array());
    public function getName();
}
