<?php

namespace Lns\SocialFeed\Provider;

interface ProviderInterface
{
    /**
     * getResult.
     *
     * @return ResultSet
     */
    public function getResult(array $options = array());
    public function getName();
}
