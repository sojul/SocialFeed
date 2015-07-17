<?php

namespace Lns\SocialFeed\Store;

use Lns\SocialFeed\Model\FeedInterface;

interface StoreInterface
{
    public function set($key, FeedInterface $feed);
    public function get($key);
    public function remove($key);
    public function exists($key);
    public function clear();
    public function keys();
}
