<?php

namespace Lns\SocialFeed\Store;

use Webmozart\KeyValueStore\Api\KeyValueStore;
use Lns\SocialFeed\Model\FeedInterface;

class WebmozartKeyValueStoreAdapter implements StoreInterface
{
    public function __construct(KeyValueStore $keyValueStore)
    {
        $this->keyValueStore = $keyValueStore;
    }

    public function set($key, FeedInterface $feed) {
        return $this->keyValueStore->set($key, $feed);
    }

    public function get($key) {
        return $this->keyValueStore->get($key);
    }

    public function getOrFail($key) {
        return $this->keyValueStore->getOrFail($key);
    }

    public function getMultiple(array $keys, $default = null) {
        return $this->keyValueStore->getOrFail($key);
    }

    public function getMultipleOrFail(array $keys) {
        return $this->keyValueStore->getMultipleOrFail($keys);
    }

    public function remove($key) {
        return $this->keyValueStore->getMultipleOrFail($keys);
    }

    public function exists($key) {
        return $this->keyValueStore->exists($key);
    }

    public function clear() {
        return $this->keyValueStore->exists($key);
    }

    public function keys() {
        return $this->keyValueStore->keys($key);
    }
}

