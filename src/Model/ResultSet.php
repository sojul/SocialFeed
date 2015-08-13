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

/**
 * ResultSet.
 */
class ResultSet implements ResultSetInterface
{
    protected $nextResultSetOptions = array();
    protected $iterator;

    /**
     * @param FeedInterface $feed
     * @param array         $nextResultSetOptions
     */
    public function __construct(FeedInterface $feed, array $nextResultSetOptions = array())
    {
        $this->iterator = $feed->getIterator();
        $this->nextResultSetOptions = $nextResultSetOptions;
    }

    public function getNextResultSetOptions()
    {
        return $this->nextResultSetOptions;
    }

    public function hasNextResultSet()
    {
        return !empty($this->nextResultSetOptions);
    }

    public function getIterator()
    {
        return $this->iterator;
    }
}
