<?php

/*
 * This file is part of the Social Feed Util.
 *
 * (c) LaNetscouade <contact@lanetscouade.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Lns\SocialFeed\Model;

interface ResultSetInterface extends \IteratorAggregate
{
    /**
     * __construct.
     *
     * @param FeedInterface $feed
     * @param array         $nextResultSetOptions
     */
    public function __construct(FeedInterface $feed, array $nextResultSetOptions = array());
    public function getNextResultSetOptions();
    public function hasNextResultSet();
}
