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

interface ResultSetInterface extends \IteratorAggregate
{
    /**
     * __construct.
     *
     * @param FeedInterface  $feed
     * @param array          $requestParameters   request parameters generating this feed
     * @param TokenInterface $nextPaginationToken
     */
    public function __construct(FeedInterface $feed, array $requestParameters, TokenInterface $nextPaginationToken = null);

    /**
     * getRequestParameters.
     *
     * @return array
     */
    public function getRequestParameters();

    /**
     * getNextPaginationParameters.
     *
     * @return TokenInterface
     */
    public function getNextPaginationToken();

    /**
     * hasNextResultSet.
     *
     * @return bool
     */
    public function hasNextResultSet();
}
