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

/**
 * WebmozartKeyValueStoreAdapter.
 */
class WebmozartKeyValueStoreAdapter implements StoreInterface
{
    /**
     * __construct.
     *
     * @param KeyValueStore $keyValueStore
     */
    public function __construct(KeyValueStore $keyValueStore)
    {
        $this->keyValueStore = $keyValueStore;
    }

    /**
     * set.
     *
     * @param $key
     * @param FeedInterface $feed
     */
    public function set($key, FeedInterface $feed)
    {
        return $this->keyValueStore->set($key, $feed);
    }

    /**
     * get.
     *
     * @param $key
     */
    public function get($key)
    {
        return $this->keyValueStore->get($key);
    }

    /**
     * getOrFail.
     *
     * @param $key
     */
    public function getOrFail($key)
    {
        return $this->keyValueStore->getOrFail($key);
    }

    /**
     * getMultiple.
     *
     * @param array $keys
     * @param $default
     */
    public function getMultiple(array $keys, $default = null)
    {
        return $this->keyValueStore->getOrFail($key);
    }

    /**
     * getMultipleOrFail.
     *
     * @param array $keys
     */
    public function getMultipleOrFail(array $keys)
    {
        return $this->keyValueStore->getMultipleOrFail($keys);
    }

    /**
     * remove.
     *
     * @param $key
     */
    public function remove($key)
    {
        return $this->keyValueStore->getMultipleOrFail($keys);
    }

    /**
     * exists.
     *
     * @param $key
     */
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
