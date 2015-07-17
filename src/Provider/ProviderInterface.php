<?php

namespace Lns\SocialFeed\Provider;

use Lns\SocialFeed\Model\Feed;

interface ProviderInterface
{
    /**
     * getResult
     *
     * @return ResultSet
     */
    public function getResult(array $options = array());
    public function getName();
}
