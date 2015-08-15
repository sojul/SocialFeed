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

use Lns\SocialFeed\Model\Pagination\TokenInterface;

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
     * nextPaginationToken.
     *
     * @var TokenInterface
     */
    protected $nextPaginationToken;

    /**
     * {@inheritdoc}
     */
    public function __construct(FeedInterface $feed, array $requestParameters, TokenInterface $nextPaginationToken = null)
    {
        $this->iterator = $feed->getIterator();
        $this->requestParameters = $requestParameters;
        $this->nextPaginationToken = $nextPaginationToken;
    }

    /**
     * {@inheritdoc}
     */
    public function getNextPaginationToken()
    {
        return $this->nextPaginationToken;
    }

    /**
     * {@inheritdoc}
     */
    public function hasNextResultSet()
    {
        return $this->nextPaginationToken;
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
