<?php

namespace Lns\SocialFeed\Factory;

use Facebook\GraphObject;

interface PostFactoryInterface
{
    public function create(array $data);
}
