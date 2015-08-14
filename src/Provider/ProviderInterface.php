<?php

/*
 * This file is part of the Social Feed Util.
 *
 * (c) LaNetscouade <contact@lanetscouade.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Lns\SocialFeed\Provider;

use Lns\SocialFeed\Model\ResultSetInterface;

interface ProviderInterface
{
    /**
     * getResult.
     *
     * @param array $parameters
     *
     * @return ResultSetInterface
     */
    public function get(array $parameters = array());

    /**
     * Return next result set from a result set.
     *
     * @param ResultSetInterface $resultSetInterface
     *
     * @return ResultSetInterface
     */
    public function next(ResultSetInterface $resultSet);

    /**
     * getName.
     *
     * @return string
     */
    public function getName();
}
