<?php

namespace Lns\SocialFeed\Model;

class Tweet extends AbstractPost implements PostInterface
{
    public function getType()
    {
        return 'tweet';
    }
}
