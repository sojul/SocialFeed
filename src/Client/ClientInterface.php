<?php

namespace Lns\SocialFeed\Client;

interface ClientInterface
{
    public function get($path, array $options = array());
}
