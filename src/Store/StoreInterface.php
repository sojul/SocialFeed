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

interface StoreInterface
{
    /**
     * set.
     *
     * @param $key
     * @param FeedInterface $feed
     */
    public function set($key, FeedInterface $feed);
    public function get($key);
    /**
     * remove.
     *
     * @param $key
     */
    public function remove($key);
    public function exists($key);
    public function clear();
    public function keys();
}
