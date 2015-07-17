<?php

namespace Lns\SocialFeed\Model;

class FacebookPost extends AbstractPost implements PostInterface
{
    public function getType()
    {
        return 'facebook_post';
    }
}
