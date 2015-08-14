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
    /**
     * iterator.
     *
     * @var \Iterator
     */
    protected $iterator;

    /**
     * nextRequestParameters.
     *
     * @var array
     */
    protected $requestParameters;

    /**
     * nextPaginationParameters.
     *
     * @var array
     */
    protected $nextPaginationParameters;

    /**
     * {@inheritdoc}
     */
    public function __construct(FeedInterface $feed, array $requestParameters, array $nextPaginationParameters = array())
    {
        $this->iterator = $feed->getIterator();
        $this->requestParameters = $requestParameters;
        $this->nextPaginationParameters = $nextPaginationParameters;
    }

    /**
     * {@inheritdoc}
     */
    public function getNextPaginationParameters()
    {
        return $this->nextPaginationParameters;
    }

    /**
     * {@inheritdoc}
     */
    public function hasNextResultSet()
    {
        return !empty($this->nextPaginationParameters);
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator()
    {
        return $this->iterator;
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestParameters()
    {
        return $this->requestParameters;
    }
}
