<?php

namespace Lns\SocialFeed\Model;

class InstagramPost extends AbstractPost implements PostInterface
{
    public function getType()
    {
        return 'instagram_post';
    }
}
