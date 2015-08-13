<?php

/*
 * This file is part of the Social Feed Util.
 *
 * (c) LaNetscouade <contact@lanetscouade.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Lns\SocialFeed\Store;

use Lns\SocialFeed\Model\FeedInterface;
use Webmozart\KeyValueStore\Api\KeyValueStore;

class WebmozartKeyValueStoreAdapter implements StoreInterface
{
    public function __construct(KeyValueStore $keyValueStore)
    {
        $this->keyValueStore = $keyValueStore;
    }

    public function set($key, FeedInterface $feed)
    {
        return $this->keyValueStore->set($key, $feed);
    }

    public function get($key)
    {
        return $this->keyValueStore->get($key);
    }

    public function getOrFail($key)
    {
        return $this->keyValueStore->getOrFail($key);
    }

    public function getMultiple(array $keys, $default = null)
    {
        return $this->keyValueStore->getOrFail($key);
    }

    public function getMultipleOrFail(array $keys)
    {
        return $this->keyValueStore->getMultipleOrFail($keys);
    }

    public function remove($key)
    {
        return $this->keyValueStore->getMultipleOrFail($keys);
    }

    public function exists($key)
    {
        return $this->keyValueStore->exists($key);
    }

    public function clear()
    {
        return $this->keyValueStore->exists($key);
    }

    public function keys()
    {
        return $this->keyValueStore->keys($key);
    }
}
