<?php

namespace Lns\SocialFeed\Model;

class AbstractPost implements PostInterface
{
    protected $identifier;

    public function getIdentifier()
    {
        return $this->identifier;
    }
}
