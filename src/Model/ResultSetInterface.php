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
     * @param array         $requestParameters        request parameters generating this feed
     * @param array         $nextPaginationParameters
     */
    public function __construct(FeedInterface $feed, array $requestParameters, array $nextPaginationParameters = array());

    /**
     * getRequestParameters.
     *
     * @return array
     */
    public function getRequestParameters();

    /**
     * getNextPaginationParameters.
     *
     * @return array
     */
    public function getNextPaginationParameters();

    /**
     * hasNextResultSet.
     *
     * @return bool
     */
    public function hasNextResultSet();
}
